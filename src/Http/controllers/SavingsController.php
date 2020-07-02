<?php

namespace adolfbagenda\InvestmentClub\Http\Controllers;

use File;
use adolfbagenda\InvestmentClub\Member;
use adolfbagenda\InvestmentClub\Account;
use adolfbagenda\InvestmentClub\Saving;
use adolfbagenda\InvestmentClub\Payment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class SavingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
        $this->middleware('auth');
    }

    //fetching accounts route('investmentclub.accounts')
    public function index()
    {

       if(auth()->user()->hasAnyRole('IC User'))
         {
          $members = Member::where('user_id',auth()->user()->id)->first();
          $accounts = Account::where('member_id',$members->id)->pluck('id');
          $payments_ids = Payment::whereIn('account_id',$accounts)->pluck('id');
          $savings = Saving::whereIn('payment_id',$payments_ids)->orderBy('id','Desc')->get();
        }else{
          $payments =Payment::all();
          $savings = Saving::all();
        }


        return view('investmentclub::payments.savings', compact('savings','payments'));
    }

    // saving a new investment in the database  route('investmentclub.accounts.store')
    public function store(Request $request)
    {
        //validation
        $validation = request()->validate(Saving::$rules);

        //saving to the database
        $saving = new Saving;
        $saving->payment_id = request()->input('payment_id');
        $saving->month= request()->input('month')??NULL;
        $saving->amount = request()->input('amount')??'0';
        $saving->status = request()->input('status');
        $saving->save();
        $alerts = [
        'bustravel-flash'         => true,
        'bustravel-flash-type'    => 'success',
        'bustravel-flash-title'   => 'Account Saving',
        'bustravel-flash-message' => 'Account has successfully been saved',
    ];

        return redirect()->route('investmentclub.savings')->with($alerts);
    }


    //Update Member route('investmentclub.members.upadate')
    public function update($id, Request $request)
    {
        //validation
        $validation = request()->validate(Saving::$rules);
        //saving to the database
        $saving = Saving::find($id);
        $saving->payment_id = request()->input('payment_id');
        $saving->month= request()->input('month')??NULL;
        $saving->amount = request()->input('amount')??'0';
        $saving->status = request()->input('status');
        $saving->save();
        $alerts = [
        'bustravel-flash'         => true,
        'bustravel-flash-type'    => 'success',
        'bustravel-flash-title'   => 'Account Updating',
        'bustravel-flash-message' => 'Account has successfully been updated',
    ];

        return redirect()->route('investmentclub.savings')->with($alerts);
    }

    //Delete Account
    public function delete($id)
    {
        $saving = Saving::find($id);
        $name = $saving->id;
        $saving->delete();
        $alerts = [
            'bustravel-flash'         => true,
            'bustravel-flash-type'    => 'error',
            'bustravel-flash-title'   => 'Account Deleted',
            'bustravel-flash-message' => "Account attached to  , ". $name ."has successfully been deleted",
        ];

        return Redirect::route('investmentclub.savings')->with($alerts);
    }
}
