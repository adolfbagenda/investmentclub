<?php

namespace adolfbagenda\InvestmentClub;

use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    //
    protected $guarded = [];
    public static $rules = [
     'payment_id'      => 'required',
     'amount'      => 'required',
];

public function payment_no()
  {
      return $this->belongsTo(Payment::class,'payment_id');
  }
}
