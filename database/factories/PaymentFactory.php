<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use adolfbagenda\InvestmentClub\Payment;
use Illuminate\Support\Str;

$factory->define(Payment::class, function (Faker $faker) {
    return [
        'account_id'=>1,
        'pay_date'=>$faker->date($format = 'Y-m-d', $max = 'now'),
        'amount'=>'200000',
        'reference'=>'',
        'description'=>$faker->text,
        'status'=>1
    ];
});
