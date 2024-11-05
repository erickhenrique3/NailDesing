<?php

// App\Http\Middleware\AdminMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
  public function handle(Request $request, Closure $next): Response
  {
      if (!Auth::guard('api')->check()) {
          return response()->json([
              'status' => false,
              'message' => 'Unauthorized - Please log in'
          ], 401);
      }

      $user = Auth::user();
      if ($user->role !== 'admin') {
          return response()->json([
              'status' => false,
              'message' => 'Access denied - Admins only'
          ], 403);
      }

      
      return $next($request);
  }
}
