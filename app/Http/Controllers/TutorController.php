<?php

namespace App\Http\Controllers;

// Importando classes necessárias do Laravel
use Illuminate\Http\Request; // Para manipulação de requisições HTTP
use Illuminate\Support\Facades\Auth; // Para autenticação do usuário
use Illuminate\Support\Facades\DB; // Para interações com o banco de dados
use Illuminate\Support\Facades\Validator; // Para validação de dados

// Importando serviços personalizados
use App\Services\VideoService; // Serviço para manipulação de vídeos
use App\Services\RoleCheckService; // Serviço para verificação de papéis de usuário

// Importando modelos das bases de dados
use App\Models\Product; // Modelo de produtos
use App\Models\Teacher; // Modelo de professores
use App\Models\Videos; // Modelo de vídeos
use App\Models\Notification; // Modelo de notificações


class TutorController extends Controller
{

    // ##################################################################
    // #                                                                #
    // #                       PAGINA INICIAL                           #
    // #                                                                #
    // ##################################################################

    public function __construct(RoleCheckService $roleCheckService)
    {
        $this->roleCheckService = $roleCheckService;
    }

    // ==================== PÁGINA HOME DO RESPONSÁVEL ====================
    public function Tutor_home()
    {
        // Obtém o ID do tutor autenticado
        $tutorId = auth()->id();
        // Obtém o ID da entidade do usuário autenticado
        $entityId = Auth::user()->entity_id;

        // Obtém os alunos vinculados ao tutor
        $students = DB::table('student_by_tutor')
            ->join('tb_students', 'student_by_tutor.student_user_id', '=', 'tb_students.student_user_id')
            ->where('student_by_tutor.tutor_user_id', $tutorId)
            ->select('tb_students.*')
            ->get();

        // Redireciona para a página do primeiro aluno se existir
        if ($students->isNotEmpty()) {
            return redirect()->route('tutors.home.student.get', ['student_user_id' => $students->first()->student_user_id]);
        }
            
        // Trata o caso em que não há alunos encontrados
        return redirect('Mainhome')->with('error', 'Nenhum aluno encontrado.');
    }

    // ==================== PÁGINA INICIAL DO TUTOR ====================
    public function Tutor_home_page($studentUserId = null)
    {
        // Validação de Usuário: verifica se o usuário possui a função de tutor
        if (!$this->roleCheckService->checkUserRole(['tutor'])) {
            return redirect('Mainhome')->with('error', 'Você não tem acesso a esta página.');
        }

        // Obtém o ID do tutor autenticado
        $tutorId = auth()->id();
        // Obtém o ID da entidade do usuário autenticado
        $entityId = Auth::user()->entity_id;

        // Obtém os alunos vinculados ao tutor
        $students = DB::table('student_by_tutor')
            ->join('tb_students', 'student_by_tutor.student_user_id', '=', 'tb_students.student_user_id')
            ->where('student_by_tutor.tutor_user_id', $tutorId)
            ->select('tb_students.*')
            ->get();

        // Conta as notificações não lidas do tutor
        $unreadCount = Notification::where('tb_notifications.entity_id', $entityId)
            ->where('tb_notifications.for_user_id', $tutorId)
            ->whereNull('read_at') // Verifica se read_at é nulo
            ->count();

        // Se nenhum aluno foi selecionado, traz o primeiro
        if (is_null($studentUserId) && $students->isNotEmpty()) {
            $studentUserId = $students->first()->student_user_id;
        }

        // Passa os dados dos alunos e o aluno selecionado (se houver) para a view
        return view('tutors.tutorhome', compact('students', 'studentUserId', 'unreadCount'));
    }


    // ##################################################################
    // #                                                                #
    // #                   VERIFICAÇÃO DE TAREFAS                       #
    // #                                                                #
    // ##################################################################

    // ==================== TAREFAS DO ALUNO ====================
    public function Homework_table_page($studentUserId)
    {
        // Validação de Usuário: verifica se o usuário possui a função de tutor
        if (!$this->roleCheckService->checkUserRole(['tutor'])) {
            return redirect('Mainhome')->with('error', 'Você não tem acesso a esta página.');
        }

        // Obtém o ID do tutor autenticado
        $tutorId = auth()->id();

        // Obtém os alunos vinculados ao tutor
        $students = DB::table('student_by_tutor')
            ->join('tb_students', 'student_by_tutor.student_user_id', '=', 'tb_students.student_user_id')
            ->where('student_by_tutor.tutor_user_id', $tutorId)
            ->select('tb_students.*')
            ->get();

        // Encontra o aluno selecionado com base no ID fornecido
        $student = $students->firstWhere('student_user_id', $studentUserId);

        // Obtém informações da classe vinculada ao aluno selecionado
        $classInfo = DB::table('student_by_class')
            ->join('tb_class', 'student_by_class.class_id', '=', 'tb_class.class_id')
            ->where('student_by_class.student_user_id', $studentUserId)
            ->select('tb_class.*')
            ->first();

        // Obtém as tarefas disponíveis para a classe do aluno
        $AvailableHomeworks = DB::table('homework_by_class')
            ->join('tb_homeworks', 'homework_by_class.homework_id', '=', 'tb_homeworks.homework_id')
            ->where('homework_by_class.class_id', $classInfo->class_id)
            ->where('homework_by_class.is_active', true)
            ->select('tb_homeworks.*', 'homework_by_class.*')
            ->get();

        // Obtém as tarefas completadas pelo aluno
        $CompleteHomeworks = DB::table('homework_by_student')
            ->where('student_user_id', $studentUserId)
            ->get();

        // Obtém todas as tarefas, incluindo o status de conclusão
        $homeworks = DB::table('homework_by_class')
            ->join('tb_homeworks', 'homework_by_class.homework_id', '=', 'tb_homeworks.homework_id')
            ->leftJoin('homework_by_student', function($join) use ($studentUserId) {
                $join->on('homework_by_class.homework_id', '=', 'homework_by_student.homework_id')
                    ->where('homework_by_student.student_user_id', $studentUserId);
            })
            ->where('homework_by_class.class_id', $classInfo->class_id)
            ->where('homework_by_class.is_active', true)
            ->select(
                'tb_homeworks.homework_id',
                'homework_by_class.description', 
                'homework_by_class.release_date', 
                'homework_by_class.due_date', 
                DB::raw('IF(homework_by_student.updated_at IS NOT NULL, "Completed", "Available") as status'),
                'homework_by_student.updated_at as submission_date'
            )
            ->get();
            
        // Retorna a view com as informações necessárias
        return view('tutors.homeworks.homeworks_table', compact('student', 'students', 'studentUserId', 'classInfo', 'AvailableHomeworks', 'CompleteHomeworks', 'homeworks'));
    }


    // ##################################################################
    // #                                                                #
    // #                 VERIFICAÇÃO DE ATIVIDADE                       #
    // #                                                                #
    // ##################################################################

    // ==================== ATIVIDADES DO ALUNO ====================
    public function Activities_table_page($studentUserId)
    {
        // Validação de Usuário: verifica se o usuário possui a função de tutor
        if (!$this->roleCheckService->checkUserRole(['tutor'])) {
            return redirect('Mainhome')->with('error', 'Você não tem acesso a esta página.');
        }

        // Obtém o ID do tutor autenticado
        $tutorId = auth()->id();

        // Obtém os alunos vinculados ao tutor
        $students = DB::table('student_by_tutor')
            ->join('tb_students', 'student_by_tutor.student_user_id', '=', 'tb_students.student_user_id')
            ->where('student_by_tutor.tutor_user_id', $tutorId)
            ->select('tb_students.*')
            ->get();

        // Encontra o aluno selecionado com base no ID fornecido
        $student = $students->firstWhere('student_user_id', $studentUserId);

        // Obtém informações da classe vinculada ao aluno selecionado
        $classInfo = DB::table('student_by_class')
            ->join('tb_class', 'student_by_class.class_id', '=', 'tb_class.class_id')
            ->where('student_by_class.student_user_id', $studentUserId)
            ->select('tb_class.*')
            ->first();

        // Obtém as atividades disponíveis para a classe do aluno
        $AvailableActivities = DB::table('activities_by_class')
            ->join('tb_activities', 'activities_by_class.activity_id', '=', 'tb_activities.activity_id')
            ->where('activities_by_class.class_id', $classInfo->class_id)    
            ->where('activities_by_class.is_active', true) 
            ->select('tb_activities.*')
            ->get();

        // Obtém as atividades completadas pelo aluno
        $CompleteActivities = DB::table('activities_by_student')
            ->where('student_user_id', $studentUserId)
            ->get();

        // Obtém todas as atividades, incluindo o status de conclusão
        $activities = DB::table('activities_by_class')
            ->join('tb_activities', 'activities_by_class.activity_id', '=', 'tb_activities.activity_id')
            ->leftJoin('activities_by_student', function($join) use ($studentUserId) {
                $join->on('activities_by_class.activity_id', '=', 'activities_by_student.activity_id')
                    ->where('activities_by_student.student_user_id', $studentUserId);
            })
            ->where('activities_by_class.class_id', $classInfo->class_id)
            ->where('activities_by_class.is_active', true)
            ->select(
                'tb_activities.activity_id',
                'tb_activities.activity_name',
                'activities_by_student.times_completed',
                DB::raw('IF(activities_by_student.times_completed IS NOT NULL, "Completed", "Available") as status'),
                'activities_by_student.updated_at as last_completed_time'
            )
            ->get();

        // Retorna a view com as informações necessárias
        return view('tutors.activities.activities_table', compact('student', 'students', 'studentUserId', 'classInfo', 'AvailableActivities', 'CompleteActivities', 'activities'));
    }
    

    // ##################################################################
    // #                                                                #
    // #                 VERIFICAÇÃO DE BOLETIM                         #
    // #                                                                #
    // ##################################################################

    // ==================== ATIVIDADES DO ALUNO ====================
    public function Grades_table_page($studentUserId)
    {
        // Validação de Usuário: verifica se o usuário possui a função de tutor
        if (!$this->roleCheckService->checkUserRole(['tutor'])) {
            return redirect('Mainhome')->with('error', 'Você não tem acesso a esta página.');
        }

        // Obtém o ID do tutor autenticado
        $tutorId = auth()->id();

        // Obtém os alunos vinculados ao tutor
        $students = DB::table('student_by_tutor')
            ->join('tb_students', 'student_by_tutor.student_user_id', '=', 'tb_students.student_user_id')
            ->where('student_by_tutor.tutor_user_id', $tutorId)
            ->select('tb_students.*')
            ->get();

        // Encontra o aluno selecionado com base no ID fornecido
        $student = $students->firstWhere('student_user_id', $studentUserId);

        // Obtém todos os conceitos de disciplinas
        $concepts = DB::table('tb_subjects_concepts')->get();

        // Consulta para obter o relatório de notas do aluno
        $gradeReportRaw = DB::table('tb_student_grade_evaluation as sge')
            ->join('tb_class as c', 'sge.class_id', '=', 'c.class_id')
            ->join('tb_student_grades as sg', 'sge.evaluation_id', '=', 'sg.evaluation_id')
            ->join('tb_class_subjects_syllabus as css', 'sg.class_syllabus_id', '=', 'css.class_syllabus_id')
            ->join('tb_class_subjects as cs', 'css.class_subject_id', '=', 'cs.class_subject_id')
            ->join('tb_subjects_concepts as sc', 'sg.concept_id', '=', 'sc.concept_id')
            ->select(
                'c.class_name',
                'c.class_year',
                'cs.class_subject_name',
                'css.class_syllabus_name',
                'sc.concept_abbreviation',
                'sge.evaluation_number',
                'sg.grade_id',
                'sg.updated_at as submission_date'
            )
            ->where('sge.student_user_id', $studentUserId)
            ->get();

        // Processa os dados do relatório de notas para agrupamento
        $gradeReport = [];
        foreach ($gradeReportRaw as $grade) {
            // Cria chaves para a classe e a disciplina
            $classKey = "{$grade->class_name} - {$grade->class_year}";
            $subjectKey = "{$grade->class_subject_name} - {$grade->class_syllabus_name}";

            // Armazena as avaliações e a data de submissão
            $gradeReport[$classKey][$subjectKey]['evaluations'][$grade->evaluation_number] = $grade->concept_abbreviation;
            $gradeReport[$classKey][$subjectKey]['submission_date'] = $grade->submission_date ?? 'N/A';
        }

        // Retorna a view com as informações necessárias
        return view('tutors.grades.grades_table', compact('student', 'students', 'studentUserId', 'gradeReport', 'concepts'));
    }


    // ##################################################################
    // #                                                                #
    // #                          NOTIFICAÇÃO                           #
    // #                                                                #
    // ##################################################################

    // ==================== NOTIFICAÇÕES ====================
    public function Notifications_home($studentUserId)
    {
        // Validação de Usuário: verifica se o usuário possui a função de tutor
        if (!$this->roleCheckService->checkUserRole(['tutor'])) {
            return redirect('Mainhome')->with('error', 'Você não tem acesso a esta página.');
        }
        
        // Obtém o ID da entidade e do usuário autenticado
        $entityId = Auth::user()->entity_id;
        $userId = Auth::user()->user_id;

        // Marca as notificações não lidas como lidas
        Notification::where('entity_id', $entityId)
            ->where('for_user_id', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        // Recupera as notificações do tutor, incluindo o nome do professor que enviou
        $notifications = Notification::where('tb_notifications.entity_id', $entityId)
            ->where('tb_notifications.for_user_id', $userId)
            ->leftJoin('tb_teachers as t', 'tb_notifications.from_user_id', '=', 't.teacher_user_id')
            ->select('tb_notifications.*', 't.teacher_name')
            ->orderBy('tb_notifications.created_at', 'desc')
            ->paginate(10); // Paginação das notificações, mostrando 10 por página

        // Retorna a view com as notificações e o ID do aluno
        return view('tutors.notifications.notification_home', compact('notifications', 'studentUserId'));
    }


    // ##################################################################
    // #                                                                #
    // #                           RELATÓRIOS                           #
    // #                                                                #
    // ##################################################################

    // ==================== RELATÓRIOS ====================
    public function Reporst_Home($studentUserId)
    {
        // Retorna a view principal de relatórios, passando o ID do aluno
        return view('tutors.reports.reportshome', compact('studentUserId'));
    }

    // ==================== PÁGINA DE RELATÓRIOS DE FREQUÊNCIA ====================
    public function Frequency_reports_table($studentUserId)
    {
        // Retorna a view para relatórios de frequência, passando o ID do aluno
        return view('tutors.reports.frequencyreportstable', compact('studentUserId'));
    }

    // ==================== BUSCA DADOS DE FREQUÊNCIA ====================
    public function fetchFrequencyData(Request $request, $studentUserId)
    {
        $entityId = auth()->user()->entity_id;

        // Relatório Anual de Frequência
        $yearlyData = DB::select("
            SELECT 
                tc.class_year,
                COUNT(sf.preset) AS total_count,
                SUM(CASE WHEN sf.preset = 1 THEN 1 ELSE 0 END) AS present_count,
                ROUND((SUM(CASE WHEN sf.preset = 1 THEN 1 ELSE 0 END) * 100.0) / COUNT(sf.preset), 2) AS present_percentage
            FROM tb_frequency_table AS ft
            JOIN tb_class AS tc ON ft.class_id = tc.class_id
            JOIN tb_student_frequency AS sf ON ft.frequency_table_id = sf.frequency_table_id
            WHERE ft.entity_id = ?
            AND sf.student_user_id = ?
            GROUP BY tc.class_year
            ORDER BY tc.class_year;
        ", [$entityId, $studentUserId]);

        // Relatório por Turma
        $classData = DB::select("
            SELECT 
                tc.class_name, tc.class_year,
                COUNT(sf.preset) AS total_count,
                SUM(CASE WHEN sf.preset = 1 THEN 1 ELSE 0 END) AS present_count,
                ROUND((SUM(CASE WHEN sf.preset = 1 THEN 1 ELSE 0 END) * 100.0) / COUNT(sf.preset), 2) AS present_percentage
            FROM tb_frequency_table AS ft
            JOIN tb_class AS tc ON ft.class_id = tc.class_id
            JOIN tb_student_frequency AS sf ON ft.frequency_table_id = sf.frequency_table_id
            WHERE ft.entity_id = ?
            AND sf.student_user_id = ?
            GROUP BY tc.class_name, tc.class_year
            ORDER BY tc.class_name, tc.class_year;
        ", [$entityId, $studentUserId]);

        // Relatório por Aluno
        $studentData = DB::select("
            SELECT 
                tc.class_name, tc.class_year, st.student_name,
                COUNT(sf.preset) AS total_count,
                SUM(CASE WHEN sf.preset = 1 THEN 1 ELSE 0 END) AS present_count,
                ROUND((SUM(CASE WHEN sf.preset = 1 THEN 1 ELSE 0 END) * 100.0) / COUNT(sf.preset), 2) AS present_percentage
            FROM tb_frequency_table AS ft
            JOIN tb_class AS tc ON ft.class_id = tc.class_id
            JOIN tb_student_frequency AS sf ON ft.frequency_table_id = sf.frequency_table_id
            JOIN tb_students AS st ON st.student_user_id = sf.student_user_id
            WHERE ft.entity_id = ?
            AND st.student_user_id = ?
            GROUP BY tc.class_name, tc.class_year, st.student_name
            ORDER BY tc.class_name, tc.class_year, st.student_name;
        ", [$entityId, $studentUserId]);

        // Retorna os dados de frequência como JSON
        return response()->json(['yearly' => $yearlyData, 'class' => $classData, 'student' => $studentData]);
    }

    // ==================== PÁGINA DE RELATÓRIOS DE NOTAS ====================
    public function Grades_reports_table($studentUserId)
    {
        // Retorna a view para relatórios de notas, passando o ID do aluno
        return view('tutors.reports.gradesreportstable', compact('studentUserId'));
    }

    // ==================== BUSCA DADOS DE NOTAS ====================
    public function fetchGradesData(Request $request, $studentUserId)
    {
        $entityId = auth()->user()->entity_id;

        // Notas por Turma
        $classData = DB::select("
            SELECT 
                ROUND(SUM(sc.concept_weight) / COUNT(sc.concept_weight), 2) AS media,
                c.class_name,
                c.class_year,
                sge.evaluation_number
            FROM tb_student_grade_evaluation AS sge
            JOIN tb_student_grades AS sg ON sge.evaluation_id = sg.evaluation_id
            JOIN tb_subjects_concepts AS sc ON sg.concept_id = sc.concept_id
            JOIN tb_class AS c ON sge.class_id = c.class_id
            WHERE sge.entity_id = ?
            AND sge.student_user_id = ?
            GROUP BY sge.evaluation_number, c.class_name, c.class_year
            ORDER BY c.class_year, sge.evaluation_number;
        ", [$entityId, $studentUserId]);
        
        // Notas com Disciplina por Turma
        $subjectsData = DB::select("
            SELECT 
                ROUND(SUM(sc.concept_weight) / COUNT(sc.concept_weight), 2) AS media,
                c.class_name,
                c.class_year,
                sge.evaluation_number,
                cs.class_subject_name
            FROM tb_student_grade_evaluation AS sge
            JOIN tb_student_grades AS sg ON sge.evaluation_id = sg.evaluation_id
            JOIN tb_subjects_concepts AS sc ON sg.concept_id = sc.concept_id
            JOIN tb_class AS c ON sge.class_id = c.class_id 
            JOIN tb_class_subjects_syllabus AS css ON sg.class_syllabus_id = css.class_syllabus_id
            JOIN tb_class_subjects AS cs ON css.class_subject_id = cs.class_subject_id
            WHERE sge.entity_id = ?
            AND sge.student_user_id = ?
            GROUP BY c.class_name, c.class_year, sge.evaluation_number, cs.class_subject_name
            ORDER BY c.class_year, c.class_name, sge.evaluation_number;
        ", [$entityId, $studentUserId]);

        // Retorna os dados de notas como JSON
        return response()->json(['class' => $classData, 'subject' => $subjectsData]);
    }

    // ==================== PÁGINA DE RELATÓRIOS DE ATIVIDADES ====================
    public function Activities_reports_table($studentUserId)
    {
        // Retorna a view para relatórios de atividades, passando o ID do aluno
        return view('tutors.reports.activitiesreporttable', compact('studentUserId'));
    }

    // ==================== BUSCA DADOS DE ATIVIDADES ====================
    public function fetchActivitiesData(Request $request, $studentUserId)
    {
        $entityId = auth()->user()->entity_id;

        // Atividades por aluno
        $activitiesData = DB::select("
            SELECT 
                s.student_name,
                a.activity_name,
                SUM(asb.times_completed) AS total_times_completed
            FROM activities_by_student asb
            JOIN tb_students s ON asb.student_user_id = s.student_user_id
            JOIN tb_activities a ON asb.activity_id = a.activity_id
            WHERE s.entity_id = ?
            AND s.student_user_id = ?
            GROUP BY s.student_user_id, s.student_name, a.activity_name;
        ", [$entityId, $studentUserId]);

        // Resumo das atividades no ano atual
        $yearsData = DB::select("
            SELECT 
                a.activity_name,
                SUM(asb.times_completed) AS total_times_completed
            FROM activities_by_student asb
            JOIN tb_students s ON asb.student_user_id = s.student_user_id
            JOIN tb_activities a ON asb.activity_id = a.activity_id
            WHERE YEAR(asb.created_at) = YEAR(CURRENT_DATE)  -- Filtra para o ano atual
            AND s.entity_id = ?
            AND s.student_user_id = ?
            GROUP BY a.activity_name;
        ", [$entityId, $studentUserId]);

        // Retorna os dados de atividades como JSON
        return response()->json(['activitiesData' => $activitiesData, 'yearsData' => $yearsData]);
    }


    // ##################################################################
    // #                                                                #
    // #                 VISUALIZAÇÃO DE VÍDEOS                         #
    // #                                                                #
    // ##################################################################

    // ==================== PAGINA HOME VÍDEOS ====================
    public function Videos_home_page($studentUserId)
    {
        // Validação de Usuário
        if (!$this->roleCheckService->checkUserRole(['tutor'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        $entityId = Auth::user()->entity_id;

        // Obtém vídeos ordenados por data de atualização
        $videos = DB::table('tb_videos')
            ->join('tb_teachers', 'tb_teachers.teacher_user_id', '=', 'tb_videos.teacher_user_id')
            ->where('tb_videos.entity_id', $entityId) 
            ->select('tb_videos.*', 'tb_teachers.teacher_name')
            ->orderBy('tb_videos.updated_at', 'desc')
            ->get();

        return view('tutors.videos.videos_home', compact('videos', 'studentUserId'));
    }



}
    