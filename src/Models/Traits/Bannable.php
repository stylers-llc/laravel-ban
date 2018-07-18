<?php

namespace Stylers\LaravelBan\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Stylers\LaravelBan\Contracts\Builders\BanBuilderInterface;
use Stylers\LaravelBan\Contracts\Models\BanInterface;
use Stylers\LaravelBan\Contracts\Services\BanServiceInterface;

/**
 * Trait Bannable
 * @package Stylers\LaravelBan\Models\Traits
 */
trait Bannable
{
    /**
     * @return mixed
     */
    public function bans(): MorphMany
    {
        return $this->morphMany(app(BanInterface::class), 'bannable');
    }

    /**
     * @return bool
     */
    public function isBanned(): bool
    {
        return (bool)$this->bans()->live()->first();
    }

    /**
     * @return bool
     */
    public function isNotBanned(): bool
    {
        return !$this->isBanned();
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeBanned(Builder $query)
    {
        return $query->whereHas('bans', function ($q) {
            $q->live();
        });
    }

    /**
     * @param Builder $query
     * @return mixed
     */
    public function scopeNotBanned(Builder $query)
    {
        $bannedUserIds = $this->banned()->pluck('id')->toArray();

        return $query->whereNotIn('id', $bannedUserIds);
    }

    /**
     * @param string|null $comment
     * @param \DateTimeInterface|null $startAt
     * @param \DateTimeInterface|null $endAt
     * @return BanInterface
     */
    public function ban(
        string $comment = null,
        \DateTimeInterface $startAt = null,
        \DateTimeInterface $endAt = null
    ): BanInterface
    {
        $banService = app(BanServiceInterface::class);
        $banBuilder = app(BanBuilderInterface::class);
        $banBuilder->setBannable($this);

        if ($createdBy = auth()->user()) {
            $banBuilder->setCreatedBy($createdBy);
        }
        if ($comment) {
            $banBuilder->setComment($comment);
        }
        if ($startAt) {
            $banBuilder->setStartAt($startAt);
        }
        if ($endAt) {
            $banBuilder->setEndAt($endAt);
        }

        return $banService->ban($banBuilder);
    }

    /**
     * @return Collection|null
     */
    public function unban(): ?Collection
    {
        $banService = app(BanServiceInterface::class);

        return $banService->unban($this);
    }
}
