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
    App\Models\Admin\CouponTemplateModel::class,
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


$factory->define(
    App\Models\Admin\ArModel::class,
    function (Faker $faker) {
        return [
            'type' => $faker->randomElement([0, 1, 2]),
            'url' => "http://127.0.0.1:8000",
            'data' => json_encode([
                'type' => $faker->randomElement([0, 1, 2]),
                'name' => $faker->name,
                'amount' => $faker->randomNumber(6),
                'discount' => $faker->randomNumber(2),
                'attain_amount' => $faker->randomNumber(6),
                'discount_amount' => $faker->randomNumber(4),
                'expire' => $faker->randomNumber(6),
            ]),
            'method' => $faker->randomElement(["GET", "POST"]),
            'time_periods' => json_encode([
                '2020-01-18 12:00:00', '2020-01-19 12:00:00', '2020-01-20 12:00:00', '2020-01-21 12:00:00', '2020-01-22 12:00:00', '2020-01-23 12:00:00', '2020-01-24 12:00:00',
            ]),
        ];
    });
