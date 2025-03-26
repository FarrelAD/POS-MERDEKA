<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $req, Closure $next, string $role = ''): Response
    {
        $user = $req->user();

        if ($user->hasRole($role)) {
            return $next($req);
        }

        abort(Response::HTTP_FORBIDDEN, 'TERLARANG! Anda tidak punya akses ke halaman ini');
    }
}
