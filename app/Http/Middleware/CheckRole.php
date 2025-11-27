<?php

namespace App\Http\Middleware;

use App\MyHelper\Constants\HttpStatusCodes;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$role): Response
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => 'Unauthenticated'
            ], 401);
        }

        $userRoles = $user->roles->pluck('name')->toArray();

        $hasRole = count(array_intersect($role, $userRoles)) > 0;

        if (!$hasRole) {
            return response()->json([
                'error' => true,
                'message' => 'Access denied. You do not have the required role.'
            ], 403);
        }

        return $next($request);
    }
}
