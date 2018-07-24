<?php

namespace Stylers\LaravelBan\Services;

use Illuminate\Database\Eloquent\Collection;
use Stylers\LaravelBan\Contracts\Builders\BanBuilderInterface;
use Stylers\LaravelBan\Contracts\Models\BanInterface;
use Stylers\LaravelBan\Contracts\Models\Traits\BannableInterface;
use Stylers\LaravelBan\Contracts\Services\BanServiceInterface;

/**
 * Class BanService
 * @package Stylers\LaravelBan\Services
 */
class BanService implements BanServiceInterface
{
    /**
     * @param BanBuilderInterface $banBuilder
     * @return BanInterface
     */
    public function ban(BanBuilderInterface $banBuilder): BanInterface
    {
        $ban = $banBuilder->build();
        $ban->save();

        return $ban;
    }

    /**
     * @param BannableInterface $bannable
     * @return Collection
     */
    public function unban(BannableInterface $bannable): Collection
    {
        return $bannable->bans()->live()->get()->each(function ($ban) {
            $ban->delete();
        });
    }
}