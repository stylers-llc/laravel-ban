<?php

namespace Stylers\LaravelBan\Tests\Unit\Events;

use Stylers\LaravelBan\Events\Unbanned;
use Stylers\LaravelBan\Models\Ban;
use Stylers\LaravelBan\Tests\TestCase;

class UnbannedTest extends TestCase
{
    /**
     * @test
     * @throws \Exception
     */
    public function it_can_fire_event()
    {
        $this->expectsEvents(Unbanned::class);

        $ban = factory(Ban::class)->create();
        $ban->delete();
    }

    /**
     * @test
     * @throws \Exception
     */
    public function it_can_fire_event_where_ban()
    {
        $this->expectsEvents(Unbanned::class);

        $ban = factory(Ban::class)->create();
        $ban->bannable->unban();
    }
}