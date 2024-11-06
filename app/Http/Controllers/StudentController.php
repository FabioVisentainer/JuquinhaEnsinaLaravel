<?php

namespace App\Http\Controllers;

// Importando classes do Laravel
use Illuminate\Http\Request; // Para manipulação de requisições HTTP
use Illuminate\Support\Facades\Auth; // Para autenticação de usuários
use Illuminate\Support\Facades\DB; // Para interações com o banco de dados
use Illuminate\Support\Facades\Validator; // Para validação de dados

// Importando serviços personalizados
use App\Services\VideoService; // Serviço para manipulação de vídeos
use App\Services\RoleCheckService; // Serviço para verificação de papéis de usuário

// Importando modelos das bases de dados
use App\Models\Student; // Modelo de estudantes
use App\Models\Teacher; // Modelo de professores
use App\Models\Videos; // Modelo de vídeos


class StudentController extends Controller
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

    // ==================== PAGINA HOME DO COORDENADOR ====================
    public function Student_home()
    {
        // Validação de Usuário
        if (!$this->roleCheckService->checkUserRole(['student'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }
    
        // Pegar o Id do usuário atual
        $studentUserId = auth()->id();
        $entityId = Auth::user()->entity_id;
    
        $student = Student::where('student_user_id', $studentUserId)->first();
    
        return view('students.studenthome', compact('student'));
    }


    // ##################################################################
    // #                                                                #
    // #                   VERIFICAÇÃO DE TAREFAS                       #
    // #                                                                #
    // ##################################################################

    // ==================== TAREFAS DO ALUNO ====================
    public function Homework_table_page()
    {
        // Validação de Usuário
        if (!$this->roleCheckService->checkUserRole(['student'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        // Pegar o ID do usuário atual
        $studentUserId = auth()->id();
        $entityId = Auth::user()->entity_id;

        // Recupera informações do estudante
        $student = Student::where('student_user_id', $studentUserId)->first();
        
        // Classe vinculada ao aluno selecionado
        $classInfo = DB::table('student_by_class')
            ->join('tb_class', 'student_by_class.class_id', '=', 'tb_class.class_id')
            ->where('student_by_class.student_user_id', $studentUserId)
            ->select('tb_class.*')
            ->first(); 

        // Recupera tarefas disponíveis para a classe do aluno
        $AvailableHomeworks = DB::table('homework_by_class')
            ->join('tb_homeworks', 'homework_by_class.homework_id', '=', 'tb_homeworks.homework_id')
            ->where('homework_by_class.class_id', $classInfo->class_id)
            ->where('homework_by_class.is_active', true)
            ->select('tb_homeworks.*', 'homework_by_class.*')
            ->get();

        // Recupera as tarefas completas do aluno
        $CompleteHomeworks = DB::table('homework_by_student')
            ->where('student_user_id', $studentUserId)
            ->get();
            
        // Retorna a visão com as informações das tarefas
        return view('students.homeworks_table', compact('student', 'studentUserId', 'classInfo', 'AvailableHomeworks', 'CompleteHomeworks'));
    }

    // ##################################################################
    // #                                                                #
    // #                 VERIFICAÇÃO DE ATIVIDADE                       #
    // #                                                                #
    // ##################################################################

    // ==================== ATIVIDADES DO ALUNO ====================
    public function Activities_table_page()
    {
        // Validação de Usuário
        if (!$this->roleCheckService->checkUserRole(['student'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        // Pegar o ID do usuário atual
        $studentUserId = auth()->id();
        $entityId = Auth::user()->entity_id;

        // Recupera informações do estudante
        $student = Student::where('student_user_id', $studentUserId)->first();

        // Classe vinculada ao aluno selecionado
        $classInfo = DB::table('student_by_class')
            ->join('tb_class', 'student_by_class.class_id', '=', 'tb_class.class_id')
            ->where('student_by_class.student_user_id', $studentUserId)
            ->select('tb_class.*')
            ->first(); 

        // Recupera atividades disponíveis para a classe do aluno
        $AvailableActivities = DB::table('activities_by_class')
            ->join('tb_activities', 'activities_by_class.activity_id', '=', 'tb_activities.activity_id')
            ->where('activities_by_class.class_id', $classInfo->class_id)    
            ->where('activities_by_class.is_active', true) 
            ->select('tb_activities.*')
            ->get();

        // Retorna a visão com as informações das atividades
        return view('students.activities_table', compact('student', 'studentUserId', 'classInfo', 'AvailableActivities'));
    }

    // ##################################################################
    // #                                                                #
    // #                        ENVIO DE VÍDEOS                         #
    // #                                                                #
    // ##################################################################

    // ==================== ENVIO DE VÍDEOS ====================
    // ==================== PAGINA HOME VÍDEOS ====================
    public function Videos_home_page()
    {
        // Validação de Usuário
        if (!$this->roleCheckService->checkUserRole(['student'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }
    
        // Obtém o ID da entidade do usuário autenticado
        $entityId = Auth::user()->entity_id;
    
        // Recupera os vídeos ordenados pela data de atualização
        $videos = DB::table('tb_videos')
            ->join('tb_teachers', 'tb_teachers.teacher_user_id', '=', 'tb_videos.teacher_user_id')
            ->where('tb_videos.entity_id', $entityId) 
            ->select('tb_videos.*', 'tb_teachers.teacher_name')
            ->orderBy('tb_videos.updated_at', 'desc')
            ->get();
        
        // Retorna a visão com a lista de vídeos
        return view('students.videos.videos_home', compact('videos'));
    }

}
