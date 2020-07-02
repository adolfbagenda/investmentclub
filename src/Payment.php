<?php

namespace adolfbagenda\InvestmentClub;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $guarded = [];
    public static $rules = [
     'account_id'      => 'required',
     'amount'      => 'required',
];

public function account_no()
  {
      return $this->belongsTo(Account::class,'account_id');
  }
  public function payment_savings()
  {
      return $this->hasMany(Saving::class, 'payment_id');
  }
}
