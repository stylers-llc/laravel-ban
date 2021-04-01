<?php

namespace Stylers\LaravelBan\Tests\Unit\Http\Middleware;

use Illuminate\Http\Request;
use Stylers\LaravelBan\Exceptions\UserIsBannedException;
use Stylers\LaravelBan\Http\Middleware\CheckUserBan;
use Stylers\LaravelBan\Tests\Fixtures\Models\User;
use Stylers\LaravelBan\Tests\TestCase;

class CheckUserBanTest extends TestCase
{
    /**
     * @test
     */
    public function banned_user_can_not_access()
    {
        $this->expectException(UserIsBannedException::class);
        $user = factory(User::class)->create();
        $user->ban();
        $this->actingAs($user);

        $middleware = new CheckUserBan();
        $request = Request::create('/', 'GET');
        $middleware->handle($request, function () {
        });
    }

    /**
     * @test
     */
    public function not_banned_user_access()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $middleware = new CheckUserBan();
        $request = Request::create('/', 'GET');
        $response = $middleware->handle($request, function () {
            return true;
        });

        $this->assertTrue($response);
    }
}