<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param Request $request
	 * @param Closure(Request): (Response) $next
	 * @return Response
	 */
	public function handle(Request $request, Closure $next): Response
	{
		if (auth()->user()->tokenCan('role:user')) {
			return $next($request);
		}
		return response()->json(['code' => 401, 'message' => 'Unauthorized', 'data' => null, 'error' => null], 200);
	}
}
