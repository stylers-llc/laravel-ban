<?php

namespace Stylers\LaravelBan\Contracts\Services;

use Illuminate\Database\Eloquent\Collection;
use Stylers\LaravelBan\Contracts\Builders\BanBuilderInterface;
use Stylers\LaravelBan\Contracts\Models\BanInterface;
use Stylers\LaravelBan\Contracts\Models\Traits\BannableInterface;

/**
 * Interface BanServiceInterface
 * @package Stylers\LaravelBan\Services
 */
interface BanServiceInterface
{
    /**
     * @param BanBuilderInterface $banBuilder
     * @return BanInterface
     */
    public function ban(BanBuilderInterface $banBuilder): BanInterface;


    /**
     * @param BannableInterface $bannnable
     * @return Collection
     */
    public function unban(BannableInterface $bannnable): Collection;
}