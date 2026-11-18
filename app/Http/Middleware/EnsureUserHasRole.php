<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * RBAC: route hanya bisa diakses user dengan role yang disebut.
 * Pemakaian: ->middleware('role:admin') atau 'role:admin,pustakawan'.
 */
class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        abort_unless(
            $request->user() && in_array($request->user()->role, $roles, true),
            403,
            'Anda tidak memiliki hak akses ke halaman ini.'
        );

        return $next($request);
    }
}
