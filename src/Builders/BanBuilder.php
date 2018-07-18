<?php

namespace Stylers\LaravelBan\Builders;

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
     * @var Model
     */
    private $createdBy = null;

    /**
     * @var string
     */
    private $comment = null;

    /**
     * @var \DateTimeInterface
     */
    private $startAt;

    /**
     * @var \DateTimeInterface
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
        $this->ban->end_at = $this->endAt;
        $this->ban->comment = $this->comment;

        if ($this->startAt) {
            $this->ban->start_at = $this->startAt;
        }
        if ($this->createdBy) {
            $this->ban->createdBy()->associate($this->createdBy);
        }

        $this->ban->save();

        return $this->ban;
    }

    /**
     * @return BanInterface
     */
    public function getBan(): BanInterface
    {
        return $this->ban;
    }

    /**
     * @param BanInterface $ban
     */
    public function setBan(BanInterface $ban): void
    {
        $this->ban = $ban;
    }

    /**
     * @param BannableInterface $bannable
     */
    public function setBannable(BannableInterface $bannable): void
    {
        $this->bannable = $bannable;
    }

    /**
     * @param Model $createdBy
     */
    public function setCreatedBy(Model $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @param string $comment
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @param \DateTimeInterface $startAt
     */
    public function setStartAt(\DateTimeInterface $startAt): void
    {
        $this->startAt = $startAt;
    }

    /**
     * @param \DateTimeInterface $endAt
     */
    public function setEndAt(\DateTimeInterface $endAt): void
    {
        $this->endAt = $endAt;
    }
}