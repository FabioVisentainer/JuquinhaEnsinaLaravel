<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TeacherLoginService
{
    public function loginTeacher(Request $request)
    {
        // Fetch the user using the Eloquent model
        $user = User::where('username', $request->user)
                    ->whereIn('user_role', ['administrator', 'teacher'])
                    ->first();

        // Check if user exists and password is correct
        if ($user && Hash::check($request->password, $user->password_hash)) {
            // Log the user in
            Auth::login($user);

            // Redirect based on user role
            if ($user->user_role === 'administrator') {
                return redirect()->route('coordinators.home');
            }

            if ($user->user_role === 'teacher') {
                // Fetch the teacher details
                $teacher = DB::table('tb_teachers')
                            ->where('teacher_user_id', $user->user_id) // Match the user_id from the logged-in user
                            ->first();

                //dd($teacher);
                // Check the coordinator status and redirect accordingly
                if ($teacher && $teacher->coordinator === 0) {
                    //dd('Professor');
                    return redirect()->route('teachers.home'); // Non-coordinator
                } else {
                    //dd('Coordenador');
                    return redirect()->route('coordinators.home'); // Coordinator
                }
            }
        }

        // If login fails, return an error message
        return back()->with('error', 'Invalid credentials or insufficient permissions.');
    }
}