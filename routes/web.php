<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CoordinatorController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherLoginController;
use App\Http\Controllers\TutorLoginController;
use App\Http\Controllers\StudentLoginController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CepController;
use App\Http\Controllers\ActivityController;


//rota de visão para pagina home e realiza loggout automatico
Route::get('/', function () {
    if (Auth::check()) {
        Auth::logout(); // Automatic logout
    }
    return view('Mainhome'); // Home page
})->name('Mainhome');

Route::get('/cep/{cep}', [CepController::class, 'fetchAddress']);


    // ##################################################################
    // #                                                                #
    // #                      ROTAS DOS LOGINS                          #
    // #           /app/Http/Controllers/HomeController.php             #
    // ##################################################################


Route::controller(HomeController::class)
    ->prefix('login')
    ->name('login.')
    ->group(function () {

 // Pagina de Login do Estudante
    Route::get('/studentlogin', function () {
        if (Auth::check()) {
            Auth::logout(); // Logoff automatico
        }
        return view('logins.studentlogin');
    })->name('student');

    // Pagina de Login do Responsável (Tutor)
    Route::get('/tutorlogin', function () {
        if (Auth::check()) {
            Auth::logout(); // Logoff automatico
        }
        return view('logins.tutorlogin');
    })->name('tutor');

    // Pagina de Login do Coordenador/Professor e Administrador
    Route::get('/teacherlogin', function () {
        if (Auth::check()) {
            Auth::logout(); // Logoff automatico
        }
        return view('logins.teacherlogin');
    })->name('teacher');

    // Rotas de Login
    Route::post('/teacherlogin', [TeacherLoginController::class, 'login_submit'])->name('teacher.submit');
    Route::post('/tutorlogin', [TutorLoginController::class, 'login_submit'])->name('tutor.submit');
    Route::post('/studentlogin', [StudentLoginController::class, 'login_submit'])->name('student.submit');

});

    // ##################################################################
    // #                                                                #
    // #                   ROTAS DOS NOTIFICAÇÕES                       #
    // #      /app/Http/Controllers/CoordinatorController.php           #
    // ##################################################################

Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/create', [NotificationController::class, 'create'])->name('notifications.create');
    Route::post('/notifications', [NotificationController::class, 'store'])->name('notifications.store');
    Route::post('/notifications/reply/{id}', [NotificationController::class, 'reply'])->name('notifications.reply');
});


    // ##################################################################
    // #                                                                #
    // #                   ROTAS DOS COORDENADORES                      #
    // #      /app/Http/Controllers/CoordinatorController.php           #
    // ##################################################################

// rotas protegidas para coordenadores controlador 'CoordinatorController'
Route::middleware(['auth'])->group(function () {
    Route::controller(CoordinatorController::class)
        ->prefix('coordinators')
        ->name('coordinators.')
        ->group(function () {

            // ==================== MENU PRINCIPAL ====================
            Route::get('/home', 'coordinator_home_page')->name('home'); //Pagina do Home coordenador
            
            // ==================== CADASTROS ====================
            Route::get('/registries', 'registries_home_page')->name('registries.home'); //Home dos Registros (Aluno, Responsavel, Professores)

            // ==================== CADASTROS DE ALUNOS ====================
            Route::get('/registries/students', 'students_registries_home_page')->name('registries.students.home'); //Pagina HOME dos Registros
            Route::get('/registries/students/new', 'Student_create')->name('registries.students.new'); //Pagina de Novo Registro
            Route::post('/registries/students/store', 'Student_store')->name('registries.students.store'); //Post para salvar os dados
            Route::get('/registries/students/{student_Id}/edit', 'Student_edit')->name('registries.students.edit'); //Pagina de Editar Registro
            Route::post('/registries/students/{student_Id}', 'Student_update')->name('registries.students.update'); //Put para dar Update dos dados
            // Adicionado Responsáveis aos Estudantes
            Route::get('/registries/students/{student_Id}/selecttutor', 'Student_Select_Tutor')->name('registries.students.selectTutors'); // Associar Tutor ao Estudante
            Route::post('/registries/students/{student_Id}/updateTutors', 'Student_Update_Tutor')->name('registries.students.updateTutors');
            Route::delete('/registries/students/{student_Id}/deletetutors/{studentUser_Id}', 'Student_Delete_Tutor')->name('registries.students.deleteTutor'); // Update teacher data
            // Adicionando Turmas aos Estudantes
            Route::get('/registries/students/{students_id}/selectclass', 'Student_Class_select')->name('select_class');
            Route::post('/registries/students/{students_id}/saveclass', 'Student_Class_update')->name('save_class');
            Route::delete('/registries/students/{students_id}/class/{class_id}', 'Student_Class_delete')->name('delete_class');


            // ==================== CADASTROS DE RESPONSÁVEIS ====================
            Route::get('/registries/tutors', 'tutors_registries_home_page')->name('registries.tutors.home'); //Pagina HOME dos Registros
            Route::get('/registries/tutors/new', 'Tutors_create')->name('registries.tutors.new'); //Pagina de Novo Registro
            Route::post('/registries/tutors/store', 'Tutors_store')->name('registries.tutors.store'); //Post para salvar os dados
            Route::get('/registries/tutors/{id}/edit', 'Tutors_edit')->name('registries.tutors.edit'); //Pagina de Editar Registro
            Route::put('/registries/tutors/{id}', 'Tutors_update')->name('registries.tutors.update'); //Put para dar Update dos dados
            // Adicionado Estudantes aos Responsáveis
            Route::get('/registries/tutors/{tutorId}/students', 'Tutor_Select_Student')->name('registries.tutors.selectStudents');
            Route::post('/registries/tutors/{tutorId}/updateStudents/{userId}', 'Tutor_Update_Student')->name('registries.tutors.updateStudents');
            Route::delete('/registries/tutors/{tutorId}/students/{studentUserId}', 'Tutor_Delete_Student')->name('registries.tutors.deleteStudents'); // Update teacher data


            // ==================== CADASTROS DE PROFESSORES ====================
            Route::get('/registries/teachers', 'teachers_registries_home_page')->name('registries.teachers.home'); //Pagina HOME dos Registros
            Route::get('/registries/teachers/new', 'Teacher_create')->name('registries.teachers.new'); //Pagina de Novo Registro
            Route::post('/registries/teachers/store', 'Teacher_store')->name('registries.teachers.store'); //Post para salvar os dados
            Route::get('/registries/teachers/{id}/edit', 'Teacher_edit')->name('registries.teachers.edit'); // Edit page
            Route::put('/registries/teachers/{id}', 'Teacher_update')->name('registries.teachers.update'); //Put para dar Update dos dados
        

            // ==================== CADASTROS DE DISCIPLINAS ====================
            Route::get('/classessubjects', 'classes_subjects_registries_home_page')->name('registries.classessubjects.home'); //Pagina HOME dos Registros
            Route::get('/classessubjects/new', 'Class_Subjects_create')->name('registries.classessubjects.new'); //Pagina de Novo Registro
            Route::post('/classessubjects/store', 'Class_Subjects_store')->name('registries.classessubjects.store'); //Post para salvar os dados
            Route::get('/classessubjects/{id}/edit', 'Class_Subjects_edit')->name('registries.classessubjects.edit'); // Edit page
            Route::put('/classessubjects/{id}', 'Class_Subjects_update')->name('registries.classessubjects.update'); // Put para dar Update dos dados
            // Adicionar Conteúdos as Disciplinas
            Route::get('/classessubjects/{class_subject_id}/syllabus/create', 'Syllabus_create')->name('registries.classessubjects.syllabus.create');
            Route::post('/classessubjects/{class_subject_id}/syllabus/store', 'Syllabus_store')->name('registries.classessubjects.syllabus.store');
            Route::get('/classessubjects/syllabus/{id}/edit', 'Syllabus_edit')->name('registries.classessubjects.syllabus.edit');
            Route::put('/classessubjects/syllabus/{id}', 'Syllabus_update')->name('registries.classessubjects.syllabus.update');


            // ==================== CADASTROS DE CRONOGRAMAS ====================
            Route::get('/chronograms', 'Chronogram_home')->name('registries.chronograms.home'); //Pagina HOME dos Cronogramas
            Route::get('/chronograms/new', 'Chronogram_create')->name('registries.chronograms.new'); //Pagina de Novo Registro
            Route::post('/chronograms/store', 'Chronogram_store')->name('registries.chronograms.store'); //Post para salvar os dados
            Route::get('/chronograms/{id}/edit', 'Chronogram_edit')->name('registries.chronograms.edit'); // Edit page
            Route::put('/chronograms/{id}', 'Chronogram_update')->name('registries.chronograms.update'); // Put para dar Update dos dados      
            // Adicionando Tarefas a um Cronograma
            Route::get('/chronograms/{chronogram_id}/selecthomeworks', 'Homeworks_select')->name('select_homeworks');
            Route::post('/chronograms/{chronogram_id}/savehomeworks', 'Homeworks_save')->name('save_homeworks');
            Route::delete('/chronograms/{chronogram_id}/homeworks/{homework_id}', 'Homework_delete')->name('delete_homework');


            // ==================== CADASTROS DE CLASSES ====================
            Route::get('/classes', 'Class_home')->name('registries.classes.home'); //Pagina HOME das Turmas
            Route::get('/classes/new', 'Class_create')->name('registries.classes.new'); //Pagina de Novo Registro
            Route::post('/classes/store', 'Class_store')->name('registries.classes.store'); //Post para salvar os dados
            Route::get('/classes/{id}/edit', 'Class_edit')->name('registries.classes.edit'); // Edit page
            Route::put('/classes/{id}', 'Class_update')->name('registries.classes.update'); // Put para dar Update dos dados      
            // Adicionando Cronogramas a uma Classe
            Route::get('/classes/{class_id}/selectchronograms', 'Chronograms_select')->name('select_chronograms');
            Route::post('/classes/{class_id}/savechronograms', 'Chronograms_save')->name('save_chronograms');
            Route::delete('/classes/{class_id}/chronograms/{chronograms_id}', 'Chronograms_delete')->name('delete_chronograms');
            // Adicionando Professores a uma Classe
            Route::get('/classes/{class_id}/selectteachers', 'Teachers_select')->name('select_teachers');
            Route::post('/classes/{class_id}/saveteachers', 'Teachers_save')->name('save_teachers');
            Route::delete('/classes/{class_id}/teachers/{Teachers_id}', 'Teachers_delete')->name('delete_teachers');
            // Adicionando Disciplinas a uma Classe
            Route::get('/classes/{class_id}/selectsubjects', 'Subjects_select')->name('select_subjects');
            Route::post('/classes/{class_id}/savesubjects', 'Subjects_save')->name('save_subjects');
            Route::delete('/classes/{class_id}/subjects/{subjects_id}', 'Subjects_delete')->name('delete_subjects');


            // ==================== NOTIFICAÇÕES ====================
            Route::get('/notifications', 'Notifications_home')->name('notifications.home'); 
            Route::get('/notifications/tutor/{tutor_id}', 'Notifications_create_tutor')->name('notifications.create.tutor');  
            Route::get('/notifications/class/{class_id}', 'Notifications_create_class')->name('notifications.create.class'); 
            Route::post('/notifications/tutor/{tutor_id}', 'Notifications_store_tutor')->name('notifications.store.tutor');  
            Route::post('/notifications/class/{class_id}', 'Notifications_store_class')->name('notifications.store.class'); 


            // ==================== RELATÓRIO ====================
            Route::get('/reports/home', 'Reports_Home')->name('reports.home'); 
            // Frequencia
            Route::get('/reports/frequency', 'Frequency_reports_table')->name('frequencyreports.table'); 
            Route::get('/reports/frequencydata', 'fetchFrequencyData')->name('fetchFrequencyData');
            // Notas
            Route::get('/reports/grades', 'Grades_reports_table')->name('gradesreports.table'); 
            Route::get('/reports/gradesdata', 'fetchGradesData')->name('fetchGradesData');
            // Atividades
            Route::get('/reports/activities', 'Activities_reports_table')->name('activitiesreport.table'); 
            Route::get('/reports/activitiesdata', 'fetchActivitiesData')->name('fetchActivitiesData');
            // Estudantes Alocados por classe
            Route::get('/reports/sstudents', 'Sstudents_reports_table')->name('sstudentsreport.table'); 
            Route::get('/reports/sstudentsdata', 'fetchSstudentsData')->name('fetchSstudentsData');


        });
});


    // ##################################################################
    // #                                                                #
    // #                    ROTAS DOS PROFESSORES                       #
    // #          /app/Http/Controllers/TeacherController.php           #
    // ##################################################################


// rotas protegidas para professores
Route::middleware(['auth'])->group(function () {
    Route::controller(TeacherController::class)
        ->prefix('teachers')
        ->name('teachers.')
        ->group(function () {

            // ==================== MENU PRINCIPAL ====================
            Route::get('/home', 'Teacher_home_page')->name('home');

            // ==================== LIBERAR TAREFAS ====================
            Route::get('/homeworks/Home', 'Homework_home_page')->name('homework.home');
            Route::get('/homeworks/{class_id}', 'Homework_table_page')->name('homework.table');
            Route::put('/homeworks/update/{class_id}', 'Homework_update')->name('homework.update');

            // ==================== LIBERAR ATIVIDADES ====================
            Route::get('/activities/Home', 'Activity_home_page')->name('activity.home');
            Route::get('/activities/{class_id}', 'Activity_table_page')->name('activity.table');
            Route::put('/activities/update/{class_id}','Activity_update')->name('activity.update');

            // ==================== REGISTRAR FREQUÊNCIA ====================
            Route::get('/frequency/Home', 'Frequency_home_page')->name('frequency.home');
            Route::get('/frequency/{class_id}', 'Frequency_table_page')->name('frequency.table');
            Route::get('/frequency/{class_id}/create/{date}', 'Frequency_create')->name('frequency.create');
            Route::post('/frequency/store', 'Frequency_store')->name('frequency.store');
            Route::get('/frequency/edit/{class_id}/{frequency_table_id}', 'Frequency_edit')->name('frequency.edit');
            Route::put('/frequency/update/{frequency_table_id}/{class_id}','Frequency_update')->name('frequency.update');

            // ==================== REGISTRAR BOLETIM ====================
            Route::get('/grades/home', 'Grades_home_page')->name('grades.home');
            Route::get('/grades/{class_id}', 'Grades_table_page')->name('grades.table');

            Route::get('/grades/create/{student_user_id}/{class_id}', 'Grades_create')->name('grades.create');
            Route::post('/grades/store', 'Grades_store')->name('grades.store');
            Route::get('grades/edit/{student_user_id}/{evaluation_id}/{class_id}', 'Grades_edit')->name('grades.edit');
            Route::post('grades/update/{evaluation_id}', 'Grades_update')->name('grades.update');

            // ==================== ENVIAR VÍDEOS ====================
            Route::get('/videos/home', 'Videos_home_page')->name('videos.home');
            Route::post('/videos/store', 'Videos_store')->name('videos.store');
            Route::delete('/videos/delete/{video_id}', 'Videos_delete')->name('videos.delete');
            // ==================== NOTIFICAÇÕES ====================

        });
});


    // ##################################################################
    // #                                                                #
    // #                       ROTAS DOS TUTORES                        #
    // #          /app/Http/Controllers/TutorController.php             #
    // ##################################################################


// rotas protegidas para Tutores
Route::middleware(['auth'])->group(function () {
    Route::controller(TutorController::class)
        ->prefix('tutors')
        ->name('tutors.')
        ->group(function () {

            // ==================== MENU PRINCIPAL ====================
            Route::get('/home/', 'Tutor_home')->name('home');
            Route::get('/home/{student_user_id}', 'Tutor_home_page')->name('home.student.get');
            Route::post('/home/{student_user_id}', 'Tutor_home_page')->name('home.student');

            // ==================== VER TAREFAS ====================
            Route::get('/homeworks/{student_user_id}', 'Homework_table_page')->name('homework.table');

            // ==================== VER ATIVIDADES ====================
            Route::get('/activities/{student_user_id}', 'Activities_table_page')->name('activity.table');

            // ==================== VER BOLETIM ====================
            Route::get('/grades/{student_user_id}', 'Grades_table_page')->name('grades.table');

            // ==================== VER NOTIFICAÇÕES ====================
            Route::get('/notifications/{student_user_id}', 'Notifications_home')->name('notifications.home');

            // ==================== RELATÓRIOS ====================
            Route::get('/reports/home/{student_user_id}', 'Reporst_Home')->name('reports.home'); 
            // Frequencia
            Route::get('/reports/frequency/{student_user_id}', 'Frequency_reports_table')->name('frequencyreports.table'); 
            Route::get('/reports/frequencydata/{student_user_id}', 'fetchFrequencyData')->name('fetchFrequencyData');
            // Notas
            Route::get('/reports/grades/{student_user_id}', 'Grades_reports_table')->name('gradesreports.table'); 
            Route::get('/reports/gradesdata/{student_user_id}', 'fetchGradesData')->name('fetchGradesData');
            // Atividades
            Route::get('/reports/activities/{student_user_id}', 'Activities_reports_table')->name('activitiesreport.table'); 
            Route::get('/reports/activitiesdata/{student_user_id}', 'fetchActivitiesData')->name('fetchActivitiesData');
            // Videos
            Route::get('/videos/home/{student_user_id}', 'Videos_home_page')->name('videos.home');

        });
});




    // ##################################################################
    // #                                                                #
    // #                       ROTAS DOS ALUNOS                         #
    // #          /app/Http/Controllers/TutorController.php             #
    // ##################################################################


// rotas protegidas para Tutores
Route::middleware(['auth'])->group(function () {
    Route::controller(StudentController::class)
        ->prefix('students')
        ->name('students.')
        ->group(function () {

            // ==================== MENU PRINCIPAL ====================
            Route::get('/home', 'Student_home')->name('home');

            // ==================== TAREFAS ====================
            Route::get('/homeworks', 'Homework_table_page')->name('homework.table');

            // ==================== ATIVIDADES ====================
            Route::get('/activities', 'Activities_table_page')->name('activity.table');

            //  ==================== VÍDEOS ====================
            Route::get('/videos/home', 'Videos_home_page')->name('videos.home');
            
        });
});        


