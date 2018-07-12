<?php

namespace Stylers\LaravelBan\Tests\Fixtures\Models;

use Stylers\LaravelBan\Contracts\Models\Traits\BannableInterface;
use Stylers\LaravelBan\Models\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Stylers\LaravelBan\Models\Traits\Bannable;

/**
 * Class User
 * @package Stylers\LaravelBan\Tests\Fixtures\Models
 */
class User extends Authenticatable implements BannableInterface
{
    use Bannable;
}
