<?php

namespace Stylers\LaravelBan\Tests\Unit\Builders;

use Carbon\Carbon;
use Illuminate\Support\Str;
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
        $comment = Str::random();
        $endAt = Carbon::now()->addWeek();

        $builder = app(BanBuilderInterface::class, ['bannable' => $bannable]);
        $ban = $builder
            ->setCreatedBy($createdBy)
            ->setBannable($bannable)
            ->setComment($comment)
            ->setEndAt($endAt)
            ->build();

        $this->assertEquals(get_class($bannable), $ban->bannable_type);
        $this->assertEquals($bannable->id, $ban->bannable_id);
        $this->assertEquals($comment, $ban->comment);
        $this->assertEquals(get_class($createdBy), $ban->created_by_type);
        $this->assertEquals($createdBy->id, $ban->created_by_id);
        $this->assertEquals($endAt->format('YmdHis'), $ban->end_at->format('YmdHis'));
    }

    /**
     * @test
     */
    public function it_can_set_ban()
    {
        $bannable = factory(User::class)->create();
        $ban = factory(Ban::class)->create(['end_at' => Carbon::now()->addWeek()]);

        $createdBy = factory(User::class)->create();
        $comment = Str::random();
        $builder = app(BanBuilderInterface::class, ['bannable' => $bannable]);
        $banBuilded = $builder
            ->setBan($ban)
            ->setCreatedBy($createdBy)
            ->setBannable($ban->bannable)
            ->setComment($comment)
            ->setStartAt($ban->start_at)
            ->setEndAt($ban->end_at)
            ->build();

        $this->assertEquals($ban->id, $banBuilded->id);
        $this->assertEquals($comment, $banBuilded->comment);
        $this->assertEquals(get_class($createdBy), $banBuilded->created_by_type);
        $this->assertEquals($createdBy->id, $banBuilded->created_by_id);
        $this->assertEquals($ban->end_at->format('YmdHis'), $banBuilded->end_at->format('YmdHis'));
    }

    /**
     * @test
     */
    public function it_can_get_ban()
    {
        $ban = factory(Ban::class)->create();
        $builder = app(BanBuilderInterface::class, ['bannable' => $ban->bannable]);
        $builder->setBan($ban);

        $this->assertEquals($ban, $builder->getBan());
    }

    /**
     * @test
     */
    public function it_can_get_bannable()
    {
        $bannable = factory(User::class)->create();
        $builder = app(BanBuilderInterface::class, ['bannable' => $bannable]);

        $this->assertEquals($bannable, $builder->getBannable());
    }

    /**
     * @test
     */
    public function it_can_get_created_by()
    {
        $bannable = factory(User::class)->create();
        $builder = app(BanBuilderInterface::class, ['bannable' => $bannable]);

        $this->assertNull($builder->getCreatedBy());

        $createdBy = factory(User::class)->create();
        $builder->setCreatedBy($createdBy);

        $this->assertEquals($createdBy, $builder->getCreatedBy());
    }

    /**
     * @test
     */
    public function it_can_get_comment()
    {
        $bannable = factory(User::class)->create();
        $builder = app(BanBuilderInterface::class, ['bannable' => $bannable]);

        $this->assertNull($builder->getComment());

        $comment = Str::random();
        $builder->setComment($comment);

        $this->assertEquals($comment, $builder->getComment());
    }

    /**
     * @test
     */
    public function it_can_get_start_at()
    {
        $bannable = factory(User::class)->create();
        $dateTime = Carbon::now();
        $builder = app(BanBuilderInterface::class, ['bannable' => $bannable]);

        $this->assertEquals($dateTime->format('YmdHis'), $builder->getStartAt()->format('YmdHis'));
    }

    /**
     * @test
     */
    public function it_can_get_end_at()
    {
        $bannable = factory(User::class)->create();
        $builder = app(BanBuilderInterface::class, ['bannable' => $bannable]);

        $this->assertNull($builder->getEndAt());

        $endAt = Carbon::now();
        $builder->setEndAt($endAt);

        $this->assertEquals($endAt, $builder->getEndAt());
    }
}