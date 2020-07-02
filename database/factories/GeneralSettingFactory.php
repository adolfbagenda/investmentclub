<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use adolfbagenda\InvestmentClub\GeneralSetting;
use Illuminate\Support\Str;

$factory->define(GeneralSetting::class, function (Faker $faker) {
    return [
        'setting_prefix'=>'settings',
        'setting_description'=>"Main settings",
        'setting_value'=>'0.8',
    ];
});
