<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Students can only access viewgrade routes
        if ($user->role === 'student') {
            if (!$request->is('viewgrade*')) {
                return redirect()->route('viewgrade.index');
            }
        }

        // For admin, allow access to all routes
        if ($user->role === 'admin') {
            return $next($request);
        }

        // For any other role or if role is not set
        abort(403, 'Unauthorized access');
    }
}
