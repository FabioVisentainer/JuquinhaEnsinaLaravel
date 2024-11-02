<?php

namespace App\Http\Controllers;

// Importando classes necessárias do Laravel
use Illuminate\Http\Request; // Para manipulação de requisições HTTP
use Illuminate\Support\Facades\Auth; // Para autenticação do usuário
use Illuminate\Support\Facades\DB; // Para interações com o banco de dados
use Illuminate\Support\Facades\Validator; // Para validação de dados

// Importando serviços personalizados
use App\Services\RoleCheckService; // Para verificação de papéis de usuário
use App\Services\VideoService; // Para funcionalidades relacionadas a vídeos

// Importando modelos das bases de dados
use App\Models\User; // Modelo de usuário
use App\Models\Videos; // Modelo de vídeos
use App\Models\Teacher; // Modelo de professores
use App\Models\ClassModel; // Modelo de classes
use App\Models\FrequencyTable; // Modelo de tabelas de frequência
use App\Models\Activity; // Modelo de atividades
use App\Models\Homework; // Modelo de tarefas
use App\Models\StudentGradeEvaluation; // Modelo de avaliações de notas de alunos
use App\Models\StudentGrade; // Modelo de notas de alunos
use App\Models\Student; // Modelo de alunos
use App\Models\ClassSubjectSyllabus; // Modelo de disciplinas de classes
use App\Models\SubjectConcept; // Modelo de conceitos de disciplinas



class TeacherController extends Controller
{
    
    // ##################################################################
    // #                                                                #
    // #                       PAGINA INICIAL                           #
    // #                                                                #
    // ##################################################################

    public function __construct(RoleCheckService $roleCheckService)
    {
        // Inicializa o serviço de verificação de papéis para gerenciar permissões de acesso
        $this->roleCheckService = $roleCheckService;
    }

    // ==================== PÁGINA HOME DO PROFESSOR ====================
    public function Teacher_home_page()
    {
        // Verifica se o usuário tem o papel de 'teacher'
        if (!$this->roleCheckService->checkUserRole(['teacher'])) {
            return redirect('Mainhome')->with('error', 'Você não tem acesso a esta página.');
        }
        
        // Retorna a view da página inicial do professor
        return view('teachers.teacherhome');
    }


    // ##################################################################
    // #                                                                #
    // #                     CADASTROS DE TAREFAS                       #
    // #                                                                #
    // ##################################################################

    // ==================== CADASTROS DE TAREFAS ====================
    // ==================== PÁGINA HOME - SELECIONAR TURMA ====================
    public function Homework_home_page()
    {
        // Verifica se o usuário tem o papel de 'teacher'
        if (!$this->roleCheckService->checkUserRole(['teacher'])) {
            return redirect('Mainhome')->with('error', 'Você não tem acesso a esta página.');
        }
        
        $entityId = Auth::user()->entity_id; // Obtém o ID da entidade do usuário autenticado
        $userId = Auth::id(); // Obtém o ID do usuário autenticado

        // Obtém as classes associadas ao professor, evitando problemas de ID
        $classes = DB::table('tb_class')
            ->join('teacher_by_class', 'tb_class.class_id', '=', 'teacher_by_class.class_id')
            ->where('teacher_by_class.teacher_user_id', $userId) // Filtra pela ID do usuário
            ->where('teacher_by_class.entity_id', $entityId) // Filtra pela ID da entidade
            ->select('tb_class.*') // Seleciona todas as colunas da tabela tb_class
            ->get();
    
        // Debug: Exibe o resultado das classes (descomente se necessário)
        // dd($classes->toArray());

        // Retorna a view com as classes obtidas
        return view('teachers.homeworks.homeworks_home', compact('classes'));
    }

    // ==================== PÁGINA DE TAREFAS - TABELA DE TAREFAS ====================
    public function Homework_table_page($class_id)
    {
        // Verifica se o usuário tem o papel de 'teacher'
        if (!$this->roleCheckService->checkUserRole(['teacher'])) {
            return redirect('Mainhome')->with('error', 'Você não tem acesso a esta página.');
        }

        $entityId = Auth::user()->entity_id; // Obtém o ID da entidade do usuário autenticado
        $userId = Auth::id(); // Obtém o ID do usuário autenticado
        $class = ClassModel::findOrFail($class_id); // Busca a classe pelo ID, ou gera um erro se não encontrar

        // Obtém todas as entradas de tarefas
        $homeworks = Homework::all();

        // Recupera registros de tarefas relacionadas e seu status de liberação para a classe e entidade especificadas
        $relatedHomeworks = DB::table('homework_by_class')
            ->where('class_id', $class_id) // Filtra pela ID da classe
            ->where('entity_id', $entityId) // Filtra pela ID da entidade
            ->get(['homework_id', 'is_active', 'due_date', 'release_date', 'description'])
            ->keyBy('homework_id'); // Converte para um array associativo com chave 'homework_id'

        // Debug: Exibe o resultado dos deveres relacionados (descomente se necessário)
        // dd($relatedHomeworks);

        // Obtém alunos com tarefas incompletas na classe especificada
        $studentsWithIncompleteHomeworks = DB::table('student_by_class as sbc')
            ->join('homework_by_class as hbc', 'sbc.class_id', '=', 'hbc.class_id')
            ->join('tb_homeworks as h', 'hbc.homework_id', '=', 'h.homework_id')
            ->leftJoin('homework_by_student as hbs', function ($join) {
                $join->on('sbc.student_user_id', '=', 'hbs.student_user_id')
                    ->on('hbc.homework_id', '=', 'hbs.homework_id');
            })
            ->join('tb_students as s', 'sbc.student_user_id', '=', 's.student_user_id')
            ->where('sbc.class_id', $class_id) // Filtra pela ID da classe
            ->whereNull('hbs.homework_id') // Seleciona apenas alunos sem tarefas associadas
            ->select('sbc.student_user_id', 's.student_name', 'h.homework_id', 'h.homework_name', 'hbc.description', 'hbc.due_date')
            ->orderBy('hbc.due_date', 'asc') // Ordena pela data de vencimento
            ->get();

        // Debug: Exibe os alunos com tarefas incompletas (descomente se necessário)
        // dd($studentsWithIncompleteHomeworks);

        // Retorna a view com os dados coletados
        return view('teachers.homeworks.homeworks_table', compact('class', 'homeworks', 'relatedHomeworks', 'studentsWithIncompleteHomeworks'));
    }

    // ==================== ATUALIZAÇÃO DE TAREFAS ====================
    public function Homework_update(Request $request, $class_id)
    {
        $entityId = Auth::user()->entity_id; // Obtém o ID da entidade do usuário autenticado
        $teacherUserId = Auth::id(); // Obtém o ID do professor autenticado

        // Passo 2: Prepara os dados para validação, incluindo apenas entradas marcadas
        $dataToValidate = [];
        foreach ($request->input('homework') as $homeworkId => $data) {
            if ($data['is_active'] == '1') { // Inclui apenas entradas marcadas
                $dataToValidate[$homeworkId] = $data;
            }
        }

        // Passo 3: Valida os dados
        $validator = Validator::make($dataToValidate, [
            '*.description' => 'required|string', // A descrição é obrigatória e deve ser uma string
            '*.due_date' => 'required|date', // A data de vencimento é obrigatória e deve ser uma data
            '*.release_date' => 'required|date|before_or_equal:*.due_date', // A data de liberação deve ser antes ou igual à data de vencimento
        ]);

        // Verifica se a validação falha
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput(); // Redireciona de volta com erros
        }

        // Passo 1: Deleta todos os registros para a entidade e classe especificadas
        DB::table('homework_by_class')
            ->where('entity_id', $entityId)
            ->where('class_id', $class_id)
            ->delete();

        // Passo 4: Salva os dados
        foreach ($dataToValidate as $homeworkId => $data) {
            DB::table('homework_by_class')->insert([
                'homework_id' => $homeworkId, // ID da tarefa
                'class_id' => $class_id, // ID da classe
                'entity_id' => $entityId, // ID da entidade
                'description' => $data['description'], // Descrição da tarefa
                'due_date' => $data['due_date'], // Data de vencimento da tarefa
                'release_date' => $data['release_date'], // Data de liberação da tarefa
                'is_active' => 1, // Define is_active como 1 (tarefa marcada)
                'teacher_user_id' => $teacherUserId, // ID do professor
                'created_at' => now(), // Timestamp de criação
                'updated_at' => now(), // Timestamp de atualização
            ]);
        }

        // Redireciona para a tabela de tarefas com mensagem de sucesso
        return redirect()->route('teachers.homework.table', ['class_id' => $class_id])
            ->with('success', 'Tarefas atualizadas com sucesso.');
    }


    // ##################################################################
    // #                                                                #
    // #                   CADASTROS DE ATIVIDADES                      #
    // #                                                                #
    // ##################################################################

    // ==================== CADASTROS DE ATIVIDADES ====================
    // ==================== PÁGINA HOME - SELECIONAR TURMA ====================
    public function Activity_home_page()
    {
        // Verifica se o usuário tem o papel de 'teacher'
        if (!$this->roleCheckService->checkUserRole(['teacher'])) {
            return redirect('Mainhome')->with('error', 'Você não tem acesso a esta página.');
        }
        
        $entityId = Auth::user()->entity_id; // Obtém o ID da entidade do usuário autenticado
        $userId = Auth::id(); // Obtém o ID do usuário autenticado

        // Obtém as classes diretamente para evitar problemas com teacher_id vs teacher_user_id
        $classes = DB::table('tb_class')
            ->join('teacher_by_class', 'tb_class.class_id', '=', 'teacher_by_class.class_id')
            ->where('teacher_by_class.teacher_user_id', $userId) // Filtra pela ID do usuário (professor)
            ->where('teacher_by_class.entity_id', $entityId) // Filtra pela ID da entidade
            ->select('tb_class.*') // Seleciona todas as colunas da tabela tb_class
            ->get();
    
        // Debug: Exibe as classes obtidas (descomente se necessário)
        // dd($classes->toArray());

        // Retorna a view com as classes obtidas
        return view('teachers.activities.activities_home', compact('classes'));
    }

    // ==================== PÁGINA DE ATIVIDADES - TABELA DE ATIVIDADES ====================
    public function Activity_table_page($class_id)
    {
        // Verifica se o usuário tem o papel de 'teacher'
        if (!$this->roleCheckService->checkUserRole(['teacher'])) {
            return redirect('Mainhome')->with('error', 'Você não tem acesso a esta página.');
        }
        
        $entityId = Auth::user()->entity_id; // Obtém o ID da entidade do usuário autenticado
        $userId = Auth::id(); // Obtém o ID do usuário autenticado
        $class = ClassModel::findOrFail($class_id); // Busca a classe pelo ID, ou gera um erro se não encontrar

        // Obtém todas as atividades
        $activities = Activity::all();

        // Obtém as atividades relacionadas e seu status ativo para a classe e entidade especificadas
        $relatedActivities = DB::table('activities_by_class')
            ->where('class_id', $class_id) // Filtra pela ID da classe
            ->where('entity_id', $entityId) // Filtra pela ID da entidade
            ->pluck('is_active', 'activity_id'); // Pluck para obter um array com o status ativo, indexado pelo ID da atividade

        // Retorna a view com os dados coletados
        return view('teachers.activities.activities_table', compact('class', 'activities', 'relatedActivities'));
    }

    // ==================== ATUALIZAÇÃO DE ATIVIDADES ====================
    public function Activity_update(Request $request, $class_id)
    {
        $entityId = Auth::user()->entity_id; // Obtém o ID da entidade do usuário autenticado
        $teacherUserId = Auth::id(); // Obtém o ID do professor autenticado

        // Recupera os dados de conclusão da requisição
        $completionData = $request->input('completion', []); // Pega os dados ou define como array vazio se não existir

        // Itera sobre os dados de conclusão
        foreach ($completionData as $activityId => $isActive) {
            DB::table('activities_by_class')->updateOrInsert(
                [
                    'entity_id' => $entityId, // ID da entidade
                    'class_id' => $class_id, // ID da classe
                    'activity_id' => $activityId, // ID da atividade
                    'teacher_user_id' => $teacherUserId, // ID do professor
                ],
                [
                    'is_active' => $isActive, // Define 'is_active' com base no checkbox
                    'updated_at' => now(), // Atualiza o timestamp de modificação
                ]
            );
        }

        // Redireciona para a página da tabela de atividades com uma mensagem de sucesso
        return redirect()->route('teachers.activity.table', ['class_id' => $class_id])
            ->with('success', 'Atividades atualizadas com sucesso.');
    }


    // ##################################################################
    // #                                                                #
    // #                   CADASTROS DE FREQUÊNCIAS                     #
    // #                                                                #
    // ##################################################################

    // ==================== CADASTROS DE FREQUÊNCIAS ====================
    // ==================== PÁGINA HOME - SELECIONAR TURMA ====================
    public function Frequency_home_page()
    {
        // Verifica se o usuário tem o papel de 'teacher'
        if (!$this->roleCheckService->checkUserRole(['teacher'])) {
            return redirect('Mainhome')->with('error', 'Você não tem acesso a esta página.');
        }
        
        $entityId = Auth::user()->entity_id; // Obtém o ID da entidade do usuário autenticado
        $userId = Auth::id(); // Obtém o ID do usuário autenticado

        // Obtém as classes diretamente para evitar problemas com teacher_id vs teacher_user_id
        $classes = DB::table('tb_class')
            ->join('teacher_by_class', 'tb_class.class_id', '=', 'teacher_by_class.class_id')
            ->where('teacher_by_class.teacher_user_id', $userId) // Filtra pela ID do professor
            ->where('teacher_by_class.entity_id', $entityId) // Filtra pela ID da entidade
            ->select('tb_class.*') // Seleciona todas as colunas da tabela tb_class
            ->get();
    
        // Debug: Exibe as classes obtidas (descomente se necessário)
        // dd($classes->toArray());

        // Retorna a view com as classes obtidas
        return view('teachers.frequency.frequency_home', compact('classes'));
    }

    // ==================== PÁGINA DE FREQUÊNCIAS - TABELA DE FREQUÊNCIAS ====================
    public function Frequency_table_page($class_id)
    {
        // Verifica se o usuário tem o papel de 'teacher'
        if (!$this->roleCheckService->checkUserRole(['teacher'])) {
            return redirect('Mainhome')->with('error', 'Você não tem acesso a esta página.');
        }
        
        $entityId = Auth::user()->entity_id; // Obtém o ID da entidade do usuário autenticado
        $userId = Auth::id(); // Obtém o ID do usuário autenticado
        $class = ClassModel::findOrFail($class_id); // Busca a classe pelo ID, ou gera um erro se não encontrar

        // Obtém a tabela de frequências para a entidade e classe especificadas
        $frequencytable = FrequencyTable::where('tb_frequency_table.entity_id', $entityId)
            ->where('tb_frequency_table.class_id', $class_id)
            ->get();

        // Debug: Exibe a tabela de frequências obtida (descomente se necessário)
        // dd($frequencytable->toArray());

        // Retorna a view com os dados da classe e da tabela de frequências
        return view('teachers.frequency.frequency_table', compact('class', 'frequencytable'));
    }

    // ==================== CRIAÇÃO DE FREQUÊNCIA ====================
    // ==================== PÁGINA DE CRIAÇÃO DE FREQUÊNCIA ====================
    public function Frequency_create($class_id, $date)
    {
        // Verifica se o usuário tem o papel de 'teacher'
        if (!$this->roleCheckService->checkUserRole(['teacher'])) {
            return redirect('Mainhome')->with('error', 'Você não tem acesso a esta página.');
        }
        
        $entityId = Auth::user()->entity_id; // Obtém o ID da entidade do usuário autenticado
        $userId = Auth::id(); // Obtém o ID do usuário autenticado

        // Obtém os alunos associados à classe especificada
        $associatedStudents = DB::table('tb_students')
            ->join('student_by_class', 'tb_students.student_user_id', '=', 'student_by_class.student_user_id')
            ->where('student_by_class.class_id', $class_id) // Filtra pela ID da classe
            ->select('tb_students.*') // Seleciona todas as colunas da tabela tb_students
            ->get();

        // Debug: Exibe os alunos associados obtidos (descomente se necessário)
        // dd($associatedStudents);

        // Retorna a view de criação de frequência com os dados necessários
        return view('teachers.frequency.frequency_create', compact('class_id', 'date', 'associatedStudents'));
    }

    // ==================== ARMAZENAMENTO DE FREQUÊNCIA ====================
    // ==================== FUNÇÃO PARA ARMAZENAR FREQUÊNCIA ====================
    public function Frequency_store(Request $request)
    {
        // Obtém o ID da entidade do usuário autenticado
        $entityId = Auth::user()->entity_id;
        $classId = $request->input('class_id'); // Obtém o ID da classe do pedido
        $date = $request->input('date'); // Obtém a data do pedido
        $attendanceData = $request->input('attendance', []); // Obtém os dados de presença, ou define como array vazio

        // Verifica se já existe um registro para a classe e data especificadas
        $frequencyTableEntry = DB::table('tb_frequency_table')
            ->where('entity_id', $entityId)
            ->where('class_id', $classId)
            ->where('frequency_date', $date)
            ->first();

        // Criando registro na tabela de frequências
        if (!$frequencyTableEntry) {
            // Se não existir, insere um novo registro e obtém seu ID
            $frequencyTableId = DB::table('tb_frequency_table')->insertGetId([
                'entity_id' => $entityId,
                'class_id' => $classId,
                'frequency_date' => $date,
            ]);
        } else {
            // Se já existir, utiliza o ID do registro existente
            $frequencyTableId = $frequencyTableEntry->frequency_table_id;
        }

        // Inserindo os dados de presença dos estudantes na tabela
        foreach ($attendanceData as $studentId => $present) {
            DB::table('tb_student_frequency')->updateOrInsert(
                [
                    'entity_id' => $entityId, // ID da entidade
                    'student_user_id' => $studentId, // ID do estudante
                    'frequency_table_id' => $frequencyTableId, // ID da tabela de frequências
                ],
                [
                    'preset' => $present, // Define a presença (verdadeiro/falso)
                ]
            );
        }

        // Redireciona para a tabela de frequências com uma mensagem de sucesso
        return redirect()->route('teachers.frequency.table', ['class_id' => $classId])
            ->with('success', 'Frequência registrada com sucesso.');
    }

    // ==================== EDIÇÃO DE FREQUÊNCIA ====================
    // ==================== FUNÇÃO PARA EDITAR FREQUÊNCIA ====================
    public function Frequency_edit($class_id, $frequency_table_id)
    {
        // Verifica se o usuário tem o papel de 'teacher'
        if (!$this->roleCheckService->checkUserRole(['teacher'])) {
            return redirect('Mainhome')->with('error', 'Você não tem acesso a esta página.');
        }

        $entityId = Auth::user()->entity_id; // Obtém o ID da entidade do usuário autenticado

        // Busca a entrada de frequência correspondente
        $frequency = DB::table('tb_frequency_table')
            ->where('frequency_table_id', $frequency_table_id)
            ->where('entity_id', $entityId)
            ->first();

        // Verifica se o registro de frequência foi encontrado
        if (!$frequency) {
            return redirect()->route('teachers.frequency.home')->with('error', 'Registro de frequência não encontrado.');
        }

        // Busca os registros de presença para esta frequência
        $attendanceRecords = DB::table('tb_student_frequency')
            ->where('frequency_table_id', $frequency_table_id)
            ->where('entity_id', $entityId)
            ->get();

        // Retorna a view de edição de frequência com os dados necessários
        return view('teachers.frequency.frequency_edit', compact('frequency', 'attendanceRecords', 'class_id'));
    }

    // ==================== ATUALIZAÇÃO DE FREQUÊNCIA ====================
    // ==================== FUNÇÃO PARA ATUALIZAR FREQUÊNCIA ====================
    public function Frequency_update(Request $request, $frequency_table_id, $classId)
    {
        $entityId = Auth::user()->entity_id; // Obtém o ID da entidade do usuário autenticado
        $attendanceData = $request->input('attendance', []); // Obtém os dados de presença do pedido

        // Atualiza ou insere os dados de presença dos alunos
        foreach ($attendanceData as $studentId => $present) {
            DB::table('tb_student_frequency')->updateOrInsert(
                [
                    'entity_id' => $entityId, // ID da entidade
                    'student_user_id' => $studentId, // ID do estudante
                    'frequency_table_id' => $frequency_table_id, // ID da tabela de frequência
                ],
                [
                    'preset' => $present, // Define a presença (verdadeiro/falso)
                ]
            );
        }

        // Redireciona para a tabela de frequências com uma mensagem de sucesso
        return redirect()->route('teachers.frequency.table', ['class_id' => $classId])
            ->with('success', 'Frequência atualizada com sucesso.');
    }


    // ##################################################################
    // #                                                                #
    // #                   CADASTROS DE BOLETINS                        #
    // #                                                                #
    // ##################################################################

    // ==================== CADASTROS DE NOTAS ====================
    // ==================== PÁGINA INICIAL PARA SELECIONAR TURMA ====================
    public function Grades_home_page()
    {
        // Verifica a permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['teacher'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        $entityId = Auth::user()->entity_id;
        $userId = Auth::id();

        // Obtém as classes associadas ao professor
        $classes = DB::table('tb_class')
            ->join('teacher_by_class', 'tb_class.class_id', '=', 'teacher_by_class.class_id')
            ->where('teacher_by_class.teacher_user_id', $userId)
            ->where('teacher_by_class.entity_id', $entityId)
            ->select('tb_class.*')
            ->get();

        return view('teachers.grades.grades_home', compact('classes'));
    }

    // ==================== PÁGINA DE NOTAS PARA A TURMA ====================
    public function Grades_table_page($class_id)
    {
        // Verifica a permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['teacher'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        $entityId = Auth::user()->entity_id;
        $class = ClassModel::findOrFail($class_id);

        // Obtém os alunos da turma
        $students = DB::table('tb_students')
            ->join('student_by_class', 'tb_students.student_user_id', '=', 'student_by_class.student_user_id')
            ->where('student_by_class.class_id', $class_id)
            ->where('student_by_class.entity_id', $entityId)
            ->select('tb_students.*')
            ->get();

        // Obtém as avaliações dos alunos
        $evaluations = StudentGradeEvaluation::where('tb_student_grade_evaluation.entity_id', $entityId)
            ->where('tb_student_grade_evaluation.class_id', $class_id)
            ->get();

        return view('teachers.grades.grades_table', compact('class', 'students', 'evaluations'));
    }

    // ==================== PÁGINA PARA CRIAR NOTAS DE UM ALUNO ====================
    public function Grades_create($student_user_id, $classId)
    {
        // Verifica a permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['teacher'])) {
            return redirect('Mainhome')->with('error', 'Você não tem acesso a esta página.');
        }

        $entityId = Auth::user()->entity_id;
        $student = User::findOrFail($student_user_id);

        // Obtém o último número de avaliação do aluno
        $lastEvaluationNumber = StudentGradeEvaluation::where('entity_id', $entityId)
            ->where('student_user_id', $student_user_id)
            ->where('class_id', $classId)
            ->max('evaluation_number');

        // Define o novo número de avaliação
        $newEvaluationNumber = $lastEvaluationNumber ? $lastEvaluationNumber + 1 : 1;

        // Obtém o plano de ensino e os conceitos disponíveis para avaliação
        $classSyllabus = DB::table('subject_by_class')
            ->join('tb_class_subjects', 'subject_by_class.class_subject_id', '=', 'tb_class_subjects.class_subject_id')
            ->join('tb_class_subjects_syllabus', 'tb_class_subjects.class_subject_id', '=', 'tb_class_subjects_syllabus.class_subject_id')
            ->where('subject_by_class.class_id', $classId)
            ->where('tb_class_subjects.is_active', true)
            ->where('tb_class_subjects_syllabus.is_active', true)
            ->where('subject_by_class.entity_id', $entityId)
            ->select('tb_class_subjects_syllabus.*', 'tb_class_subjects.class_subject_name')
            ->get();

        $concepts = SubjectConcept::all();

        return view('teachers.grades.grades_create', compact('newEvaluationNumber', 'student', 'classSyllabus', 'concepts', 'classId', 'student_user_id'));
    }

    // ==================== ARMAZENAR NOTAS ====================
    public function Grades_store(Request $request)
    {
        $request->validate([
            'entity_id' => 'required|integer',
            'teacher_user_id' => 'required|integer',
            'student_user_id' => 'required|integer',
            'class_id' => 'required|integer',
            'concepts' => 'required|array',
            'concepts.*' => 'required|integer|exists:tb_subjects_concepts,concept_id',
        ]);

        $entityId = Auth::user()->entity_id;
        $student_user_id = $request->student_user_id;
        $classId = $request->class_id;

        // Obtém o último número de avaliação
        $lastEvaluationNumber = StudentGradeEvaluation::where('entity_id', $entityId)
            ->where('student_user_id', $student_user_id)
            ->where('class_id', $classId)
            ->max('evaluation_number');

        // Define o novo número de avaliação
        $newEvaluationNumber = $lastEvaluationNumber ? $lastEvaluationNumber + 1 : 1;

        // Cria o registro de avaliação
        $evaluation = StudentGradeEvaluation::create([
            'entity_id' => $entityId,
            'student_user_id' => $student_user_id,
            'class_id' => $classId,
            'evaluation_number' => $newEvaluationNumber,
        ]);

        $evaluationId = $evaluation->evaluation_id;
        if (!$evaluationId) {
            return redirect()->back()->withErrors(['msg' => 'Failed to retrieve evaluation ID.']);
        }

        // Loop pelas notas e cria registros
        foreach ($request->input('concepts') as $classSyllabusId => $conceptId) {
            StudentGrade::create([
                'entity_id' => $request->entity_id,
                'teacher_user_id' => Auth::id(),
                'class_syllabus_id' => $classSyllabusId,
                'concept_id' => $conceptId,
                'evaluation_id' => $evaluationId,
            ]);
        }

        return redirect()->route('teachers.grades.table', $classId)->with('success', 'Notas adicionadas com sucesso.');
    }

    // ==================== PÁGINA PARA EDITAR NOTAS ====================
    public function Grades_edit($student_user_id, $evaluation_id, $classId)
    {
        $entityId = Auth::user()->entity_id;
        $student = User::findOrFail($student_user_id);
        $evaluation = StudentGradeEvaluation::findOrFail($evaluation_id);

        // Obtém o plano de ensino e as notas do aluno
        $classSyllabus = DB::table('tb_student_grades')
            ->join('tb_class_subjects_syllabus', 'tb_class_subjects_syllabus.class_syllabus_id', '=', 'tb_student_grades.class_syllabus_id')
            ->join('tb_class_subjects', 'tb_class_subjects.class_subject_id', '=', 'tb_class_subjects_syllabus.class_subject_id')
            ->where('tb_student_grades.entity_id', $entityId)
            ->where('tb_student_grades.evaluation_id', $evaluation->evaluation_id)
            ->select('tb_student_grades.*', 'tb_class_subjects_syllabus.*', 'tb_class_subjects.class_subject_name')
            ->get();

        $concepts = SubjectConcept::all();

        return view('teachers.grades.grades_edit', compact('evaluation', 'student', 'classSyllabus', 'concepts', 'classId', 'student_user_id'));
    }

    // ==================== ATUALIZAR NOTAS ====================
    public function Grades_update(Request $request, $evaluation_id)
    {
        $teacher_user_id = Auth::id();
        $concepts = $request->input('concepts', []);

        foreach ($concepts as $class_syllabus_id => $concept_id) {
            DB::table('tb_student_grades')
                ->where('evaluation_id', $evaluation_id)
                ->where('class_syllabus_id', $class_syllabus_id)
                ->update([
                    'concept_id' => $concept_id,
                    'teacher_user_id' => $teacher_user_id,
                    'updated_at' => now(),
                ]);
        }

        return redirect()->route('teachers.grades.table', $request->input('class_id'))
            ->with('success', 'Notas atualizadas com sucesso.');
    }


    // ##################################################################
    // #                                                                #
    // #                        ENVIO DE VÍDEOS                         #
    // #                                                                #
    // ##################################################################

    // ==================== ENVIO DE VÍDEOS ====================
    // ==================== PÁGINA INICIAL VÍDEOS ====================
    public function Videos_home_page()
    {
        // Verifica a permissão do usuário para acessar a página
        if (!$this->roleCheckService->checkUserRole(['teacher'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        $entityId = Auth::user()->entity_id;

        // Obtém os vídeos ordenados por data de atualização
        $videos = DB::table('tb_videos')
            ->join('tb_teachers', 'tb_teachers.teacher_user_id', '=', 'tb_videos.teacher_user_id')
            ->where('tb_videos.entity_id', $entityId) 
            ->select('tb_videos.*', 'tb_teachers.teacher_name')
            ->orderBy('tb_videos.updated_at', 'desc')
            ->get();

        // Retorna a view com os vídeos disponíveis
        return view('teachers.videos.videos_home', compact('videos'));
    }

    // ==================== ARMAZENAMENTO DE VÍDEOS ====================
    public function Videos_store(Request $request)
    {
        // Validação dos dados do vídeo
        $request->validate([
            'video_url' => [
                'required',
                'url',
                'max:255',
                function ($attribute, $value, $fail) {
                    // Verifica se o URL é do YouTube
                    if (!preg_match('/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.?be)/', $value)) {
                        $fail('The ' . $attribute . ' must be a valid YouTube URL.');
                    }
                },
            ],
            'video_name' => 'required|string|max:255',
        ]);

        // Insere o vídeo na tabela
        DB::table('tb_videos')->insert([
            'entity_id' => Auth::user()->entity_id,
            'teacher_user_id' => Auth::id(),
            'video_url' => $request->video_url,
            'video_name' => $request->video_name,
            'video_approval' => true, // Define como aprovado por padrão
        ]);

        // Redireciona para a página inicial de vídeos com mensagem de sucesso
        return redirect()->route('teachers.videos.home')->with('success', 'Video added successfully.');
    }

    // ==================== DELEÇÃO DE VÍDEOS ====================
    public function Videos_delete($video_id)
    {
        // Remove o vídeo da tabela
        DB::table('tb_videos')->where('video_id', $video_id)->delete();

        // Redireciona para a página inicial de vídeos com mensagem de sucesso
        return redirect()->route('teachers.videos.home')->with('success', 'Video deleted successfully.');
    }
}