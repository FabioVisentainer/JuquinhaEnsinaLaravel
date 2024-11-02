<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Services\TeacherLoginService;
use App\Services\TutorLoginService;
use App\Services\StudentLoginService;

// importar o model de importar a base de dados


//Aqui Estão os Controlles de Login da Página Home
class HomeController extends Controller
{
    
    protected $loginService;
    
    //
    public function student_login_page()
    {
        return view('logins.studentlogin'); 
    }

    public function teacher_login_page()
    {
        return view('logins.teacherlogin'); 
    }

    public function tutor_login_page()
    {
        return view('logins.tutorlogin'); 
    }

}


