<?php

use Faker\Generator as Faker;

$factory->define(tiendaVirtual\User::class, function (Faker $faker) {
    return [
        'name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});
