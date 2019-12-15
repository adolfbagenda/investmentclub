<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use adolfbagenda\InvestmentClub\Saving;
use Illuminate\Support\Str;

$factory->define(Saving::class, function (Faker $faker) {
    return [
        'payment_id'=>1,
        'month'=>$faker->date($format = 'Y-m-d', $max = 'now'),
        'amount'=>'200000',
        'status'=>1
    ];
});
