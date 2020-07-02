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
     'email'          =>'required|email|unique:members'
];
public static $image_rules = [
 'picture'  => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
];
}
