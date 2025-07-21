<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->is('api/*')) {
            return $next($request);
        }

        if ($request->bearerToken() !== env('API_TOKEN')) {
            return response()->json(
                ['message' => 'Unauthorized'],
                401
            );
        }

        return $next($request);
    }
}
