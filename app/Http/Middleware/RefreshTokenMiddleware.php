<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RefreshTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->tokenCan('refresh_token')) {
            return $next($request);
        }
        return response()->json(['code' => 401, 'message' => 'Unauthorized', 'data' => null, 'error' => null], 200);
    }
}
