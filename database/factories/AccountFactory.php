<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use adolfbagenda\InvestmentClub\Account;
use Illuminate\Support\Str;

$factory->define(Account::class, function (Faker $faker) {
    return [
        'member_id'=>1,
        'open_date'=>$faker->date($format = 'Y-m-d', $max = 'now'),
        'amount'=>'200000',
        'fine'=>'0',
        'last_saving'=>'50000',
        'status'=>1
    ];
});
