<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoleCheckService
{
    /**
     * Check if the authenticated user has one of the allowed roles.
     *
     * @param array $roles
     * @return bool
     */
    public function checkUserRole(array $roles): bool
    {
        if (!Auth::check()) {
            return false;
        }

        $user = Auth::user();
        $userRole = Auth::user()->user_role;


        //dd($userRole);
        if ($userRole === 'teacher') {
            $teacher = DB::table('tb_teachers')
                        ->where('teacher_user_id', $user->user_id) 
                        ->first();

            if ($teacher) {
                $userRole = $teacher->coordinator === 0 ? 'teacher' : 'coordinator';
            }
        }
        //dd($userRole);
        return in_array($userRole, $roles);
    }
}