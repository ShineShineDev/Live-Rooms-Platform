<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckDevopsToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = env('DEVOPS_TOKEN');

        if ($request->header('Authorization') !== $token) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
