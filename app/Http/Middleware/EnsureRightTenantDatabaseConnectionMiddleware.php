<?php

namespace App\Http\Middleware;

use App\Actions\EnsureRightTenantDatabaseConnection;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRightTenantDatabaseConnectionMiddleware
{
    use EnsureRightTenantDatabaseConnection;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->makeCurrent();
        return $next($request);
    }
}
