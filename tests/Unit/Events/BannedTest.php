<?php declare(strict_types=1);

namespace Stylers\LaravelBan\Tests\Unit\Events;

use Stylers\LaravelBan\Events\Banned;
use Stylers\LaravelBan\Models\Ban;
use Stylers\LaravelBan\Tests\Fixtures\Models\User;
use Stylers\LaravelBan\Tests\TestCase;
use Illuminate\Support\Facades\Event;

class BannedTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_fire_event(): void
    {
        Event::fake(Banned::class);

        $ban = factory(Ban::class)->create();

        Event::assertDispatched(Banned::class);
    }

    /**
     * @test
     */
    public function it_can_fire_event_where_ban(): void
    {
        Event::fake(Banned::class);

        $bannable = factory(User::class)->create();
        $ban = $bannable->ban();

        Event::assertDispatched(Banned::class);
    }
}