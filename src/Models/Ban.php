<?php

namespace Stylers\LaravelBan\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stylers\LaravelBan\Contracts\Models\BanInterface;
use Stylers\LaravelBan\Contracts\Models\Traits\BannableInterface;

/**
 * Class Ban
 * @package Stylers\LaravelBan\Models
 */
class Ban extends Model implements BanInterface
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comment',
        'expired_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'expired_at' => 'datetime',
    ];

    /**
     * @return MorphTo
     */
    public function bannable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return MorphTo
     */
    public function createdBy(): MorphTo
    {
        return $this->morphTo('created_by');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeLive(Builder $query)
    {
        $dateTime = Carbon::now();

        return $query->where('expired_at', '>=', $dateTime)->orWhereNull('expired_at');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeNotLive(Builder $query)
    {
        $dateTime = Carbon::now();

        return $query->where('expired_at', '<', $dateTime)->whereNotNull('expired_at');
    }

    /**
     * @param Builder $query
     * @param BannableInterface $bannable
     * @return Builder
     */
    public function scopeWhereBannable(Builder $query, BannableInterface $bannable)
    {
        return $query->where([
            'bannable_id' => $bannable->getKey(),
            'bannable_type' => $bannable->getMorphClass(),
        ]);
    }
}