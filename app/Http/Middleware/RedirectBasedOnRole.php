<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Only redirect if we're accessing the root or dashboard
            if ($request->is('/') || $request->is('dashboard')) {
                if ($user->role === 'student') {
                    return redirect()->route('viewgrade.index');
                }
                
                if ($user->role === 'admin') {
                    return redirect()->route('dashboard');
                }
            }
        }

        return $next($request);
    }
}
