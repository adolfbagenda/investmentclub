<?php

namespace adolfbagenda\InvestmentClub;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //
    protected $guarded = [];
    public static $rules = [
     'first_name'      => 'required',
     'last_name'     => 'required',
];
}
