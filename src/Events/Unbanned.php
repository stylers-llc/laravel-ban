<?php

namespace Stylers\LaravelBan\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Stylers\LaravelBan\Contracts\Models\Traits\BannableInterface;

/**
 * Class Unbanned
 * @package Stylers\LaravelBan\Events
 */
class Unbanned
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var BannableInterface
     */
    public $bannable;

    /**
     * Create a new event instance.
     *
     * @param BannableInterface $bannable
     */
    public function __construct(BannableInterface $bannable)
    {
        $this->bannable = $bannable;
    }
}
