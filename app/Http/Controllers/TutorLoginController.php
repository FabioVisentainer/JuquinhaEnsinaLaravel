<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\TutorLoginService;

// importar o model de importar a base de dados


//Aqui Estão os Controlles de Login da Página Home
class TutorLoginController
{
    protected $loginService;

    public function __construct(TutorLoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function login_submit(LoginRequest $request)
    {
        return $this->loginService->loginTutor($request);
    }
}