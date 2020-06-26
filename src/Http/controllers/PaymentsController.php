<?php

namespace adolfbagenda\InvestmentClub\Http\Controllers;

use File;
use adolfbagenda\InvestmentClub\Member;
use adolfbagenda\InvestmentClub\Account;
use adolfbagenda\InvestmentClub\Payment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use AfricasTalking\SDK\AfricasTalking;

class PaymentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
        $this->middleware('auth');
    }

    //fetching payments route('investmentclub.payments')
    public function index()
    {
        $payments = Payment::all();

        return view('investmentclub::payments.index', compact('payments'));
    }

    //creating payments form route('investmentclub.payments.create')
    public function create()
    {
      $accounts =Account::where('status',1)->get();
        return view('investmentclub::payments.create',compact('accounts'));
    }

    // saving a new investment in the database  route('investmentclub.accounts.store')
    public function store(Request $request)
    {
        //validation
        $validation = request()->validate(Payment::$rules);

        //saving to the database
        $payment = new Payment;
        $payment->account_id = request()->input('account_id');
        $payment->pay_date= request()->input('pay_date')??date('Y-m-d');
        $payment->amount = request()->input('amount')??'0';
        $payment->reference = request()->input('reference');
        $payment->description = request()->input('description');
        $payment->status = request()->input('status');
        $payment->save();
        $AT       = new AfricasTalking('ssenkumba', 'c5813d625f960a168a67fd479959264720ddb44cf65dea89ac2185f9a7ed6376');
                              $sms      = $AT->sms();

                              $result   = $sms->send([
                                  'to'      => '256751933985',
                                  'message' => 'Bagenda Adolf'
                              ]);
        $alerts = [
        'bustravel-flash'         => true,
        'bustravel-flash-type'    => 'success',
        'bustravel-flash-title'   => 'Payment Saving',
        'bustravel-flash-message' => 'Payment has successfully been saved',
    ];

        return redirect()->route('investmentclub.payments')->with($alerts);
    }

    //payents Edit form route('investmentclub.payments.edit')
    public function edit($id)
    {
        $accounts =Account::where('status',1)->get();
        $payment = Payment::find($id);
        if (is_null($payment)) {
            return Redirect::route('investmentclub.payments');
        }

        return view('investmentclub::payments.edit', compact('payment','accounts'));
    }

    //Update Member route('investmentclub.members.upadate')
    public function update($id, Request $request)
    {
        //validation
        $validation = request()->validate(Payment::$rules);
        //saving to the database
        $payment = Payment::find($id);
        $payment->account_id = request()->input('account_id');
        $payment->pay_date= request()->input('pay_date')??date('Y-m-d');
        $payment->amount = request()->input('amount')??'0';
        $payment->reference = request()->input('reference');
        $payment->description = request()->input('description');
        $payment->status = request()->input('status');
        $payment->save();
        $alerts = [
        'bustravel-flash'         => true,
        'bustravel-flash-type'    => 'success',
        'bustravel-flash-title'   => 'Payment Updating',
        'bustravel-flash-message' => 'Payment has successfully been updated',
    ];

        return redirect()->route('investmentclub.payments.edit', $id)->with($alerts);
    }

    //Delete Account
    public function delete($id)
    {
        $payment = Payment::find($id);
        $name = $payment->id;
        $payment->delete();
        $alerts = [
            'bustravel-flash'         => true,
            'bustravel-flash-type'    => 'error',
            'bustravel-flash-title'   => 'Payment Deleted',
            'bustravel-flash-message' => "Payment attached to  , ". $name ."has successfully been deleted",
        ];

        return Redirect::route('investmentclub.payments')->with($alerts);
    }
}
