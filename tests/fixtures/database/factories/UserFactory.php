<?php

use Faker\Generator as Faker;
use Stylers\LaravelBan\Tests\Fixtures\Models\User;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(User::class, function (Faker $faker) {
    return [
        'name'  => $faker->name(),
        'email' => $faker->email
    ];
});