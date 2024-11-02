<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $roles = null)
    {
        \Log::info('CheckRole middleware called'); // Add this line

        // Convert the roles string into an array
        $allowedRoles = explode('|', $roles ?? '');

        // Check if the user is authenticated
        if (Auth::check()) {
            // Check if the user's role is in the allowed roles
            if (!empty($allowedRoles) && !in_array(Auth::user()->user_role, $allowedRoles)) {
                return redirect()->route('Mainhome'); // Redirect if the role doesn't match
            }

            // If the user is authenticated and trying to access login routes, redirect them to home
            if ($request->is('login*')) {
                return redirect()->route('Mainhome');
            }
        }

        return $next($request); // Allow the request to proceed if no conditions are met
    }
}