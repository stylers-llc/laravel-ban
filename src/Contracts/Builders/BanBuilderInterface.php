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
     * @param BanInterface $ban
     * @return mixed
     */
    public function setBan(BanInterface $ban): BanBuilderInterface;

    /**
     * @param BannableInterface $bannable
     * @return mixed
     */
    public function setBannable(BannableInterface $bannable): BanBuilderInterface;

    /**
     * @param Model|null $createdBy
     * @return BanBuilderInterface
     */
    public function setCreatedBy(?Model $createdBy): BanBuilderInterface;

    /**
     * @param string $comment
     * @return mixed
     */
    public function setComment(?string $comment): BanBuilderInterface;

    /**
     * @param \DateTimeInterface $startAt
     * @return mixed
     */
    public function setStartAt(\DateTimeInterface $startAt): BanBuilderInterface;

    /**
     * @param \DateTimeInterface|null $endAt
     * @return BanBuilderInterface
     */
    public function setEndAt(?\DateTimeInterface $endAt): BanBuilderInterface;

    /**
     * @return BanInterface
     */
    public function getBan(): BanInterface;

    /**
     * @return BannableInterface
     */
    public function getBannable(): BannableInterface;

    /**
     * @return Model|null
     */
    public function getCreatedBy(): ?Model;

    /**
     * @return null|string
     */
    public function getComment(): ?string;

    /**
     * @return \DateTimeInterface|null
     */
    public function getStartAt(): ?\DateTimeInterface;

    /**
     * @return \DateTimeInterface|null
     */
    public function getEndAt(): ?\DateTimeInterface;


}