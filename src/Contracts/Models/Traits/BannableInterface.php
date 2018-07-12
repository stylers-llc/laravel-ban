<?php

namespace Stylers\LaravelBan\Contracts\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Stylers\LaravelBan\Contracts\Models\BanInterface;

/**
 * Interface BannableInterface
 * @package Stylers\LaravelBan\Contracts\Traits
 */
interface BannableInterface
{
    /**
     * @return mixed
     */
    public function bans(): MorphMany;

    /**
     * @return bool
     */
    public function isBanned(): bool;

    /**
     * @return bool
     */
    public function isNotBanned(): bool;

    /**
     * @param Builder $query
     * @return mixed
     */
    public function scopeBanned(Builder $query);

    /**
     * @param Builder $query
     * @return mixed
     */
    public function scopeNotBanned(Builder $query);

    /**
     * @param string|null $comment
     * @param \DateTimeInterface|null $expiredAt
     * @return BanInterface
     */
    public function ban(string $comment = null, \DateTimeInterface $expiredAt = null): BanInterface;

    /**
     * @return Collection|null
     */
    public function unban(): ?Collection;
}