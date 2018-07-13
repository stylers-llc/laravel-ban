<?php

namespace Stylers\LaravelBan\Exceptions;

use Exception;

/**
 * Class UserIsBannedException
 * @package Stylers\LaravelBan\Exceptions
 */
class UserIsBannedException extends Exception
{
    /**
     * @var string
     */
    protected $message = 'User is banned.';
}