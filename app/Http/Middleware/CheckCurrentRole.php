<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckCurrentRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        $currentRole = $user->currentRole();
        
        if ($currentRole !== $role) {
            // Redirect to home if current role doesn't match required role
            return redirect()->route('home')->with('error', 'No tienes acceso a esta sección con tu rol actual.');
        }

        return $next($request);
    }
}
