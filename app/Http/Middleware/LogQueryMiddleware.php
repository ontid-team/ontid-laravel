<?php

namespace App\Http\Middleware;

use App\Jobs\QueryLogger;
use App\Payloads\QueryLoggerPayload;
use Closure;
use DB;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Http\Request;

class LogQueryMiddleware
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
        DB::listen(function (QueryExecuted $query) {
            QueryLogger::dispatch(
                new QueryLoggerPayload($query->time, $query->sql, $query->bindings)
            );
        });
        return $next($request);
    }
}
