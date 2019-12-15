<?php

namespace adolfbagenda\InvestmentClub\Http\Controllers;

use File;
use adolfbagenda\InvestmentClub\Member;
use adolfbagenda\InvestmentClub\Account;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class AccountsController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
        $this->middleware('auth');
    }

    //fetching accounts route('investmentclub.accounts')
    public function index()
    {
        $accounts = Account::all();

        return view('investmentclub::accounts.index', compact('accounts'));
    }

    //creating operator form route('bustravel.operators.create')
    public function create()
    {
      $members =Member::where('status',1)->get();
        return view('investmentclub::accounts.create',compact('members'));
    }

    // saving a new investment in the database  route('investmentclub.accounts.store')
    public function store(Request $request)
    {
        //validation
        $validation = request()->validate(Account::$rules);

        //saving to the database
        $account = new Account;
        $account->member_id = request()->input('member_id');
        $account->open_date = request()->input('open_date')??NULL;
        $account->amount = request()->input('amount')??'0';
        $account->fine = request()->input('fine')??'0';
        $account->last_saving = request()->input('last_saving')??'0';
        $account->status = request()->input('status');
        $account->save();
        $alerts = [
        'bustravel-flash'         => true,
        'bustravel-flash-type'    => 'success',
        'bustravel-flash-title'   => 'Account Saving',
        'bustravel-flash-message' => 'Account has successfully been saved',
    ];

        return redirect()->route('investmentclub.accounts')->with($alerts);
    }

    //operator Edit form route('bustravel.operators.edit')
    public function edit($id)
    {
        $members =Member::where('status',1)->get();
        $account = Account::find($id);
        if (is_null($account)) {
            return Redirect::route('investmentclub.accounts');
        }

        return view('investmentclub::accounts.edit', compact('account','members'));
    }

    //Update Member route('investmentclub.members.upadate')
    public function update($id, Request $request)
    {
        //validation
        $validation = request()->validate(Account::$rules);
        //saving to the database
        $account = Account::find($id);
        $account->member_id = request()->input('member_id');
        $account->open_date = request()->input('open_date')??NULL;
        $account->amount = request()->input('amount');
        $account->fine = request()->input('fine');
        $account->status = request()->input('status');
        $account->save();
        $alerts = [
        'bustravel-flash'         => true,
        'bustravel-flash-type'    => 'success',
        'bustravel-flash-title'   => 'Account Updating',
        'bustravel-flash-message' => 'Account has successfully been updated',
    ];

        return redirect()->route('investmentclub.accounts.edit', $id)->with($alerts);
    }

    //Delete Account
    public function delete($id)
    {
        $account = Account::find($id);
        $name = $account->account_member->first_name.' '. $account->account_member->last_name.' '. $account->account_member->middle_name;
        $account->delete();
        $alerts = [
            'bustravel-flash'         => true,
            'bustravel-flash-type'    => 'error',
            'bustravel-flash-title'   => 'Account Deleted',
            'bustravel-flash-message' => "Account attached to  , ". $name ."has successfully been deleted",
        ];

        return Redirect::route('investmentclub.accounts')->with($alerts);
    }
}
