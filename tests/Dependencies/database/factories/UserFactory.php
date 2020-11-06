<?php


/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use EasyPanelTest\Dependencies\User;

$factory->define(User::class, function (Faker $faker, $parameters) {
    return [
        'name' => $faker->unique()->name(),
        'password' => $parameters['password'] ?? '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
        'is_superuser' => $parameters['password'] ?? false,
    ];
});