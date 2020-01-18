<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(
    App\Models\Admin\MemberUsers::class,
    function (Faker $faker) {
        return [
            'admin_id' => rand(10000, 99999),
            'no' => 'HY.' . $faker->randomNumber(6),
            'name' => $faker->name,
            'phone' => $faker->phoneNumber,
            'level' => $faker->randomDigit,
            'balance' => rand(10000, 99999),
            'points' => rand(10000, 99999),
        ];
    });

$factory->define(
    App\Models\Admin\MemberCouponTemplate::class,
    function (Faker $faker) {
        return [
            'type' => $faker->randomElement([0, 1, 2]),
            'name' => $faker->name,
            'amount' => $faker->randomNumber(6),
            'discount' => $faker->randomNumber(2),
            'attain_amount' => $faker->randomNumber(6),
            'discount_amount' => $faker->randomNumber(4),
            'expire' => $faker->randomNumber(6),
        ];
    });
