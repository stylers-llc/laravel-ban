<?php

namespace Stylers\LaravelBan\Contracts\Builders;

/**
 * Interface BuilderInterface
 * @package Stylers\LaravelBan\Contracts\Builders
 */
interface BuilderInterface
{
    /**
     * BuilderInterface constructor.
     */
    public function __construct();

    /**
     * @return mixed
     */
    public function build();
}