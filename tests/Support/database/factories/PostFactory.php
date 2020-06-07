<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Jdexx\EloquentRansack\Tests\Support\Models\Post;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name,
        'date' => $faker->date(),
        'published' => $faker->randomElement([true, false, null]),
    ];
});
