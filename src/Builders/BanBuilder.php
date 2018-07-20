<?php

namespace Stylers\LaravelBan\Builders;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Stylers\LaravelBan\Contracts\Models\BanInterface;
use Stylers\LaravelBan\Contracts\Builders\BanBuilderInterface;
use Stylers\LaravelBan\Contracts\Builders\BuilderInterface;
use Stylers\LaravelBan\Contracts\Models\Traits\BannableInterface;

/**
 * Class BanBuilder
 * @package Stylers\LaravelBan\Builders
 */
class BanBuilder implements BanBuilderInterface
{
    /**
     * @var BanInterface
     */
    protected $ban;

    /**
     * @var BannableInterface
     */
    protected $bannable;

    /**
     * @var null|Model
     */
    protected $createdBy = null;

    /**
     * @var string|null
     */
    protected $comment = null;

    /**
     * @var DateTimeInterface
     */
    protected $startAt;

    /**
     * @var null|DateTimeInterface
     */
    protected $endAt = null;

    /**
     * BanBuilder constructor.
     * @param BannableInterface $bannable
     */
    public function __construct(BannableInterface $bannable)
    {
        $this->ban = app(BanInterface::class);
        $this->startAt = Carbon::now();
        $this->bannable = $bannable;
    }

    /**
     * @return BanInterface
     */
    public function build(): BanInterface
    {
        $this->ban->bannable()->associate($this->bannable);
        $this->ban->createdBy()->associate($this->createdBy);
        $this->ban->start_at = $this->startAt;
        $this->ban->end_at = $this->endAt;
        $this->ban->comment = $this->comment;

        return $this->ban;
    }

    /**
     * @param BanInterface $ban
     * @return BanBuilderInterface
     */
    public function setBan(BanInterface $ban): BanBuilderInterface
    {
        $this->ban = $ban;
        return $this;
    }

    /**
     * @param BannableInterface $bannable
     * @return BanBuilderInterface
     */
    public function setBannable(BannableInterface $bannable): BanBuilderInterface
    {
        $this->bannable = $bannable;
        return $this;
    }

    /**
     * @param Model|null $createdBy
     * @return BanBuilderInterface
     */
    public function setCreatedBy(?Model $createdBy): BanBuilderInterface
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * @param null|string $comment
     * @return BanBuilderInterface
     */
    public function setComment(?string $comment): BanBuilderInterface
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @param DateTimeInterface $startAt
     * @return BanBuilderInterface
     */
    public function setStartAt(DateTimeInterface $startAt): BanBuilderInterface
    {
        $this->startAt = $startAt;
        return $this;
    }

    /**
     * @param DateTimeInterface|null $endAt
     * @return BanBuilderInterface
     */
    public function setEndAt(?DateTimeInterface $endAt): BanBuilderInterface
    {
        $this->endAt = $endAt;
        return $this;
    }

    /**
     * @return BanInterface
     */
    public function getBan(): BanInterface
    {
        return $this->ban;
    }

    /**
     * @return BannableInterface
     */
    public function getBannable(): BannableInterface
    {
        return $this->bannable;
    }

    /**
     * @return Model|null
     */
    public function getCreatedBy(): ?Model
    {
        return $this->createdBy;
    }

    /**
     * @return null|string
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @return DateTimeInterface
     */
    public function getStartAt(): DateTimeInterface
    {
        return $this->startAt;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getEndAt(): ?DateTimeInterface
    {
        return $this->endAt;
    }
}
