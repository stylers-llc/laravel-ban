<?php

namespace Stylers\LaravelBan\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Stylers\LaravelBan\Contracts\Models\BanInterface;
use Stylers\LaravelBan\Contracts\Models\Traits\BannableInterface;

/**
 * Class Banned
 * @package Stylers\LaravelBan\Events
 */
class Banned
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var BannableInterface
     */
    public $bannable;

    /**
     * @var BanInterface
     */
    public $ban;

    /**
     * Banned constructor.
     * @param BannableInterface $bannable
     * @param BanInterface $ban
     */
    public function __construct(BannableInterface $bannable, BanInterface $ban)
    {
        $this->bannable = $bannable;
        $this->ban = $ban;
    }
}
