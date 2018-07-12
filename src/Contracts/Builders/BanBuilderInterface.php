<?php

namespace Stylers\LaravelBan\Contracts\Builders;

use Illuminate\Database\Eloquent\Model;
use Stylers\LaravelBan\Contracts\Models\BanInterface;
use Stylers\LaravelBan\Contracts\Models\Traits\BannableInterface;

/**
 * Interface BanBuilderInterface
 * @package Stylers\LaravelBan\Contracts\Builders
 */
interface BanBuilderInterface
{
    /**
     * @return BanInterface
     */
    public function build(): BanInterface;

    /**
     * @return BanInterface
     */
    public function getBan(): BanInterface;

    /**
     * @param BanInterface $ban
     * @return mixed
     */
    public function setBan(BanInterface $ban);

    /**
     * @param BannableInterface $bannable
     * @return mixed
     */
    public function setBannable(BannableInterface $bannable);

    /**
     * @param Model $createdBy
     * @return mixed
     */
    public function setCreatedBy(Model $createdBy);

    /**
     * @param string $comment
     * @return mixed
     */
    public function setComment(string $comment);

    /**
     * @param \DateTimeInterface $expiredAt
     * @return mixed
     */
    public function setExpiredAt(\DateTimeInterface $expiredAt);
}