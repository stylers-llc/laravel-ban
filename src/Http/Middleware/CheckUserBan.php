<?php

namespace Stylers\LaravelBan\Http\Middleware;

use Closure;
use Stylers\LaravelBan\Exceptions\UserIsBannedException;

/**
 * Class CheckUserBan
 * @package Stylers\LaravelBan\Http\Middleware
 */
class CheckUserBan
{
    /**
     * Handle the incoming request.
     *
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws UserIsBannedException
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
        if (!is_null($user) && $user->isBanned()) {
            throw new UserIsBannedException(trans('ban.user_is_banned'));
        }

        return $next($request);
    }
}