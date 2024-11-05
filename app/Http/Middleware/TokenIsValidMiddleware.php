<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TokenIsValidMiddleware
{

	public function handle(Request $request, Closure $next): Response
	{
		if (!Auth::guard('api')->check()) {
			return response()->json([
					'status' => false,
					'message' => 'Unauthorized'
			], 401);
	}

		return $next($request);
	}
}