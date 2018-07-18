<?php

namespace Stylers\LaravelBan\Tests\Unit\Builders;

use Carbon\Carbon;
use Stylers\LaravelBan\Contracts\Builders\BanBuilderInterface;
use Stylers\LaravelBan\Models\Ban;
use Stylers\LaravelBan\Tests\Fixtures\Models\User;
use Stylers\LaravelBan\Tests\TestCase;

class BanBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_build()
    {
        $createdBy = factory(User::class)->create();
        $bannable = factory(User::class)->create();
        $comment = str_random();
        $endAt = Carbon::now()->addWeek();

        $builder = app(BanBuilderInterface::class);
        $builder->setCreatedBy($createdBy);
        $builder->setBannable($bannable);
        $builder->setComment($comment);
        $builder->setendAt($endAt);
        $builder->build();

        $this->assertDatabaseHas('bans', [
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
    public function it_can_set_ban()
    {
        $ban = factory(Ban::class)->create();

        $createdBy = factory(User::class)->create();
        $comment = str_random();
        $endAt = Carbon::now()->addYear();

        $builder = app(BanBuilderInterface::class);
        $builder->setBan($ban);
        $builder->setCreatedBy($createdBy);
        $builder->setBannable($ban->bannable);
        $builder->setComment($comment);
        $builder->setendAt($endAt);
        $builder->build();

        $this->assertNotNull($ban->created_by_type);
        $this->assertNotNull($ban->created_by_id);
        $this->assertEquals($comment, $ban->comment);
        $this->assertEquals($endAt->format('YmdHis'), $ban->end_at->format('YmdHis'));

        $this->assertDatabaseHas('bans', [
            'id' => $ban->id,
            'bannable_type' => $ban->bannable_type,
            'bannable_id' => $ban->bannable_id,
            'comment' => $comment,
            'created_by_type' => $ban->created_by_type,
            'created_by_id' => $ban->created_by_id,
        ]);
    }

    /**
     * @test
     */
    public function it_can_get_ban()
    {
        $ban = factory(Ban::class)->create();

        $builder = app(BanBuilderInterface::class);
        $builder->setBan($ban);

        $this->assertEquals($ban, $builder->getBan());
    }
}