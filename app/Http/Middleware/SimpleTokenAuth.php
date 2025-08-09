<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SimpleTokenAuth
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');
        $expectedToken = 'Bearer ' . env('API_TOKEN', 'your-secret-token');

        if ($token !== $expectedToken) {
            return response()->json([
                'success' => false,
                'message' => 'Token de autenticação inválido'
            ], 401);
        }

        return $next($request);
    }
} 