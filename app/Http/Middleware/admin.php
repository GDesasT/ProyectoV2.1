<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $role): Response
{
    $user = $request->user();

    if ($user) {
        $user->load('role');
        // dd($user->role->type);
    }

    if (!$user || !$user->role || $user->role->type !== $role) {
        return redirect('/login')->with('error', 'Access denied. You do not have the required role.');
    }

    return $next($request);
}

}
