<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $apiKey = env('API_KEY');

        if (!$apiKey || $request->header('X-API-KEY') !== $apiKey) {
            return response()->json(['message' => 'API key is missing or invalid.'], 403);
        }

        return $next($request);
    }
}
