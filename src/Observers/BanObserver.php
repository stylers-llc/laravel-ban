<?php

namespace Stylers\LaravelBan\Observers;

use Stylers\LaravelBan\Contracts\Models\BanInterface;
use Stylers\LaravelBan\Events\Banned;
use Stylers\LaravelBan\Events\Unbanned;

/**
 * Class BanObserver
 * @package Stylers\LaravelBan\Observers
 */
class BanObserver
{
    /**
     * @param BanInterface $ban
     */
    public function created(BanInterface $ban)
    {
        event(new Banned($ban->bannable, $ban));
    }

    /**
     * @param BanInterface $ban
     */
    public function deleted(BanInterface $ban)
    {
        $bannable = $ban->bannable;
        if ($bannable->bans()->count() === 0) {
            event(new Unbanned($bannable));
        }
    }
}