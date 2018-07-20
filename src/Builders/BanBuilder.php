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
class BanBuilder implements BuilderInterface, BanBuilderInterface
{

    /**
     * @var BanInterface
     */
    private $ban;

    /**
     * @var BannableInterface
     */
    private $bannable;

    /**
     * @var null|Model
     */
    private $createdBy = null;

    /**
     * @var string|null
     */
    private $comment = null;

    /**
     * @var DateTimeInterface
     */
    private $startAt;

    /**
     * @var null|DateTimeInterface
     */
    private $endAt = null;

    /**
     * BanBuilder constructor.
     */
    public function __construct()
    {
        $this->ban = app(BanInterface::class);
    }

    /**
     * @return BanInterface
     */
    public function build(): BanInterface
    {
        $this->ban->bannable()->associate($this->bannable);
        $this->ban->createdBy()->associate($this->createdBy);
        $this->ban->start_at = $this->startAt ?: Carbon::now();
        $this->ban->end_at = $this->endAt;
        $this->ban->comment = $this->comment;

        return $this->ban;
    }

    /**
     * @param BanInterface $ban
     * @return BanBuilder
     */
    public function setBan(BanInterface $ban): BanBuilderInterface
    {
        $this->ban = $ban;
        return $this;
    }

    /**
     * @param BannableInterface $bannable
     * @return BanBuilder
     */
    public function setBannable(BannableInterface $bannable): BanBuilderInterface
    {
        $this->bannable = $bannable;
        return $this;
    }

    /**
     * @param Model|null $createdBy
     * @return BanBuilder
     */
    public function setCreatedBy(?Model $createdBy): BanBuilderInterface
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * @param null|string $comment
     * @return BanBuilder
     */
    public function setComment(?string $comment): BanBuilderInterface
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @param DateTimeInterface $startAt
     * @return BanBuilder
     */
    public function setStartAt(DateTimeInterface $startAt): BanBuilderInterface
    {
        $this->startAt = $startAt;
        return $this;
    }

    /**
     * @param DateTimeInterface|null $endAt
     * @return BanBuilder
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
     * @return DateTimeInterface|null
     */
    public function getStartAt(): ?DateTimeInterface
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
