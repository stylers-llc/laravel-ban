<?php

namespace Stylers\LaravelBan\Contracts\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Stylers\LaravelBan\Contracts\Models\Traits\BannableInterface;

/**
 * Interface BanInterface
 * @package Stylers\LaravelBan\Contracts
 */
interface BanInterface
{
    /**
     * @return MorphTo
     */
    public function bannable(): MorphTo;

    /**
     * @param Builder $query
     * @return mixed
     */
    public function scopeLive(Builder $query);

    /**
     * @param Builder $query
     * @param BannableInterface $bannable
     * @return mixed
     */
    public function scopeWhereBannable(Builder $query, BannableInterface $bannable);

    /**
     * @return MorphTo
     */
    public function createdBy(): MorphTo;
}