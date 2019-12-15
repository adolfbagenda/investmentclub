<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use adolfbagenda\InvestmentClub\Member;
use Illuminate\Support\Str;

$factory->define(Member::class, function (Faker $faker) {
    return [
        'first_name'=>$faker->name,
        'middle_name'=>$faker->name,
        'last_name'=>$faker->name,
        'gender'=>'1',
        'national_id'=>'',
        'nationality'=>'Uganda',
        'date_of_birth'=>'1967-12-12',
        'joining_date'=>'2019-12-12',
        'marital_status'=>'1',
        'spouse_name'=>'',
        'spouse_phone_no'=>'',
        'father_name'=>'',
        'mother_name'=>'',
        'next_of_kin'=>'',
        'next_of_kin_phone'=>'',
        'next_of_kin_address'=>'',
        'next_of_kin_relationship'=>'',
        'code'=>'+256',
        'phone_no'=>'',
        'email'=>'',
        'city'=>'',
        'address'=>'',
        'picture'=>'',
        'status'=>1,
        'status_reason'=>''
    ];
});
