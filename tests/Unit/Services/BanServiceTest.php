<?php

namespace Stylers\LaravelBan\Tests\Unit\Services;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Stylers\LaravelBan\Contracts\Builders\BanBuilderInterface;
use Stylers\LaravelBan\Contracts\Services\BanServiceInterface;
use Stylers\LaravelBan\Models\Ban;
use Stylers\LaravelBan\Tests\Fixtures\Models\User;
use Stylers\LaravelBan\Tests\TestCase;

class BanServiceTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_ban()
    {
        $createdBy = factory(User::class)->create();
        $bannable = factory(User::class)->create();
        $comment = Str::random();
        $endAt = Carbon::now()->addWeek();

        $banBuilder = app(BanBuilderInterface::class, ['bannable' => $bannable]);
        $banBuilder
            ->setCreatedBy($createdBy)
            ->setComment($comment)
            ->setendAt($endAt)
            ->build();

        $banService = app(BanServiceInterface::class);
        $ban = $banService->ban($banBuilder);

        $this->assertDatabaseHas('bans', [
            'id' => $ban->id,
            'bannable_type' => get_class($bannable),
            'bannable_id' => $bannable->id,
            'comment' => $comment,
            'created_by_type' => get_class($createdBy),
            'created_by_id' => $createdBy->id,
            'end_at' => $endAt->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * @test
     */
    public function it_can_unban()
    {
        $ban = factory(Ban::class)->create();
        $banService = app(BanServiceInterface::class);
        $banService->unban($ban->bannable);

        $ban->refresh();
        $this->assertNotNull($ban->deleted_at);
    }
}