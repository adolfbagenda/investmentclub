<?php

namespace adolfbagenda\InvestmentClub;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $guarded = [];
    // validation
    public static $rules = [
    'setting_prefix' => 'required|unique:general_settings',
    'setting_description'   => 'required',
  ];
}
