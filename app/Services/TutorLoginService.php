<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TutorLoginService
{
    public function loginTutor(Request $request)
    {
        // Fetch the user using the Eloquent model
        $user = User::where('username', $request->user)
                    ->whereIn('user_role', ['tutor'])
                    ->first();

        // Check if user exists and password is correct
        if ($user && Hash::check($request->password, $user->password_hash)) {
            // Log the user in
            Auth::login($user);

            // Redirect based on user role
            if ($user->user_role === 'tutor') {
                return redirect()->route('tutors.home'); // Non-coordinator
            }
        }

        // If login fails, return an error message
        return back()->with('error', 'Invalid credentials or insufficient permissions.');
    }
}