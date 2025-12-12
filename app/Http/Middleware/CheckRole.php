<?php

namespace App\Http\Middleware;

use App\MyHelper\Constants\HttpStatusCodes;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
     public function handle(Request $request, Closure $next, $roles)
    {
        $roles = explode('|', $roles);

        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => 'Unauthenticated'
            ], 401);
        }

        // Ambil role user dari tabel user_roles + roles
        $userRoles = DB::table('user_roles')
            ->join('roles', 'roles.id', '=', 'user_roles.roleId')
            ->where('user_roles.userId', $user->id)
            ->pluck('roles.name')
            ->toArray();

        // Debug jika ingin melihat role user:
        // dd($userRoles);

        // Cek apakah user punya salah satu role yang dibutuhkan
        $hasRole = count(array_intersect($roles, $userRoles)) > 0;

        if (!$hasRole) {
            return response()->json([
                'error' => true,
                'message' => 'Access denied. You do not have the required role.'
            ], 403);
        }

        return $next($request);
    }
}
