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
    private $expiredAt = null;

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
        $this->ban->expired_at = $this->expiredAt;
        $this->ban->comment = $this->comment;

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
     * @param \DateTimeInterface $expiredAt
     */
    public function setExpiredAt(\DateTimeInterface $expiredAt): void
    {
        $this->expiredAt = $expiredAt;
    }
}