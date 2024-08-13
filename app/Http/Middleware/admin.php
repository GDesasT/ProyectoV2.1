<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\UserController;

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
    public function handle(Request $request, Closure $next, ...$roles): Response
{
    $user = $request->user();

    if ($user) {
        $user->load('role');
    }

    if (!$user || !$user->role || !in_array($user->role->type, $roles)) {
        return redirect()->action([UserController::class, 'showLoginForm'])->with('error', 'Access denied. You do not have the required role.');
    }

    return $next($request);
}

}
