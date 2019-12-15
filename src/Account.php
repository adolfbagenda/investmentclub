<?php

namespace adolfbagenda\InvestmentClub;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    //
    protected $guarded = [];
    public static $rules = [
     'member_id'      => 'required',
];

public function account_member()
  {
      return $this->belongsTo(Member::class,'member_id');
  }
}
