<?php

namespace App\Http\Middleware;

use App\Classes\RouteName;
use App\Exceptions\InvalidRequestHeadersException;
use Closure;
use \Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     * @throws InvalidRequestHeadersException
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            throw new InvalidRequestHeadersException();
        }
    }

    /**
     * @todo need refactoring token cleaning
     * @throws AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        try {
            $this->authenticate($request, $guards);
        } catch (AuthenticationException $e) {
            if ($request->routeIs(RouteName::REFRESH_TOKEN)) {
                $domain = config('app.domain');
                setcookie('access_token', '', -1, "/", $domain, 0, 0);
                setcookie('refresh_token', '', -1, "/", $domain, 0, 0);
                setcookie('user', '', -1, "/", $domain, 0, 0);
            }
            throw new AuthenticationException('Unauthenticated.', $guards);
        }
        $user = $request->user();
        $result = $user?->tokens()->where(function ($q) {
            $q->where('name', 'access_token')->where('created_at', '<', now()->subMinutes(60)->format('Y-m-d H:i:s'));
        })->orWhere(function ($q) {
            $q->where('name', 'refresh_token')->where('created_at', '<', now()->subDays(30)->format('Y-m-d H:i:s'));
        })->delete();
        if ($result > 0) throw new AuthenticationException('Unauthenticated.', $guards);

        return $next($request);
    }
}

