<?php

namespace Stylers\LaravelBan\Tests\Unit\Models;

use Illuminate\Support\Carbon;
use Stylers\LaravelBan\Models\Ban;
use Stylers\LaravelBan\Tests\Fixtures\Models\User;
use Stylers\LaravelBan\Tests\TestCase;

class BanTest extends TestCase
{
    /**
     * @test
     */
    public function start_at_default_value_is_now()
    {
        $startAt = Carbon::now();
        $ban = factory(Ban::class)->create();
        $ban->refresh();

        $this->assertEquals($startAt->format('YmdHis'), $ban->start_at->format('YmdHis'));
    }

    /**
     * @test
     */
    public function end_at_default_value_is_null()
    {
        $ban = factory(Ban::class)->create();
        $ban->refresh();

        $this->assertNull($ban->end_at);
    }

    /**
     * @test
     */
    public function get_bannable_relation()
    {
        $ban = factory(Ban::class)->create();
        $ban->refresh();

        $this->assertNotNull($ban->bannable);
        $this->assertEquals(User::class, $ban->bannable->getMorphClass());
    }

    /**
     * @test
     */
    public function get_createdBy_relation()
    {
        $createdBy = factory(User::class)->create();
        $ban = factory(Ban::class)->make();
        $ban->createdBy()->associate($createdBy);
        $ban->save();

        $this->assertNotNull($ban->createdBy);
        $this->assertEquals(User::class, $ban->createdBy->getMorphClass());
    }

    /**
     * @test
     */
    public function get_live_bans_but_not_exist()
    {
        factory(Ban::class, 5)->create([
            'end_at' => Carbon::now()->subWeek(),
        ]);

        $query = app(Ban::class)->live();
        $this->assertEquals(0, $query->count());
    }

    /**
     * @test
     */
    public function get_live_bans()
    {
        $count = 5;

        factory(Ban::class, $count * 2)->create([
            'end_at' => Carbon::now()->subWeek(), // expired
        ]);

        factory(Ban::class, $count)->create([
            'end_at' => Carbon::now()->addWeek(), // not expired
        ]);

        $query = app(Ban::class)->live();
        $this->assertEquals($count, $query->count());
    }

    /**
     * @test
     */
    public function get_not_live_bans()
    {
        $count = 5;

        factory(Ban::class, $count)->create([
            'end_at' => Carbon::now()->subWeek(), // expired
        ]);

        factory(Ban::class, $count * 2)->create([
            'end_at' => Carbon::now()->addWeek(), // not expired
        ]);

        $query = app(Ban::class)->notLive();
        $this->assertEquals($count, $query->count());
    }

    /**
     * @test
     */
    public function get_bans_by_bannable_but_not_found()
    {
        $bannable = factory(User::class)->create();
        factory(Ban::class)->create();

        $query = app(Ban::class)->whereBannable($bannable);
        $this->assertEquals(0, $query->count());
    }

    /**
     * @test
     */
    public function get_ban_by_bannable()
    {
        factory(Ban::class, 5)->create();
        $ban = factory(Ban::class)->create();

        $query = app(Ban::class)->whereBannable($ban->bannable);
        $this->assertEquals(1, $query->count());
        $this->assertEquals($ban->id, $query->first()->id);
    }
}