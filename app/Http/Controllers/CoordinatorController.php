<?php

namespace App\Http\Controllers;

// Importando classes necessárias do Laravel
use Illuminate\Http\Request; // Para manipulação de requisições HTTP
use Illuminate\Support\Facades\Auth; // Para autenticação do usuário
use Illuminate\Support\Facades\DB; // Para interações com o banco de dados

// Importando modelos das bases de dados
use App\Models\User; // Modelo de usuário
use App\Models\Student; // Modelo de alunos
use App\Models\Tutor; // Modelo de tutores
use App\Models\Address; // Modelo de endereços
use App\Models\City; // Modelo de cidades
use App\Models\Teacher; // Modelo de professores
use App\Models\ClassSubject; // Modelo de disciplinas
use App\Models\ClassSubjectSyllabus; // Modelo de disciplinas de classes
use App\Models\ClassModel; // Modelo de classes
use App\Models\Chronogram; // Modelo de cronogramas
use App\Models\Homework; // Modelo de tarefas
use App\Models\StudentByTutor; // Modelo que relaciona alunos a tutores
use App\Models\Notification; // Modelo de notificações

// Importando serviços personalizados
use App\Services\RoleCheckService; // Para verificação de papéis de usuário

class CoordinatorController extends Controller
{
    protected $roleCheckService;


    // ##################################################################
    // #                                                                #
    // #                       PAGINA INICIAL                           #
    // #                                                                #
    // ##################################################################

    // ==================== VALIDAÇÃO DE USUÁRIO ====================
    public function __construct(RoleCheckService $roleCheckService)
    {
        $this->roleCheckService = $roleCheckService; // Inicializa o serviço de verificação de papéis
    }

    // ==================== PÁGINA HOME DO COORDENADOR ====================
    public function coordinator_home_page()
    {
        // Verifica se o usuário tem o papel de 'administrator' ou 'coordinator'
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'Você não tem acesso a esta página.');
        }
        
        return view('coordinators.coordinatorhome');
    }


    // ##################################################################
    // #                                                                #
    // #                    PÁGINAS DE REGISTROS                        #
    // #                alunos/responsáveis/professores                 #
    // ##################################################################

   // ==================== PÁGINA HOME DOS REGISTROS ====================
    public function registries_home_page()
    {
        // Verifica se o usuário tem o papel de 'administrator' ou 'coordinator'
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'Você não tem acesso a esta página.');
        }
        
        return view('coordinators.registries.registries_home');
    }

    // ==================== CADASTROS DE ALUNOS ====================
    // ==================== PÁGINA HOME DOS ALUNOS ====================
    public function students_registries_home_page()
    {
        // Verifica se o usuário tem o papel de 'administrator' ou 'coordinator'
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'Você não tem acesso a esta página.');
        }
        
        $entityId = Auth::user()->entity_id;
        $students = Student::where('entity_id', $entityId)->get();

        return view('coordinators.registries.students.students_home', compact('students'));
    }

    // ==================== FUNÇÃO: CRIAR ALUNO ====================
    public function Student_create()
    {
        // Verifica se o usuário tem o papel de 'administrator' ou 'coordinator'
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'Você não tem acesso a esta página.');
        }
        
        return view('coordinators.registries.students.student_create');
    }
    
    // ==================== FUNÇÃO: SALVAR ALUNO CRIADO ====================
    public function Student_store(Request $request)
    {
        // Verifica se o usuário tem permissão
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'Você não tem acesso a esta página.');
        }

        // Validação dos dados do formulário        
        $validatedData = $request->validate([
            'special_need_id' => 'required|exists:tb_special_needs,special_need_id',
            'student_name' => 'required|string|max:255|min:2',
            'student_gender' => 'required|in:masculine,feminine',
            'student_birth_date' => 'required|date',
            'student_cpf_number' => 'required|string|size:11|unique:tb_students,student_cpf_number',
            'student_registry_date' => 'required|date',
            'password' => 'required|string|min:8',
            'is_active' => 'required|boolean',
        ]);

        // Adicionando o Id da entidade
        $validatedData['entity_id'] = Auth::user()->entity_id;

        // Separando o nome do aluno
        [$firstName, $lastName] = explode(' ', $validatedData['student_name'] . ' ', 2);

        // Criando um usuário para o aluno
        $user = User::create([
            'entity_id' => $validatedData['entity_id'],
            'first_name' => $firstName,
            'last_name' => $lastName ?: $firstName,
            'password_hash' => bcrypt($validatedData['password']),
            'user_role' => 'student',
        ]);

        if ($user) {
            // Salvando o aluno na base de dados
            Student::create(array_merge($validatedData, ['student_user_id' => $user->user_id]));

            return redirect()->route('coordinators.registries.students.home')
                            ->with('success', 'Aluno e usuário registrados com sucesso!');
        } else {
            return redirect()->back()->withErrors(['error' => 'Usuário não pôde ser criado. Tente novamente.']);
        }
    }

    // ==================== FUNÇÃO: EDITAR ALUNO CRIADO ====================
    public function Student_edit($student_Id)
    {
        // Verifica permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'Você não tem acesso a esta página.');
        }

        // Achar o estudante pelo ID
        $student = Student::findOrFail($student_Id);
        
        // Associando tutores
        $associatedTutors = StudentByTutor::where('student_user_id', $student->student_user_id)->with('tutor')->get();

        // Associando classes
        $associatedClasses = DB::table('student_by_class')
                                ->join('tb_class', 'student_by_class.class_id', '=', 'tb_class.class_id')
                                ->where('student_by_class.student_user_id', $student->student_user_id)
                                ->select('tb_class.*')
                                ->get();

        return view('coordinators.registries.students.student_edit', compact('student', 'associatedTutors', 'associatedClasses'));
    }

    // ==================== FUNÇÃO: SALVAR ALUNO EDITADO ====================
    public function Student_update(Request $request, $student_Id)
    {
        // Verifica permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'Você não tem acesso a esta página.');
        }

        // Validação dos dados do formulário
        $validatedData = $request->validate([
            'special_need_id' => 'required|exists:tb_special_needs,special_need_id',
            'student_name' => 'required|string|max:255|min:2',
            'student_gender' => 'required|in:masculine,feminine',
            'student_birth_date' => 'required|date',
            'student_cpf_number' => 'required|string|size:11|unique:tb_students,student_cpf_number,' . $student_Id . ',student_id',
            'student_registry_date' => 'required|date',
            'is_active' => 'required|boolean',
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|min:8',
        ]);

        // Achar o estudante pelo Id
        $student = Student::with('user')->findOrFail($student_Id);

        // Atualizar dados do usuário
        $userData = $request->only(['username']);
        if ($validatedData['password']) {
            $userData['password_hash'] = bcrypt($validatedData['password']);
        }

        $student->user->update($userData);

        // Atualizar o estudante
        $student->update($validatedData);
        
        return redirect()->route('coordinators.registries.students.home')->with('success', 'Aluno atualizado com sucesso!');
    }

    // ==================== FUNÇÃO: SELECIONAR UM RESPONSÁVEL PARA O ALUNO ====================
    public function Student_Select_Tutor($student_Id)
    {
        // Verifica se o usuário tem permissão
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'Você não tem acesso a esta página.');
        }

        // Pegar as informações do estudante pelo Id
        $student = Student::findOrFail($student_Id);

        // Pegar os tutores associados ao estudante
        $associatedTutors = StudentByTutor::where('student_user_id', $student->student_user_id)
            ->with('tutor')
            ->get();

        // Pegar os tutores ativos da mesma entidade
        $tutors = Tutor::where('entity_id', $student->entity_id)
            ->where('is_active', true)
            ->get();

        return view('coordinators.registries.students.select_tutors', compact('tutors', 'student', 'associatedTutors'));
    }

    // ==================== FUNÇÃO: SALVAR O RESPONSÁVEL PARA O ALUNO ====================
    public function Student_Update_Tutor(Request $request, $student_Id)
    {
        // Verifica se o usuário tem permissão
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'Você não tem acesso a esta página.');
        }

        // Validação dos Dados
        $validatedData = $request->validate([
            'tutors' => 'array',
            'tutors.*' => 'exists:tb_tutors,tutor_user_id'
        ]);

        // Pegar os dados do estudante
        $student = Student::with('user')->findOrFail($student_Id);

        // Limpar associações existentes
        DB::table('student_by_tutor')->where('student_user_id', $student->student_user_id)->delete();

        // Preparar dados para gravação
        $dataToAttach = [];
        foreach ($request->tutors as $tutor_user_Id) {
            $dataToAttach[$tutor_user_Id] = [
                'entity_id' => $student->entity_id,
                'student_user_id' => $student->student_user_id
            ];
        }

        // Gravar as novas associações na base de dados
        $student->tutors()->attach($dataToAttach);

        return redirect()->route('coordinators.registries.students.edit', $student_Id)
                        ->with('success', 'Associações de tutores atualizadas com sucesso!');
    }

    // ==================== FUNÇÃO: SALVAR O RESPONSÁVEL PARA O ALUNO (COM SYNC) ====================
    public function Student_Update_Tutor2(Request $request, $student_Id)
    {
        // Verifica se o usuário tem permissão
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'Você não tem acesso a esta página.');
        }

        // Validação dos Dados
        $validatedData = $request->validate([
            'tutors' => 'array',
            'tutors.*' => 'exists:tb_tutors,tutor_user_id'
        ]);

        // Remover duplicados
        $tutors = array_unique($request->tutors);

        // Pegar os dados do estudante
        $student = Student::with('user')->findOrFail($student_Id);

        // Preparar dados para sincronização
        $dataToSync = [];
        foreach ($tutors as $tutorUser_Id) {
            $dataToSync[$tutorUser_Id] = [
                'entity_id' => $student->entity_id,
                'student_user_id' => $student->student_user_id,
            ];
        }

        // Sincronizar as novas associações de tutores com o estudante
        $student->tutors()->sync($dataToSync);

        return redirect()->route('coordinators.registries.students.edit', $student_Id)
                        ->with('success', 'Associações de tutores atualizadas com sucesso!');
    }

    // ==================== FUNÇÃO: REMOVER O RESPONSÁVEL DO ALUNO ====================
    public function Student_Delete_Tutor(Request $request, $student_Id, $tutor_user_Id)
    {
        // Verifica se o usuário tem permissão
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'Você não tem acesso a esta página.');
        }

        // Achar o estudante pelo Id
        $student = Student::findOrFail($student_Id);
        $student_user_Id = $student->student_user_id;

        // Verificar se a associação existe antes de tentar remover
        $associationExists = DB::table('student_by_tutor')
            ->where('student_user_id', $student_user_Id)
            ->where('tutor_user_id', $tutor_user_Id)
            ->exists();

        if (!$associationExists) {
            return redirect()->route('coordinators.registries.students.edit', $student_Id)
                            ->with('error', 'A associação entre o aluno e o tutor não existe.');
        }

        // Remover a linha da Base de dados
        DB::table('student_by_tutor')
            ->where('student_user_id', $student_user_Id)
            ->where('tutor_user_id', $tutor_user_Id)
            ->delete();

        return redirect()->route('coordinators.registries.students.edit', $student_Id)
                        ->with('success', 'Associação do tutor removida com sucesso!');
    }

    // ==================== FUNÇÃO: SELECIONAR UM RESPONSÁVEL PARA O ALUNO ====================
    public function Student_Class_select($student_Id)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        // Pegar as informações do estudante pelo Id
        $student = Student::findOrFail($student_Id);
    
        // Pegar o array de tutores associados a estudantes
        $associatedClasses = DB::table('student_by_class')
            ->join('tb_class', 'student_by_class.class_id', '=', 'tb_class.class_id')
            ->where('student_by_class.student_user_id', $student->student_user_id)
            ->select('tb_class.*') // Select all fields from tb_class
            ->get();

        //dd($associatedTutors->toArray()); //isso é para debug
    
        // Pegar os tutores que pertencam a mesma entidade
        $classes = ClassModel::where('entity_id', $student->entity_id)
                ->get();

        //dd($associatedTutors->toArray(), $students->toArray());      
    
        return view('coordinators.registries.students.select_classes', compact('classes', 'student', 'associatedClasses'));
    }

    // ==================== FUNÇÃO: SALVAR A TURMA PARA O ALUNO ====================
    public function Student_Class_update(Request $request, $student_Id)
    { 
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        //if ($request->has('classes')) {dd($request->classes);} else {dd('No classes selected');}
        // Achando a Classe(Turma) pelo seu Id
        $student = Student::findOrFail($student_Id);
    
        // entity_id da entidade do usuario atual
        $entityId = Auth::user()->entity_id;

        // Validar a seleção
        $request->validate([
            'class' => 'required|exists:tb_class,class_id', 
        ]);
        //dd($request);

        $class_id = $request->input('class');
        //dd($class_id);

        $dataToInsert = [
            'class_id' => $class_id,
            'student_user_id' => $student->student_user_id, 
            'entity_id' => $entityId,
        ];
    
        $existing = DB::table('student_by_class')
            ->where('student_user_id', $student->student_user_id)
            ->where('class_id', $class_id)
            ->first();

        //se não existir inserir dados
        if (!$existing) {
            DB::table('student_by_class')->insert($dataToInsert);
        }
    
        return redirect()->route('coordinators.registries.students.edit', $student_Id)
                         ->with('success', 'Classes associations updated successfully!');
   
    }

    // ==================== FUNÇÃO: REMOVER A CLASSE DO ALUNO ====================
    public function Student_Class_delete(Request $request, $student_id, $class_id)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        $student = Student::findOrFail($student_id);
        $student_user_id = $student->student_user_id;

        // Deletando da base de dados
        DB::table('student_by_class')
            ->where('student_user_id', $student_user_id)
            ->where('class_id', $class_id)
            ->delete();

        return redirect()->route('coordinators.registries.students.edit', $student_id)
                        ->with('success', 'Class deleted successfully.');
    }

    // ==================== CADASTROS DE RESPONSÁVEIS ====================
    // ==================== PAGINA HOME DOS RESPONSÁVEIS ====================
    public function tutors_registries_home_page()
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }
        
        $entity_Id = Auth::user()->entity_id;

        $tutors = Tutor::where('entity_id', $entity_Id)->get();

        return view('coordinators.registries.tutors.tutors_home', compact('tutors'));

    }

    // ==================== FUNÇÃO: CRIAR RESPONSÁVEL ====================
    public function Tutors_create()
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }
        
        return view('coordinators.registries.tutors.tutor_create');
        
    }

    // ==================== FUNÇÃO: SALVAR RESPONSÁVEL CRIADO ====================
    public function Tutors_store(Request $request)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        // Validação dos Dados
        $validatedData = $request->validate([
            'cep_code' => 'required|integer',
            'adress_number' => 'required|string|max:55',
            'adress_street_name' => 'nullable|string|max:120',
            'city_id' => 'required|exists:tb_city,city_id',
            'tutor_name' => 'required|string|max:255|min:2',
            'tutor_birth_date' => 'required|date',
            'tutor_cpf_number' => 'required|string|size:11|unique:tb_tutors,tutor_cpf_number',
            'tutor_contact_number' => 'required|string|max:15',
            'tutor_contact_mail' => 'required|email|max:50',
            'tutor_registry_date' => 'required|date',
            'is_active' => 'required|boolean',
            'password' => 'required|string|min:8',
        ]);

        // Pegando o id da entidade de acordo com o usuário logado
        $validatedData['entity_id'] = Auth::user()->entity_id;

        // Separando o nome do responsável para criação de usuário
        $nameParts = explode(' ', $validatedData['tutor_name']);
        $firstName = $nameParts[0];
        $lastName = isset($nameParts[1]) ? $nameParts[1] : $firstName;

        // Usando uma transação para garantir que as operações sejam feitas com consistência
        DB::beginTransaction();
        try {
            // Criando o endereço
            $address = Address::create([
                'cep_code' => $validatedData['cep_code'],
                'adress_number' => $validatedData['adress_number'],
                'adress_street_name' => $validatedData['adress_street_name'],
                'city_id' => $validatedData['city_id'],
            ]);

            // Adicionando o address_id ao array
            $validatedData['address_id'] = $address->address_id;

            // Criando um novo usuário para o tutor
            $user = User::create([
                'entity_id' => $validatedData['entity_id'],
                'first_name' => $firstName,
                'last_name' => $lastName,
                'password_hash' => bcrypt($validatedData['password']),
                'user_role' => 'tutor',
            ]);

            // Verificando se o usuário foi criado corretamente
            if ($user) {
                $validatedData['tutor_user_id'] = $user->user_id;
                Tutor::create($validatedData); 

                DB::commit(); // Confirma a transação

                return redirect()->route('coordinators.registries.tutors.home')
                                ->with('success', 'Tutor and user registered successfully!');
            } else {
                DB::rollBack(); // Reverte a transação
                return redirect()->back()->with('error', 'User could not be created. Please try again.');
            }
        } catch (\Exception $e) {
            DB::rollBack(); // Reverte a transação
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    // ==================== FUNÇÃO: EDITAR RESPONSÁVEL CRIADO ====================
    public function Tutors_edit($tutor_Id)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }
        
        $tutor = Tutor::with(['user', 'address', 'address.city', 'address.city.state', 'address.city.state.country'])
                    ->findOrFail($tutor_Id);
        
        $cities = City::all();

        $associatedStudents = StudentByTutor::where('tutor_user_id', $tutor->tutor_user_id)
            ->with('tutor')
            ->get();

        return view('coordinators.registries.tutors.tutor_edit', compact('tutor', 'cities', 'associatedStudents'));
    }

    // ==================== FUNÇÃO: SALVAR RESPONSÁVEL EDITADO ====================
    public function Tutors_update(Request $request, $tutor_Id)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        // Validação dos dados
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'tutor_name' => 'required|string|max:120|min:2',
            'tutor_birth_date' => 'required|date',
            'tutor_cpf_number' => 'required|string|size:11|unique:tb_tutors,tutor_cpf_number,' . $tutor_Id . ',tutor_id',
            'tutor_contact_number' => 'required|string|max:15',
            'tutor_contact_mail' => 'required|email|max:50',
            'tutor_registry_date' => 'required|date',
            'cep_code' => 'required|integer',
            'adress_street_name' => 'required|string|max:120',
            'adress_number' => 'required|string|max:55',
            'city_id' => 'required|exists:tb_city,city_id',
            'is_active' => 'required|boolean',
            // Opcional
            'password' => 'nullable|string|min:8',
        ]);

        // Achar o Reponsavel pelo Id
        $tutor = Tutor::with('user', 'address')->findOrFail($tutor_Id);

        // Atualizar dados de usuario
        $tutor->user->username = $validatedData['username'];
        if ($validatedData['password']) {
            $tutor->user->password_hash = bcrypt($validatedData['password']);
        }
        $tutor->user->save();

        // Criar um array para os dados do endereço
        $addressData = $request->only([
            'cep_code',
            'adress_street_name',
            'adress_number',
            'city_id',
        ]);

        // Atualizar o endereço
        $tutor->address->update($addressData);

        // Criar um array para os dados do tutor
        $tutorData = $request->only([
            'tutor_name',
            'tutor_birth_date',
            'tutor_cpf_number',
            'tutor_contact_number',
            'tutor_contact_mail',
            'tutor_registry_date',
            'is_active',
        ]);

        // Atualizar informações do tutor
        $tutor->update($tutorData);

        return redirect()->route('coordinators.registries.tutors.home')
                        ->with('success', 'Tutor updated successfully!');
    }

    // ==================== FUNÇÃO: SELECIONAR UM ALUNO PARA O RESPONSÁVEL ====================
    public function Tutor_Select_Student($tutor_Id)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }
        
        // Pegar as informações do Responsável pelo Id
        $tutor = Tutor::findOrFail($tutor_Id);
    
        // Pegar o array de tutores associados a estudantes
        $associatedStudents = StudentByTutor::where('tutor_user_id', $tutor->tutor_user_id)
            ->with('tutor')
            ->get();
        //dd($associatedStudents->toArray());
    
        // Pegar os Estudantes que pertencam a mesma entidade
        $students = Student::where('entity_id', $tutor->entity_id)
                            ->where('is_active', true)
                            ->get();
        //dd($associatedStudents->toArray(), $students->toArray());      
    
        return view('coordinators.registries.tutors.select_students', compact('students', 'tutor', 'associatedStudents'));
    }

    // ==================== FUNÇÃO: SALVAR O ALUNO PARA O RESPONSÁVEL ====================
    public function Tutor_Update_Student(Request $request, $tutor_Id)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        // Validação dos Dados
        $validatedData = $request->validate([
            'students' => 'array',
            'students.*' => 'exists:tb_students,student_user_id' //Valida a existência
        ]);
    
        // Buscado os dados do responsável com a função 'user' já carregada
        $tutor = Tutor::with('user')->findOrFail($tutor_Id);
    
        // Apagando dados da tabela student_by_tutor
        DB::table('student_by_tutor')->where('tutor_user_id', $tutor->tutor_user_id)->delete();
    
        // Incluindo dados no array para gravar
        $dataToAttach = [];
        foreach ($request->students as $student_user_Id) {
            $dataToAttach[$student_user_Id] = [
                'entity_id' => $tutor->entity_id,   
                'tutor_user_id' => $tutor->tutor_user_id  
            ];
        }
    
        // Gravando os dados na Base de dados
        $tutor->students()->attach($dataToAttach); 

        return redirect()->route('coordinators.registries.tutors.edit', $tutor_Id)
                         ->with('success', 'Student associations updated successfully!');
    }

    // ==================== FUNÇÃO: REMOVER O ALUNO DO RESPONSÁVEL ====================
    public function Tutor_Delete_Student(Request $request, $tutor_Id, $student_user_Id)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        // Achar o responsável com o Id
        $tutor = Tutor::findOrFail($tutor_Id);
        $tutor_user_Id = $tutor->tutor_user_id;
    
        // Remover a linha da Base de dados
        DB::table('student_by_tutor')
            ->where('tutor_user_id', $tutor_user_Id)
            ->where('student_user_id', $student_user_Id)
            ->delete();
    
        return redirect()->route('coordinators.registries.tutors.edit', $tutor_Id)
                         ->with('success', 'Student association removed successfully!');
    }

    // ==================== CADASTROS DE PROFESSORES ====================
    // ==================== PAGINA HOME DOS PROFESSORES ====================
    public function teachers_registries_home_page()
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        // Utilizando a função 'RoleCheckService' para checar a 'role'
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }
        
        $entity_Id = Auth::user()->entity_id;

        $teachers = Teacher::where('entity_id', $entity_Id)->get();

        return view('coordinators.registries.teachers.teachers_home', compact('teachers'));

    }

    // ==================== FUNÇÃO: CRIAR PROFESSOR ====================
    public function Teacher_create()
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        // Utilizando a função 'RoleCheckService' para checar a 'role'
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }
        
        return view('coordinators.registries.teachers.teacher_create');
        
    }

    // ==================== FUNÇÃO: SALVAR PROFESSOR CRIADO ====================
    public function Teacher_store(Request $request)
    {  
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        // Validate the request
        $validatedData = $request->validate([
            'cep_code' => 'required|integer',
            'adress_number' => 'required|string|max:55',
            'adress_street_name' => 'nullable|string|max:120',
            'city_id' => 'required|exists:tb_city,city_id',
            'teacher_name' => 'required|string|max:255|min:2',
            'teacher_birth_date' => 'required|date',
            'teacher_cpf_number' => 'required|string|size:11|unique:tb_teachers,teacher_cpf_number',
            'teacher_contact_number' => 'required|string|max:15',
            'teacher_contact_mail' => 'required|email|max:50',
            'teacher_registry_date' => 'required|date',
            'password' => 'required|string|min:8',
            'is_active' => 'required|boolean',
            'coordinator' => 'boolean',
        ]);
    
        // Pegando o id da entidade de acordo com o usuário logado
        $validatedData['entity_id'] = Auth::user()->entity_id ?? null;
        
        // Separando o nome do responsável para criação de usuário
        $nameParts = explode(' ', $validatedData['teacher_name']);
        $firstName = $nameParts[0];
        $lastName = isset($nameParts[1]) ? $nameParts[1] : $firstName;

        DB::beginTransaction();
        try {
            $address = Address::create([
                'cep_code' => $validatedData['cep_code'],
                'adress_number' => $validatedData['adress_number'],
                'adress_street_name' => $validatedData['adress_street_name'],
                'city_id' => $validatedData['city_id'],
            ]);

            // Adicionando o address_id ao array
            $validatedData['address_id'] = $address->address_id;

            // Criando um novo usuário para o tutor
            $user = User::create([
                'entity_id' => $validatedData['entity_id'],
                'first_name' => $firstName,
                'last_name' => $lastName,
                'password_hash' => bcrypt($validatedData['password']),
                'user_role' => 'teacher',
            ]);

            // Verificando se o usuário foi criado corretamente
            if ($user) {
                $validatedData['teacher_user_id'] = $user->user_id;
                Teacher::create($validatedData); 

                DB::commit(); // Confirma a transação

                return redirect()->route('coordinators.registries.teachers.home')
                                ->with('success', 'Teacher and user registered successfully!');
            } else {
                DB::rollBack(); // Reverte a transação
                return redirect()->back()->with('error', 'User could not be created. Please try again.');
            }
        } catch (\Exception $e) {
            DB::rollBack(); // Reverte a transação
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    // ==================== FUNÇÃO: EDITAR PROFESSOR CRIADO ====================
    public function Teacher_edit($teacher_Id)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        $teacher = Teacher::with(['user', 'address', 'address.city', 'address.city.state', 'address.city.state.country'])
                        ->findOrFail($teacher_Id);
    
        $cities = City::all(); 
    
        return view('coordinators.registries.teachers.teacher_edit', compact('teacher', 'cities'));
    }

    // ==================== FUNÇÃO: SALVAR PROFESSOR EDITADO ====================
    public function Teacher_update(Request $request, $teacher_Id)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        // Validate the request
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'teacher_name' => 'required|string|max:120|min:2',
            'teacher_birth_date' => 'required|date',
            'teacher_cpf_number' => 'required|string|size:11|unique:tb_teachers,teacher_cpf_number,' . $teacher_Id . ',teacher_id',
            'teacher_contact_number' => 'required|string|max:15',
            'teacher_contact_mail' => 'required|email|max:50',
            'teacher_registry_date' => 'required|date',
            'cep_code' => 'required|integer',
            'adress_street_name' => 'required|string|max:120',
            'adress_number' => 'required|string|max:55',
            'city_id' => 'required|exists:tb_city,city_id',
            'is_active' => 'required|boolean',
            'password' => 'nullable|string|min:8',
            'coordinator' => 'boolean',   
        ]);

        // Achar o Professor pelo Id
        $teacher = Teacher::with('user', 'address')->findOrFail($teacher_Id);

        // Atualizar dados de usuario
        $teacher->user->username = $validatedData['username'];
        if (isset($validatedData['password']) && $validatedData['password']) {
            $teacher->user->password_hash = bcrypt($validatedData['password']);
        }
        $teacher->user->save();

        // Criar um array para os dados do endereço
        $addressData = $request->only([
            'cep_code',
            'adress_street_name',
            'adress_number',
            'city_id',
        ]);
    
        // Atualizar o endereço
        $teacher->address->update($addressData);

        // Criar um array para os dados do tutor
        $teacherData = $request->only([
            'tutor_name',
            'tutor_birth_date',
            'tutor_cpf_number',
            'tutor_contact_number',
            'tutor_contact_mail',
            'tutor_registry_date',
            'is_active',
        ]);

        // Trabalhando com a Checkbox para garantir a inclusão do valor
        $teacherData['coordinator'] = $validatedData['coordinator'] ?? false;

        $teacher->update($teacherData);

        return redirect()->route('coordinators.registries.teachers.home')
                        ->with('success', 'Teacher updated successfully!');
    }


    // ##################################################################
    // #                                                                #
    // #                   CADASTROS DE DISCIPLINAS                     #
    // #                                                                #
    // ##################################################################


    // ==================== CADASTROS DE DISCIPLINAS ====================
    // ==================== PAGINA HOME DAS DISCIPLINAS ====================
    public function classes_subjects_registries_home_page()
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }
        
        $entity_Id = Auth::user()->entity_id;

        $classessubjects = ClassSubject::where('entity_id', $entity_Id)->get();

        return view('coordinators.registries.classessubjects.classes_subjects_home', compact('classessubjects'));

    }

    // ==================== FUNÇÃO: CRIAR DISCIPLINA ====================
    public function Class_Subjects_create()
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }
        
        return view('coordinators.registries.classessubjects.classes_subjects_create');
        
    }

    // ==================== FUNÇÃO: SALVAR DISCIPLINA CRIADA ====================
    public function Class_Subjects_store(Request $request)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        // Validação dos dados
        $validatedData = $request->validate([
            'class_subject_name' => 'required|string|max:255|unique:tb_class_subjects,class_subject_name,NULL,id,entity_id,' . Auth::user()->entity_id, 
            'is_active' => 'required|boolean',
        ]);
    
        // Pegando o id da entidade de acordo com o usuário logado
        $validatedData['entity_id'] = Auth::user()->entity_id;
    
        // Verificando se a Disciplina já não existe
        $classSubject = ClassSubject::where('class_subject_name', $validatedData['class_subject_name'])
                                    ->where('entity_id', $validatedData['entity_id'])
                                    ->first();
    
        // Salvando a Disciplina no Banco
        if (!$classSubject) {
            ClassSubject::create($validatedData);   
            return redirect()->route('coordinators.registries.classessubjects.home')
                             ->with('success', 'Class subject registered successfully!');
        } else {
            return redirect()->back()->with('error', 'This class subject already exists for your entity.');
        }
    }

    // ==================== FUNÇÃO: EDITAR DISCIPLINA CRIADA ====================
    public function Class_Subjects_edit($class_subject_id)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        $classSubject = ClassSubject::where('entity_id', Auth::user()->entity_id)
                                    ->findOrFail($class_subject_id);

        $syllabus = ClassSubjectSyllabus::where('class_subject_id', $class_subject_id)->get();

        return view('coordinators.registries.classessubjects.classes_subjects_edit', compact('classSubject', 'syllabus'));
    }

    // ==================== FUNÇÃO: SALVAR DISCIPLINA EDITADA ====================
    public function Class_Subjects_update(Request $request, $class_subject_id)
    {   
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        // Validar os dados
        $validatedData = $request->validate([
            'class_subject_name' => 'required|string|max:255|unique:tb_class_subjects,class_subject_name,' . $class_subject_id . ',class_subject_id,entity_id,' . Auth::user()->entity_id,
            'is_active' => 'required|boolean',
        ]);

        // achando a informação e vrificando se ela pertende ao usuario
        $classSubject = ClassSubject::where('entity_id', Auth::user()->entity_id)
                                    ->findOrFail($class_subject_id);

        // Realizar o update na base de dados
        $classSubject->update($validatedData);

        // Redirect to the class subjects list with a success message
        return redirect()->route('coordinators.registries.classessubjects.home')
                        ->with('success', 'Class subject updated successfully!');
    }

    // ==================== FUNÇÃO: CRIAR ASSUNTO PARA DISCIPLINA ====================
    public function Syllabus_create($class_subject_id)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        $classSubject = ClassSubject::findOrFail($class_subject_id);
        return view('coordinators.registries.classessubjects.syllabus.syllabus_create', compact('classSubject'));
    }

    // ==================== FUNÇÃO: SALVAR ASSUNTO DA DISCIPLINA ====================
    public function Syllabus_store(Request $request, $class_subject_id)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        $validatedData = $request->validate([
            'class_syllabus_name' => 'required|string|max:255|unique:tb_class_subjects_syllabus,class_syllabus_name,NULL,id,class_subject_id,' . $class_subject_id,
            'class_syllabus_description' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        // Pegando o id da entidade de acordo com o usuário logado
        $validatedData['entity_id'] = Auth::user()->entity_id;
        $validatedData['class_subject_id'] = $class_subject_id;
        // Forçando o isActive
        //if ($validatedData['is_active'] == "0") {$isActive = 0;} else {$isActive = 1;}
        //dd($validatedData, $isActive, $validatedData['is_active']);
        //$isActive = (int) $validatedData['is_active'];
        //dd($validatedData, $isActive, $validatedData['is_active']);
        //$isActive = $validatedData['is_active'] != "0";

        //dd($validatedData, $isActive, $validatedData['is_active']);
        ClassSubjectSyllabus::create($validatedData);

        return redirect()->route('coordinators.registries.classessubjects.edit', $class_subject_id)
                         ->with('success', 'Syllabus added successfully!');
    }

    // ==================== FUNÇÃO: EDITAR ASSUNTO DA DISCIPLINA ====================
    public function Syllabus_edit($syllabus_id)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        $syllabus = ClassSubjectSyllabus::findOrFail($syllabus_id);
        $classSubject = ClassSubject::findOrFail($syllabus->class_subject_id);
        return view('coordinators.registries.classessubjects.syllabus.syllabus_edit', compact('syllabus', 'classSubject'));
    }

    // ==================== FUNÇÃO: SALVAR ASSUNTO DA DISCIPLINA EDITADO ====================
    public function Syllabus_update(Request $request, $syllabus_id)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        $syllabus = ClassSubjectSyllabus::findOrFail($syllabus_id);

        $validatedData = $request->validate([
            'class_syllabus_name' => 'required|string|max:255|unique:tb_class_subjects_syllabus,class_syllabus_name,' . $syllabus->class_syllabus_id . ',class_syllabus_id,class_subject_id,' . $syllabus->class_subject_id,
            'class_syllabus_description' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        $syllabus->update($validatedData);

        return redirect()->route('coordinators.registries.classessubjects.edit', $syllabus->class_subject_id)
                         ->with('success', 'Syllabus updated successfully!');
    }


    // ##################################################################
    // #                                                                #
    // #                   CADASTROS DE CRONOGRAMAS                     #
    // #                                                                #
    // ##################################################################

    // ==================== CADASTROS DE CRONOGRAMAS ====================
    // ==================== PAGINA HOME DOS DISCIPLINAS ====================
    public function Chronogram_home()
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }
        
        $entity_Id = Auth::user()->entity_id;

        // Pegar apenas os chronogramas que peprtencem a entidade
        $chronograms = Chronogram::where('entity_id', $entity_Id)
            ->get();

        //dd($chronograms->toArray());
        return view('coordinators.registries.chronogram.chronogram_home', compact('chronograms'));

    }

    // ==================== FUNÇÃO: CRIAR CRONOGRAMA ====================
    public function Chronogram_create()
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        // Pegar o Id do usuario criando o registro
        $entity_Id = Auth::user()->entity_id;
    
        return view('coordinators.registries.chronogram.chronogram_create');
    }

    // ==================== FUNÇÃO: SALVAR CRONOGRAMA CRIADO ====================
    public function Chronogram_store(Request $request)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        // Validação de data
        $validatedData = $request->validate([
            'chronogram_name' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        // Adicionando a entidade a validação
        $validatedData['entity_id'] = Auth::user()->entity_id;

        // Criando um novo cronograma
        Chronogram::create($validatedData);

        return redirect()->route('coordinators.registries.chronograms.home')
                        ->with('success', 'Chronogram added successfully!');
    }

    // ==================== FUNÇÃO: EDITAR CRONOGRAMA CRIADO ====================
    public function Chronogram_edit($chronogram_id)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        // Recuperar o chronograma pelo ID com filtro de entidade
        $chronogram = Chronogram::where('entity_id', Auth::user()->entity_id)
                    ->findOrFail($chronogram_id);

        $associatedHomeworks = $chronogram->homeworks;
        //dd($associatedHomeworks);

        return view('coordinators.registries.chronogram.chronogram_edit', compact('chronogram', 'associatedHomeworks'));
    }

    // ==================== FUNÇÃO: SALVAR CRONOGRAMA EDITADO ====================
    public function Chronogram_update(Request $request, $chronogram_id)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        // Validar a informação
        $validatedData = $request->validate([
            'chronogram_name' => 'required|string|max:255',
            'entity_id' => 'required|exists:tb_entities,entity_id',
            'is_active' => 'boolean',
        ]);
    
        // Recuperar o chronograma pelo ID com filtro de entidade
        $chronogram = Chronogram::where('entity_id', Auth::user()->entity_id)
                    ->findOrFail($chronogram_id);

        $chronogram->update($validatedData);
    
        // Redirect back with a success message
        return redirect()->route('coordinators.registries.chronograms.home') 
                         ->with('success', 'Chronogram updated successfully!');
    }

    // ==================== FUNÇÃO: SELECIONAR TAREFAS PARA O CRONOGRAMA ====================
    public function Homeworks_select($chronogram_id)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        $chronogram = Chronogram::findOrFail($chronogram_id);
        $homeworks = Homework::all();
        $associatedHomeworks = $chronogram->homeworks;
    
        if ($homeworks->isEmpty()) {
            return redirect()->back()->with('error', 'No homeworks available to associate with this chronogram.');
        }

        return view('coordinators.registries.chronogram.select_homeworks', compact('chronogram', 'homeworks', 'associatedHomeworks'));
    }

    // ==================== FUNÇÃO: SALVAR TAREFAS PARA O CRONOGRAMA ====================
    public function Homeworks_save(Request $request, $chronogram_id)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        // Valida as tarrefas em um array
        $request->validate([
            'homeworks' => 'required|array',
        ]);
        //dd($request->all());
        // Validando as datas
        $rules = [];
    
        // Apenas valida para as tarefas selecionadas
        foreach ($request->homeworks as $homework_id) {
            $rules["release_dates.$homework_id"] = 'required|date';
            $rules["due_dates.$homework_id"] = 'required|date|after:release_dates.' . $homework_id;
        }

        // Aplicando as validações
        $request->validate($rules, [
            'due_dates.*.after' => 'The due date must be after the release date.',
        ]);
        
        // Pegar o cronograma pelo id
        $chronogram = Chronogram::findOrFail($chronogram_id);

        // Preparar dados para sincronizar
        $syncData = [];
        foreach ($request->homeworks as $homework_id) {
            $syncData[$homework_id] = [
                'release_date' => $request->release_dates[$homework_id],
                'due_date' => $request->due_dates[$homework_id],
                'entity_id' => Auth::user()->entity_id, 
            ];
        }

        // Sincronizar tarefas com os cronogramas
        $chronogram->homeworks()->sync($syncData);
    
        return redirect()->route('coordinators.registries.chronograms.edit', $chronogram_id)
                         ->with('success', 'Homeworks updated successfully.');
    }

    // ==================== FUNÇÃO: REMOVER TAREFAS DO CRONOGRAMA ====================
    public function Homework_delete($chronogram_id, $homework_id)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        DB::table('homework_by_chronogram')
            ->where('chronogram_id', $chronogram_id)
            ->where('homework_id', $homework_id)
            ->delete();

        return redirect()->route('coordinators.registries.chronograms.edit', $chronogram_id)
                        ->with('success', 'Homework deleted successfully.');
    }


    // ##################################################################
    // #                                                                #
    // #                     CADASTROS DE CLASSES                       #
    // #                                                                #
    // ##################################################################

    // ==================== CADASTROS DE CLASSES ====================
    // ==================== PAGINA HOME DA CRIAÇÃO DE CLASSES ====================
    public function Class_home()
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }
        
        $entityId = Auth::user()->entity_id;

        // Pegar as turmas associadas a entidade
        $classes = ClassModel::where('entity_id', $entityId)
            ->get();

        return view('coordinators.registries.classes.classes_home', compact('classes'));

    }

    // ==================== FUNÇÃO: CRIAR CLASSE ====================
    public function Class_create()
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        $entityId = Auth::user()->entity_id;
    
        return view('coordinators.registries.classes.class_create');
    }

    // ==================== FUNÇÃO: SALVAR CLASSE CRIADA ====================
    public function Class_store(Request $request)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        // Validação do Request
        $validatedData = $request->validate([
            'class_name' => 'required|string|max:255',
            'class_year' => 'required|integer|min:2000|max:2100',
            'entity_id' => 'required|exists:tb_entities,entity_id',
        ]);
    
        //dd($validatedData);
        // Criando o Registo na Base de Dados
        ClassModel::create($validatedData);
        
        // Redirecionamento de Rota
        return redirect()->route('coordinators.registries.classes.home') 
                         ->with('success', 'Class registered successfully.');
    }

    // ==================== FUNÇÃO: EDITAR CLASSE CRIADA ====================
    public function Class_edit($class_id)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        // Achando a Classe(Turma) pelo seu Id
        $class = ClassModel::findOrFail($class_id);

        // Achando Chronograma Associados (Método de associão via ClassModel.php (Model))
        $chronograms = $class->chronograms;
        //dd($achronograms, $chronograms);

        // Achando Professores Associados (Método de associão manual)
        $teachers = DB::table('tb_teachers')
                    ->join('teacher_by_class', 'tb_teachers.teacher_user_id', '=', 'teacher_by_class.teacher_user_id')
                    ->where('teacher_by_class.class_id', $class_id)
                    ->select('tb_teachers.*') 
                    ->get();


        // Achando Disciplinas Associadas (Método de associão via ClassModel.php (Model))
        $classsubjects = $class->subjects;

        return view('coordinators.registries.classes.class_edit', compact('class', 'chronograms', 'teachers', 'classsubjects'));
    }

    // ==================== FUNÇÃO: SALVAR CLASSE EDITADA ====================
    public function Class_update(Request $request, $class_id)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        // Validação dis dados enviados
        $validatedData = $request->validate([
            'class_name' => 'required|string|max:255',
            'class_year' => 'required|integer|min:2000|max:2100',
            'entity_id' => 'required|exists:tb_entities,entity_id',
        ]);
    
        // Achando a Classe(Turma) pelo seu Id
        $class = ClassModel::findOrFail($class_id);
    
        // Atualizar os dados ca Classe
        $class->update($validatedData);
    
        
        return redirect()->route('coordinators.registries.classes.home') 
                         ->with('success', 'Class updated successfully!');
    }

    // ==================== FUNÇÃO: SELECIONAR UM CRONOGRAMA PARA CLASSE ====================
    public function Chronograms_select($class_id)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        // entity_id da entidade do usuario atual
        $entityId = Auth::user()->entity_id;
        
        // Achando a Classe(Turma) pelo seu Id
        $class = ClassModel::findOrFail($class_id);

        // chronogramas pertencentes a entidade atual
        $chronograms = Chronogram::where('entity_id', $entityId)
                         ->where('is_active', true)
                         ->get();
    
        return view('coordinators.registries.classes.select_chronogram', compact('class', 'chronograms'));
    }

    // ==================== FUNÇÃO: SALVAR O CRONOGRAMA NA CLASSE ====================
    public function Chronograms_save(Request $request, $class_id)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }
        
        // Achando a Classe(Turma) pelo seu Id
        $class = ClassModel::findOrFail($class_id);
    
        // entity_id da entidade do usuario atual
        $entityId = Auth::user()->entity_id;
    
        // Validar a seleção de cronogramas
        $request->validate([
            'chronogram_id' => 'required|exists:tb_chronogram,chronogram_id',
        ]);

        // Sincronizar a tabela com o cronograma
        $class->chronograms()->sync([
            $request->chronogram_id => ['entity_id' => $entityId]
        ]);
  
        return redirect()->route('coordinators.registries.classes.edit', $class_id)
                         ->with('success', 'Chronogram successfully associated with the class.');
    }

    // ==================== FUNÇÃO: REMOVER O CRONOGRAMA DA CLASSE ====================
    public function Chronograms_delete($class_id, $chronogram_id)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }


        // Deletando da base de dados
        DB::table('chronogram_by_class')
            ->where('chronogram_id', $chronogram_id)
            ->where('class_id', $class_id)
            ->delete();

        return redirect()->route('coordinators.registries.classes.edit', $class_id)
                        ->with('success', 'Homework deleted successfully.');
    }

    // ==================== FUNÇÃO: SELECIONAR UM PROFESSOR PARA CLASSE ====================
    public function Teachers_select($class_id)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }


        // entity_id da entidade do usuario atual
        $entityId = Auth::user()->entity_id;
        
        // Achando a Classe(Turma) pelo seu Id
        $class = ClassModel::findOrFail($class_id);

        // chronogramas pertencentes a entidade atual
        $teachers = Teacher::where('entity_id', $entityId)
                         ->where('is_active', true)
                         ->where('coordinator', false)
                         ->get();
    
        $associatedTeachers = DB::table('tb_teachers')
                            ->join('teacher_by_class', 'tb_teachers.teacher_user_id', '=', 'teacher_by_class.teacher_user_id')
                            ->where('teacher_by_class.class_id', $class_id)
                            ->select('tb_teachers.*')
                            ->get();
            
        return view('coordinators.registries.classes.select_teachers', compact('class', 'teachers', 'associatedTeachers'));
    }

    // ==================== FUNÇÃO: SALVAR O PROFESSOR NA CLASSE ====================
    public function Teachers_save(Request $request, $class_id)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }


        // Achando a Classe(Turma) pelo seu Id
        $class = ClassModel::findOrFail($class_id);
    
        // entity_id da entidade do usuario atual
        $entityId = Auth::user()->entity_id;
    
        // Validar a seleção
        $request->validate([
            'teachers' => 'array',
            'teachers.*' => 'exists:tb_teachers,teacher_user_id',
        ]);

        // Preparar para sincronizar
        $syncData = [];
        foreach ($request->teachers as $teacher_user_id) {
            $syncData[$teacher_user_id] = ['entity_id' => $entityId];
        }
    
        // Sincronizar a tabela com o professor
        $class->teachers()->sync($syncData);

    
        return redirect()->route('coordinators.registries.classes.edit', $class_id)
                         ->with('success', 'Teacher successfully associated with the class.');
    }

    // ==================== FUNÇÃO: REMOVER O PROFESSOR DA CLASSE ====================
    public function Teachers_delete($class_id, $teacher_user_id)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        // Deletando da base de dados
        DB::table('teacher_by_class')
            ->where('teacher_user_id', $teacher_user_id)
            ->where('class_id', $class_id)
            ->delete();

        return redirect()->route('coordinators.registries.classes.edit', $class_id)
                        ->with('success', 'Homework deleted successfully.');
    }

    // ==================== FUNÇÃO: SELECIONAR UMA DISCIPLINA PARA CLASSE ====================
    public function Subjects_select($class_id)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        // entity_id da entidade do usuario atual
        $entityId = Auth::user()->entity_id;
        
        // Achando a Classe(Turma) pelo seu Id
        $class = ClassModel::findOrFail($class_id);

        // Disciplinas pertencentes a entidade atual
        $subjects = ClassSubject::where('entity_id', $entityId)
                        ->where('is_active', true)
                        ->get();
    
        $associatedSubjects = $class->subjects;
            
        return view('coordinators.registries.classes.select_subjects', compact('class', 'subjects', 'associatedSubjects'));
    }

    // ==================== FUNÇÃO: SALVAR A DISCIPLINA NA CLASSE ====================
    public function Subjects_save(Request $request, $class_id)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        // Achando a Classe(Turma) pelo seu Id
        $class = ClassModel::findOrFail($class_id);
    
        // entity_id da entidade do usuario atual
        $entityId = Auth::user()->entity_id;
    
        // Validar a seleção
        $request->validate([
            'subjects' => 'array',
            'subjects.*' => 'exists:tb_class_subjects,class_subject_id',
        ]);

        // Preparar o Array para sincronização
        $syncData = [];
        foreach ($request->subjects as $class_subject_id) {
            $syncData[$class_subject_id] = ['entity_id' => $entityId];
        }
    
        // Sincronizar a tabela com o professor
        $class->subjects()->sync($syncData);

    
        return redirect()->route('coordinators.registries.classes.edit', $class_id)
                        ->with('success', 'Subject successfully associated with the class.');
    }

    // ==================== FUNÇÃO: REMOVER O PROFESSOR DA CLASSE ====================
    public function Subjects_delete($class_id, $class_subject_id)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        // Deletando da base de dados
        DB::table('subject_by_class')
            ->where('class_subject_id', $class_subject_id)
            ->where('class_id', $class_id)
            ->delete();

        return redirect()->route('coordinators.registries.classes.edit', $class_id)
                        ->with('success', 'Homework deleted successfully.');
    }

    
    // ##################################################################
    // #                                                                #
    // #                          NOTIFICAÇÃO                           #
    // #                                                                #
    // ##################################################################

    // ==================== NOTIFICAÇÕES ====================
    public function Notifications_home()
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }
        
        $entityId = Auth::user()->entity_id;

        // Pegar os responsáveis associadas a entidade
        $tutors = Tutor::where('entity_id', $entityId)
            ->where('is_active', true)
            ->paginate(10);

        // Pegar as turmas associadas a entidade
        $classes = ClassModel::where('entity_id', $entityId)
            ->orderBy('class_year', 'desc')
            ->paginate(10);

        $notifications = Notification::where('entity_id', $entityId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $tutorsArray = $tutors->toArray();
        $classesArray = $classes->toArray();
        //dd($tutorsArray, $classesArray);
        
        return view('coordinators.notifications.notification_home', compact('tutors', 'notifications', 'classes'));

    }

    // ==================== NOTIFICAÇÃO PARA O RESPONSÁVEL ====================
    public function Notifications_create_tutor($tutorUserId)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }

        $tutor = Tutor::where('tutor_user_id', $tutorUserId)->first();
        //dd($tutor);

        return view('coordinators.notifications.notification_create_tutor', compact('tutor'));
    }
    
    // ==================== SALVAR NOTIFICAÇÃO PARA O RESPONSÁVEL ====================
    public function Notifications_store_tutor(Request $request, $tutorId)
    {
        $request->validate([
            'notification_title' => 'required|string|max:30',
            'notifications_message' => 'required|string|max:255',
        ]);

        Notification::create([
            'entity_id' => $request->entity_id,
            'from_user_id' => $request->from_user_id,
            'for_user_id' => $tutorId,
            'notification_title' => $request->notification_title,
            'notifications_message' => $request->notifications_message,
        ]);

        return redirect()->route('coordinators.notifications.home')->with('success', 'Notificação enviada com sucesso!');
    }

    // ==================== NOTIFICAÇÃO PARA A TURMA ====================
    public function Notifications_create_class($classId)
    {
        // Utilizando a função 'RoleCheckService' para checar permissão do usuário
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'You do not have access to this page.');
        }


        $class = ClassModel::where('class_id', $classId)->first();
    
        return view('coordinators.notifications.notification_create_class', compact('class'));
    }

    // ==================== SALVAR NOTIFICAÇÃO PARA A TURMA ====================
    public function Notifications_store_class(Request $request, $classId)
    {
        $request->validate([
            'notification_title' => 'required|string|max:30',
            'notifications_message' => 'required|string|max:255',
        ]);

        $students = DB::table('student_by_class')
        ->where('class_id', $classId)
        ->pluck('student_user_id');

        $tutorUserIds = DB::table('student_by_tutor')
            ->whereIn('student_user_id', $students)
            ->pluck('tutor_user_id')
            ->unique();

        // Iterate over each tutor and send notification
        foreach ($tutorUserIds as $tutorUserId) {
            // Create a new notification for each tutor
            Notification::create([
                'entity_id' => $request->entity_id,
                'from_user_id' => $request->from_user_id,
                'for_user_id' => $tutorUserId, 
                'notification_title' => $request->notification_title,
                'notifications_message' => $request->notifications_message,
            ]);
        }

        return redirect()->route('coordinators.notifications.home')->with('success', 'Notificações enviadas com sucesso para os alunos da turma!');
    }


    // ##################################################################
    // #                                                                #
    // #                           RELATÓRIOS                           #
    // #                                                                #
    // ##################################################################

    // ==================== RELATÓRIOS ====================
    // 

   // ==================== PÁGINA INICIAL DOS RELATÓRIOS ====================
    public function Reports_Home()
    {
        // Verifica se o usuário tem permissão para acessar a página
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'Você não tem acesso a esta página.');
        }

        // Retorna a view da página inicial dos relatórios
        return view('coordinators.reports.reportshome');
    }

    // ==================== PÁGINA DE RELATÓRIOS DE FREQUÊNCIA ====================
    public function Frequency_reports_table()
    {
        // Verifica se o usuário tem permissão para acessar a página
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'Você não tem acesso a esta página.');
        }

        // Retorna a view da tabela de relatórios de frequência
        return view('coordinators.reports.frequencyreportstable');
    }

    // ==================== BUSCA DADOS DE FREQUÊNCIA ====================
    public function fetchFrequencyData(Request $request)
    {
        // Obtém o ID da entidade do usuário autenticado
        $entityId = auth()->user()->entity_id;

        try {
            // BUSCAR DADOS DE FREQUÊNCIA ANUAL
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
                GROUP BY tc.class_year
                ORDER BY tc.class_year;
            ", [$entityId]);

            // BUSCAR DADOS DE FREQUÊNCIA POR TURMA
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
                GROUP BY tc.class_name, tc.class_year
                ORDER BY tc.class_name, tc.class_year;
            ", [$entityId]);

            // BUSCAR DADOS DE FREQUÊNCIA POR ALUNO
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
                GROUP BY tc.class_name, tc.class_year, st.student_name
                ORDER BY tc.class_name, tc.class_year, st.student_name;
            ", [$entityId]);

            // Retorna os dados de frequência como resposta JSON
            return response()->json(['yearly' => $yearlyData, 'class' => $classData, 'student' => $studentData]);

        } catch (\Exception $e) {
            // Retorna um erro se a busca falhar
            return response()->json(['error' => 'Erro ao buscar os dados de frequência.'], 500);
        }
    }

    // ==================== PÁGINA DE RELATÓRIOS DE NOTAS ====================
    public function Grades_reports_table()
    {
        // Verifica se o usuário tem permissão para acessar a página
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'Você não tem acesso a esta página.');
        }

        // Retorna a view da tabela de relatórios de notas
        return view('coordinators.reports.gradesreportstable');
    }

    // ==================== BUSCA DADOS DE NOTAS ====================
    public function fetchGradesData(Request $request)
    {
        // Obtém o ID da entidade do usuário autenticado
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
            GROUP BY sge.evaluation_number, c.class_name, c.class_year
            ORDER BY c.class_year, sge.evaluation_number;
        ", [$entityId]);

        // Nota com Disciplina por Turma
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
            GROUP BY c.class_name, c.class_year, sge.evaluation_number, cs.class_subject_name
            ORDER BY c.class_year, c.class_name, sge.evaluation_number;
        ", [$entityId]);

        // Notas por Alunos
        $studentData = DB::select("
            SELECT 
                ROUND(SUM(sc.concept_weight) / COUNT(sc.concept_weight), 2) AS media,
                c.class_name,
                c.class_year,
                sge.evaluation_number,
                student_name,
                cs.class_subject_name
            FROM tb_student_grade_evaluation AS sge
            JOIN tb_student_grades AS sg ON sge.evaluation_id = sg.evaluation_id
            JOIN tb_subjects_concepts AS sc ON sg.concept_id = sc.concept_id
            JOIN tb_class AS c ON sge.class_id = c.class_id 
            JOIN tb_class_subjects_syllabus AS css ON sg.class_syllabus_id = css.class_syllabus_id
            JOIN tb_class_subjects AS cs ON css.class_subject_id = cs.class_subject_id
            JOIN tb_students AS s ON sge.student_user_id = s.student_user_id
            WHERE sge.entity_id = ?
            GROUP BY c.class_name, c.class_year, sge.evaluation_number, s.student_name, cs.class_subject_name
            ORDER BY c.class_year, c.class_name, sge.evaluation_number, s.student_name;
        ", [$entityId]);

        // Retorna os dados de notas como resposta JSON
        return response()->json(['class' => $classData, 'subject' => $subjectsData, 'student' => $studentData]);
    }

    // ==================== PÁGINA DE RELATÓRIOS DE ATIVIDADES ====================
    public function Activities_reports_table()
    {
        // Verifica se o usuário tem permissão para acessar a página
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'Você não tem acesso a esta página.');
        }

        // Retorna a view da tabela de relatórios de atividades
        return view('coordinators.reports.activitiesreporttable');
    }

    // ==================== BUSCA DADOS DE ATIVIDADES ====================
    public function fetchActivitiesData(Request $request)
    {
        // Obtém o ID da entidade do usuário autenticado
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
            GROUP BY s.student_user_id, s.student_name, a.activity_name;
        ", [$entityId]);

        // Resumo das atividades no ano atual
        $yearsData = DB::select("
            SELECT 
                a.activity_name,
                SUM(asb.times_completed) AS total_times_completed
            FROM activities_by_student asb
            JOIN tb_students s ON asb.student_user_id = s.student_user_id
            JOIN tb_activities a ON asb.activity_id = a.activity_id
            WHERE YEAR(asb.created_at) = YEAR(CURRENT_DATE)  -- Filtra pelo ano atual
            AND s.entity_id = ?
            GROUP BY a.activity_name;
        ", [$entityId]);

        // Retorna os dados de atividades como resposta JSON
        return response()->json(['activitiesData' => $activitiesData, 'yearsData' => $yearsData]);
    }

    // ==================== PÁGINA DE RELATÓRIOS DE ALUNOS ESPECIAIS ====================
    public function Sstudents_reports_table()
    {
        // Verifica se o usuário tem permissão para acessar a página
        if (!$this->roleCheckService->checkUserRole(['administrator', 'coordinator'])) {
            return redirect('Mainhome')->with('error', 'Você não tem acesso a esta página.');
        }

        // Retorna a view da tabela de relatórios de alunos especiais
        return view('coordinators.reports.sstudentsreportstable');
    }

    // ==================== BUSCA DADOS DE ALUNOS ESPECIAIS ====================
    public function fetchSstudentsData(Request $request)
    {
        // Obtém o ID da entidade do usuário autenticado
        $entityId = auth()->user()->entity_id;

        // Totais de Alunos por necessidade
        $TotalData = DB::select("
            SELECT
                sn.special_need_name,
                COUNT(st.is_active) AS total_count
            FROM tb_special_needs AS sn
            JOIN tb_students AS st ON sn.special_need_id = st.special_need_id
            WHERE st.entity_id = ? 
            AND st.is_active = true
            GROUP BY sn.special_need_id, sn.special_need_name;
        ", [$entityId]);

        // Alunos Especiais por Turma
        $ClassData = DB::select("
            SELECT
                sn.special_need_name, tc.class_name, tc.class_year,
                COUNT(st.is_active) AS total_count
            FROM tb_special_needs AS sn
            JOIN tb_students AS st ON sn.special_need_id = st.special_need_id
            JOIN student_by_class AS sbc ON st.student_user_id = sbc.student_user_id
            JOIN tb_class AS tc ON sbc.class_id = tc.class_id
            WHERE st.entity_id = ? 
            AND st.is_active = true
            GROUP BY sn.special_need_id, sn.special_need_name, tc.class_name, tc.class_year;
        ", [$entityId]);

        // Retorna os dados de alunos especiais como resposta JSON
        return response()->json(['totalData' => $TotalData, 'classData' => $ClassData]);
    }
    
}       



