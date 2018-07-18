<?php

namespace Stylers\LaravelBan\Tests\Unit\Models\Traits;

use Illuminate\Support\Carbon;
use Stylers\LaravelBan\Models\Ban;
use Stylers\LaravelBan\Tests\Fixtures\Models\User;
use Stylers\LaravelBan\Tests\TestCase;

class BannableTest extends TestCase
{
    /**
     * @test
     */
    public function get_bans_relation()
    {
        $bannable = factory(User::class)->create();
        $ban = factory(Ban::class)->make();
        $ban->bannable()->associate($bannable);
        $ban->save();

        $this->assertEquals(1, $bannable->bans()->count());
        $this->assertEquals(Ban::class, $bannable->bans()->first()->getMorphClass());
    }


    /**
     * @test
     */
    public function check_is_banned_but_expired()
    {
        $ban = factory(Ban::class)->create([
            'end_at' => Carbon::now()->subWeek()
        ]);

        $this->assertFalse($ban->bannable->isBanned());
    }

    /**
     * @test
     */
    public function check_is_banned_but_not_start()
    {
        $ban = factory(Ban::class)->create([
            'start_at' => Carbon::now()->addWeek(),
            'end_at' => Carbon::now()->addWeeks(2)
        ]);

        $this->assertFalse($ban->bannable->isBanned());
    }

    /**
     * @test
     */
    public function check_is_banned()
    {
        $ban = factory(Ban::class)->create([
            'end_at' => Carbon::now()->addWeek()
        ]);

        $this->assertTrue($ban->bannable->isBanned());
    }

    /**
     * @test
     */
    public function check_is_not_banned_but_expired()
    {
        $ban = factory(Ban::class)->create([
            'end_at' => Carbon::now()->subWeek()
        ]);

        $this->assertTrue($ban->bannable->isNotBanned());
    }

    /**
     * @test
     */
    public function check_is_not_banned_but_not_start()
    {
        $ban = factory(Ban::class)->create([
            'start_at' => Carbon::now()->addWeek(),
            'end_at' => Carbon::now()->addWeeks(2)
        ]);

        $this->assertTrue($ban->bannable->isNotBanned());
    }

    /**
     * @test
     */
    public function check_is_not_banned()
    {
        $ban = factory(Ban::class)->create([
            'end_at' => Carbon::now()->addWeek()
        ]);

        $this->assertFalse($ban->bannable->isNotBanned());
    }


    /**
     * @test
     */
    public function it_can_ban_without_parameters()
    {
        $startAt = Carbon::now();
        $bannable = factory(User::class)->create();
        $bannable->ban();

        $this->assertEquals(1, $bannable->bans()->count());
        $this->assertNull($bannable->bans()->first()->comment);
        $this->assertNull($bannable->bans()->first()->end_at);
        $this->assertEquals($startAt->format('YmdHis'), $bannable->bans()->first()->start_at->format('YmdHis'));
    }

    /**
     * @test
     */
    public function it_can_ban_without_timestamps()
    {
        $bannable = factory(User::class)->create();
        $comment = str_random();
        $startAt = Carbon::now();
        $bannable->ban($comment);

        $this->assertEquals(1, $bannable->bans()->count());
        $this->assertEquals($comment, $bannable->bans()->first()->comment);
        $this->assertNull($bannable->bans()->first()->end_at);
        $this->assertEquals($startAt->format('YmdHis'), $bannable->bans()->first()->start_at->format('YmdHis'));
    }

    /**
     * @test
     */
    public function it_can_ban_without_and_at()
    {
        $bannable = factory(User::class)->create();
        $comment = str_random();
        $startAt = Carbon::now();
        $bannable->ban($comment, $startAt);

        $this->assertEquals(1, $bannable->bans()->count());
        $this->assertEquals($comment, $bannable->bans()->first()->comment);
        $this->assertNull($bannable->bans()->first()->end_at);
        $this->assertEquals($startAt->format('YmdHis'), $bannable->bans()->first()->start_at->format('YmdHis'));
    }

    /**
     * @test
     */
    public function it_can_ban_without_comment_and_and_at()
    {
        $bannable = factory(User::class)->create();
        $startAt = Carbon::now();
        $bannable->ban(null, $startAt);

        $this->assertEquals(1, $bannable->bans()->count());
        $this->assertNull($bannable->bans()->first()->comment);
        $this->assertNull($bannable->bans()->first()->end_at);
        $this->assertEquals($startAt->format('YmdHis'), $bannable->bans()->first()->start_at->format('YmdHis'));
    }

    /**
     * @test
     */
    public function it_can_ban_without_comment_and_start_at()
    {
        $bannable = factory(User::class)->create();
        $startAt = Carbon::now();
        $endAt = Carbon::now()->addMonth();
        $bannable->ban(null, null, $endAt);

        $this->assertEquals(1, $bannable->bans()->count());
        $this->assertNull($bannable->bans()->first()->comment);
        $this->assertEquals($endAt->format('YmdHis'), $bannable->bans()->first()->end_at->format('YmdHis'));
        $this->assertEquals($startAt->format('YmdHis'), $bannable->bans()->first()->start_at->format('YmdHis'));
    }

    /**
     * @test
     */
    public function it_can_ban()
    {
        $bannable = factory(User::class)->create();
        $startAt = Carbon::now()->addWeek();
        $endAt = Carbon::now()->addMonth();
        $comment = str_random();
        $bannable->ban($comment, $startAt, $endAt);

        $this->assertEquals(1, $bannable->bans()->count());
        $this->assertEquals($comment, $bannable->bans()->first()->comment);
        $this->assertEquals($startAt->format('YmdHis'), $bannable->bans()->first()->start_at->format('YmdHis'));
        $this->assertEquals($endAt->format('YmdHis'), $bannable->bans()->first()->end_at->format('YmdHis'));
    }

    /**
     * @test
     */
    public function it_can_ban_with_auth_user()
    {
        $auth = factory(User::class)->create();
        $this->be($auth);

        $bannable = factory(User::class)->create();
        $endAt = Carbon::now()->addMonth();
        $comment = str_random();
        $bannable->ban($comment, null, $endAt);

        $this->assertEquals(1, $bannable->bans()->count());
        $this->assertEquals($comment, $bannable->bans()->first()->comment);
        $this->assertEquals($endAt->format('YmdHis'), $bannable->bans()->first()->end_at->format('YmdHis'));
        $this->assertEquals($auth->id, $bannable->bans()->first()->createdBy->id);
    }

    /**
     * @test
     */
    public function it_can_ban_again()
    {
        $bannable = factory(User::class)->create();
        $bannable->ban();
        $bannable->ban(null, null, Carbon::now()->subWeek());
        $bannable->ban(null, null, Carbon::now()->addWeek());
        $bannable->ban(null, null, Carbon::now()->addWeek());
        $bannable->ban();

        $this->assertEquals(5, $bannable->bans()->count());
    }

    /**
     * @test
     */
    public function it_can_unban_without_bans()
    {
        $bannable = factory(User::class)->create();
        $bannable->unban();

        $this->assertEquals(0, $bannable->isBanned());
    }

    /**
     * @test
     */
    public function it_can_unban_expired_ban()
    {
        $bannable = factory(User::class)->create();
        $bannable->ban(null, Carbon::now()->subWeek());
        $bannable->unban();

        $this->assertEquals(0, $bannable->isBanned());
    }

    /**
     * @test
     */
    public function it_can_unban_expire_ban()
    {
        $bannable = factory(User::class)->create();
        $bannable->ban(null, null, Carbon::now()->addWeek());
        $bannable->unban();

        $this->assertEquals(0, $bannable->isBanned());
    }

    /**
     * @test
     */
    public function unban_not_expire_ban()
    {
        $bannable = factory(User::class)->create();
        $bannable->ban();
        $bannable->unban();

        $this->assertEquals(0, $bannable->isBanned());
    }

    /**
     * @test
     */
    public function it_can_unban_bans()
    {
        $bannable = factory(User::class)->create();
        $bannable->ban(null, null, Carbon::now()->subMonth());
        $bannable->ban(null, null, Carbon::now()->subWeek());
        $bannable->ban();
        $bannable->unban();

        $this->assertEquals(0, $bannable->isBanned());
    }

    /**
     * @test
     */
    public function it_can_unban_again()
    {
        $bannable = factory(User::class)->create();
        $bannable->unban();
        $bannable->unban();

        $this->assertEquals(0, $bannable->isBanned());
    }


    /**
     * @test
     */
    public function get_banned_users_but_not_exist()
    {
        factory(User::class, 5)->create();
        $this->assertEquals(0, app(User::class)->banned()->count());
    }

    /**
     * @test
     */
    public function get_banned_users()
    {
        $bannables = factory(User::class, 5)->create();
        $ban = factory(Ban::class)->make();
        $ban->bannable()->associate($bannables->first());
        $ban->save();

        $this->assertEquals(1, app(User::class)->banned()->count());
    }

    /**
     * @test
     */
    public function get_not_banned_users_but_not_exist()
    {
        factory(Ban::class, 5)->create();
        $this->assertEquals(0, app(User::class)->notBanned()->count());
    }

    /**
     * @test
     */
    public function get_not_banned_users()
    {
        $count = 5;
        factory(User::class, $count)->create();
        factory(Ban::class)->create();

        $this->assertEquals($count + 1, app(User::class)->all()->count());
        $this->assertEquals($count, app(User::class)->notBanned()->count());
    }

    /**
     * @test
     */
    public function get_not_banned_users_but_expired()
    {
        $count = 5;
        $bannables = factory(User::class, $count)->create();

        $bannable = $bannables->first();
        $bannable->ban(null, null, Carbon::now()->subWeek());

        $this->assertEquals($count, app(User::class)->all()->count());
        $this->assertEquals($count, app(User::class)->notBanned()->count());
    }

    /**
     * @test
     */
    public function get_not_banned_users_with_with_expired_but_expire_banned()
    {
        $count = 5;
        $bannables = factory(User::class, $count)->create();

        $bannable = $bannables->first();
        $bannable->ban(null, null, Carbon::now()->subWeek());
        $bannable->ban(null, null, Carbon::now()->addWeek());

        $this->assertEquals($count, app(User::class)->all()->count());
        $this->assertEquals($count - 1, app(User::class)->notBanned()->count());
    }

    /**
     * @test
     */
    public function get_not_banned_users_with_with_expired_but_not_expire_banned()
    {
        $count = 5;
        $bannables = factory(User::class, $count)->create();

        $bannable = $bannables->first();
        $bannable->ban(null, null, Carbon::now()->subWeek());
        $bannable->ban();

        $this->assertEquals($count, app(User::class)->all()->count());
        $this->assertEquals($count - 1, app(User::class)->notBanned()->count());
    }
}