<?php

use Faker\Generator as Faker;
use Stylers\LaravelBan\Models\Ban;
use Stylers\LaravelBan\Tests\Fixtures\Models\User;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Ban::class, function (Faker $faker) {
    $bannable = factory(User::class)->create();

    return [
        'bannable_type' => $bannable->getMorphClass(),
        'bannable_id' => $bannable->getKey(),
        'start_at' => \Carbon\Carbon::now(),
    ];
});