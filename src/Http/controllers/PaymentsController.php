<?php

namespace adolfbagenda\InvestmentClub\Http\Controllers;

use File;
use adolfbagenda\InvestmentClub\Member;
use adolfbagenda\InvestmentClub\GeneralSetting;
use adolfbagenda\InvestmentClub\MonthsList;
use adolfbagenda\InvestmentClub\Account;
use adolfbagenda\InvestmentClub\Payment;
use adolfbagenda\InvestmentClub\Saving;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use AfricasTalking\SDK\AfricasTalking;
use adolfbagenda\InvestmentClub\ToastNotification;

class PaymentsController extends Controller
{

    public function __construct()
    {
        $this->middleware('web');
        $this->middleware('auth');
        $this->middleware('can:View IC Payments')->only('index');
        $this->middleware('can:Delete IC Payments')->only('edit','update','create','store','delete');

    }

    //fetching payments route('investmentclub.payments')
    public function index()
    {
      if(auth()->user()->hasAnyRole('IC User'))
        {
         $members = Member::where('user_id',auth()->user()->id)->first();
         $accounts = Account::where('member_id',$members->id)->pluck('id');
         $payments = Payment::whereIn('account_id',$accounts)->orderBy('id','Desc')->get();
       }else{
        $payments = Payment::orderBy('id','Desc')->get();
       }

        return view('investmentclub::payments.index', compact('payments'));
    }

    //creating payments form route('investmentclub.payments.create')
    public function create()
    {
      $months = MonthsList::months();
      $monthly_saving = GeneralSetting::where('setting_prefix','monthly_fee')->first()->setting_value ?? '100000';

      $accounts =Account::where('status',1)->get();
        return view('investmentclub::payments.create',compact('accounts','months','monthly_saving'));
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
        $payment->amount = str_replace(',', '', request()->input('amount'))??'0';
        $payment->reference = request()->input('reference');
        $payment->description = request()->input('description');
        $payment->status = request()->input('status');
        $payment->save();

        $savings = request()->input('saving_amount') ?? 0;
        if ($savings != 0){
        $saving_month= request()->input('saving_month');
        $saving_year= request()->input('saving_year');
        foreach($savings as$index => $saving_amount){
          $saving = new Saving;
          $saving->payment_id = $payment->id;
          $saving->month= $saving_month[$index];
          $saving->amount = str_replace(',', '', $saving_amount)??'0';
          $saving->year= $saving_year[$index];
          $saving->status = request()->input('status');
          $saving->save();
        }
        }
        if(request()->input('status')==1){
          $account =Account::find($payment->account_id);
          $account->amount = $account->amount + str_replace(',', '', request()->input('amount'));
          $account->save();
          $payment->approved=1;
          $payment->save();
          $africas_talking_username = GeneralSetting::where('setting_prefix','africastalking_username')->first()->setting_value ?? 'username';
          $africas_talking_apikey = GeneralSetting::where('setting_prefix','africastalking_key')->first()->setting_value ?? 'apikey';

          $AT       = new AfricasTalking($africas_talking_username, $africas_talking_apikey);
                      $sms      = $AT->sms();
                      $result   = $sms->send([
                          'to'      => $account->account_member->code.$account->account_member->phone_no,
                          'message' => 'Just Do IT Club: Dear '.$account->account_member->first_name.' '.$account->account_member->last_name.' Your Payment '. str_replace(',', '', request()->input('amount')).'UGX has been recieved , Thank You'
                      ]);

        }
        return redirect()->route('investmentclub.payments')->with(ToastNotification::toast($account->account_member->first_name.' '.$account->account_member->last_name.' Payment has successfully been saved','Payments Saving'));
    }

    //payents Edit form route('investmentclub.payments.edit')
    public function edit($id)
    {
        $months = MonthsList::months();
        $monthly_saving = GeneralSetting::where('setting_prefix','monthly_fee')->first()->setting_value ?? '100000';
        $accounts =Account::where('status',1)->get();
        $payment = Payment::find($id);
        if (is_null($payment)) {
            return Redirect::route('investmentclub.payments');
        }

        return view('investmentclub::payments.edit', compact('payment','accounts','months','monthly_saving'));
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
        $payment->amount = str_replace(',', '', request()->input('amount'))??'0';
        $payment->reference = request()->input('reference');
        $payment->description = request()->input('description');
        $payment->status = request()->input('status');
        $payment->save();
        $monthly_savings_ids =$payment->payment_savings()->pluck('id')->all();
        $monthly_savings =$payment->payment_savings()->get();
        $savings = request()->input('saving_amount') ?? 0;
        if ($savings != 0){
        $saving_month= request()->input('saving_month');
        $saving_year= request()->input('saving_year');
        $saving_id= request()->input('saving_id');
        //deleting an Item
        foreach($monthly_savings as $monthly_saving_item){
          if(!in_array($monthly_saving_item->id, $saving_id)){
           Saving::find($monthly_saving_item->id)->delete();
          }
        }
        //Updating and CReating new item
        foreach($savings as$index => $saving_amount){
          if(in_array($saving_id[$index], $monthly_savings_ids??[])){
            $saving =  Saving::find($saving_id[$index]);
            $saving->amount = str_replace(',', '', $saving_amount)??'0';
            $saving->year= $saving_year[$index];
            $saving->status = request()->input('status');
            $saving->save();
          }else{
            $saving = new Saving;
            $saving->payment_id = $payment->id;
            $saving->month= $saving_month[$index];
            $saving->amount = str_replace(',', '', $saving_amount)??'0';
            $saving->year= $saving_year[$index];
            $saving->status = request()->input('status');
            $saving->save();
          }

        }
        }
        if(request()->input('status')==1 && $payment->approved==0){
          $account =Account::find($payment->account_id);
          $account->amount = $account->amount + str_replace(',', '', request()->input('amount'));
          $account->save();
          $payment->approved=1;
          $payment->save();
          $africas_talking_username1 = GeneralSetting::where('setting_prefix','africastalking_username')->first()->setting_value ?? 'username';
          $africas_talking_apikey1 = GeneralSetting::where('setting_prefix','africastalking_key')->first()->setting_value ?? 'apikey';

          $AT       = new AfricasTalking($africas_talking_username1, $africas_talking_apikey1);
                      $sms      = $AT->sms();
                      $result   = $sms->send([
                          'to'      => $account->account_member->code.$account->account_member->phone_no,
                          'message' => 'Just Do IT Club: Dear '.$account->account_member->first_name.' '.$account->account_member->last_name.' Your Payment '. str_replace(',', '', request()->input('amount')).'UGX has been recieved , Thank You'
                      ]);

        }

        return redirect()->route('investmentclub.payments.edit', $id)->with(ToastNotification::toast('Payment has successfully been updated','Payments Updated'));
    }

    //Delete Account
    public function delete($id)
    {
        $payment = Payment::find($id);
        $name = $payment->id;
        if($payment->status==1)
        {
          $account =Account::find($payment->account_id);
          $account->amount =$account->amount - $payment->amount;
          $account->save();
        }
        $payment->payment_savings()->delete();
        $payment->delete();

        return Redirect::route('investmentclub.payments')->with(ToastNotification::toast('Payment attached to  , '. $name .' has successfully been deleted','Payments Deleted'));
    }
}
