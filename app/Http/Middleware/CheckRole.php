<?php

namespace App\Http\Middleware;

use App\MyHelper\Constants\HttpStatusCodes;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Tidak login / token invalid
        if (!$request->user()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'INVALID_CREDENTIAL'
            ], HttpStatusCodes::HTTP_UNAUTHORIZED);
        }


        // Role tidak sesuai
        if (!$request->user()->hasAnyRole($roles)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'FORBIDDEN'
            ], HttpStatusCodes::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
