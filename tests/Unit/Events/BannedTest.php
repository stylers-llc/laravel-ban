<?php

namespace Stylers\LaravelBan\Tests\Unit\Events;

use Stylers\LaravelBan\Events\Banned;
use Stylers\LaravelBan\Models\Ban;
use Stylers\LaravelBan\Tests\Fixtures\Models\User;
use Stylers\LaravelBan\Tests\TestCase;

class BannedTest extends TestCase
{
    /**
     * @test
     * @throws \Exception
     */
    public function it_can_fire_event()
    {
        $this->expectsEvents(Banned::class);

        factory(Ban::class)->create();
    }

    /**
     * @test
     * @throws \Exception
     */
    public function it_can_fire_event_where_ban()
    {
        $this->expectsEvents(Banned::class);

        $bannable = factory(User::class)->create();
        $bannable->ban();
    }
}