<?php

namespace adolfbagenda\InvestmentClub\Http\Controllers;

use File;
use adolfbagenda\InvestmentClub\Member;
use adolfbagenda\InvestmentClub\Account;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class MembersController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
        $this->middleware('auth');
    }

    //fetching members route('investmentclub.members')
    public function index()
    {
        $members = Member::all();

        return view('investmentclub::members.index', compact('members'));
    }

    //creating operator form route('bustravel.operators.create')
    public function create()
    {
        return view('investmentclub::members.create');
    }

    // saving a new operator in the database  route('bustravel.operators.store')
    public function store(Request $request)
    {
        //validation
        $validation = request()->validate(Member::$rules);
        // saving the Image image
        if($request->hasFile('picture'))
       {
             $path = public_path('members/photos');
             // creating logos folder if doesnot exit
             if(!File::isDirectory($path))
             {
                 File::makeDirectory($path, 0777, true, true);
             }
             $fname =    Str::lower(request()->input('first_name'));
             $lname =    Str::lower(request()->input('last_name'));
             $resultString = str_replace(' ', '', $fname.$lname);
             $photoname = $resultString.'_'.time().'.'.request()->picture->getClientOriginalExtension();
             request()->picture->move($path, $photoname);
       }
        //saving to the database
        $member = new Member;
        $member->first_name = request()->input('first_name');
        $member->middle_name = request()->input('middle_name');
        $member->last_name = request()->input('last_name');
        $member->gender = request()->input('gender');
        $member->national_id = request()->input('national_id');
        $member->nationality = request()->input('nationality');
        $member->date_of_birth = request()->input('date_of_birth')??NULL;
        $member->joining_date = request()->input('joining_date')??NULL;
        $member->marital_status = request()->input('marital_status');
        $member->spouse_name = request()->input('spouse_name');
        $member->spouse_phone_no = request()->input('spouse_phone_no');
        $member->father_name= request()->input('father_name');
        $member->mother_name= request()->input('mother_name');
        $member->next_of_kin = request()->input('next_of_kin');
        $member->next_of_kin_phone = request()->input('next_of_kin_phone');
        $member->next_of_kin_address = request()->input('next_of_kin_address');
        $member->next_of_kin_relationship= request()->input('next_of_kin_relationship');
        $member->code= request()->input('code');
        $member->phone_no= request()->input('phone_no');
        $member->email = request()->input('email');
        $member->city = request()->input('city');
        $member->address = request()->input('address');
        $member->picture = $photoname??NULL;
        $member->status = request()->input('status');
        $member->status_reason = request()->input('status_reason');
        $member->save();
        $account = new Account;
        $account->member_id = $member->id;
        $account->open_date = request()->input('open_date')??NULL;
        $account->amount = request()->input('amount')??'0';
        $account->fine = request()->input('fine')??'0';
        $account->last_saving = request()->input('last_saving')??'0';
        $account->status = request()->input('status');
        $account->save();
        $alerts = [
        'bustravel-flash'         => true,
        'bustravel-flash-type'    => 'success',
        'bustravel-flash-title'   => 'Member Saving',
        'bustravel-flash-message' => 'Member has successfully been saved',
    ];

        return redirect()->route('investmentclub.members')->with($alerts);
    }

    //operator Edit form route('bustravel.operators.edit')
    public function edit($id)
    {
        $member = Member::find($id);
        if (is_null($member)) {
            return Redirect::route('investmentclub.members');
        }

        return view('investmentclub::members.edit', compact('member'));
    }

    //Update Member route('investmentclub.members.upadate')
    public function update($id, Request $request)
    {
        //validation
        $validation = request()->validate(Member::$rules);
        // saving logo to Picture folder
        $photoname =request()->input('picture');
    if($request->hasFile('newpicture'))
    {
         $path = public_path('members/photos');
         // creating logos folder if doesnot exit
         if(!File::isDirectory($path))
         {
             File::makeDirectory($path, 0777, true, true);
         }
         $fname =    Str::lower(request()->input('first_name'));
         $lname =    Str::lower(request()->input('last_name'));
         $resultString = str_replace(' ', '', $fname.$lname);
         $photoname = $resultString.'_'.time().'.'.request()->newpicture->getClientOriginalExtension();
         request()->newpicture->move($path, $photoname);

    }
        //saving to the database
        $member = Member::find($id);
        $member->first_name = request()->input('first_name');
        $member->middle_name = request()->input('middle_name');
        $member->last_name = request()->input('last_name');
        $member->gender = request()->input('gender');
        $member->national_id = request()->input('national_id');
        $member->nationality = request()->input('nationality');
        $member->date_of_birth = request()->input('date_of_birth')??NULL;
        $member->joining_date = request()->input('joining_date')??NULL;
        $member->marital_status = request()->input('marital_status');
        $member->spouse_name = request()->input('spouse_name');
        $member->spouse_phone_no = request()->input('spouse_phone_no');
        $member->father_name= request()->input('father_name');
        $member->mother_name= request()->input('mother_name');
        $member->next_of_kin = request()->input('next_of_kin');
        $member->next_of_kin_phone = request()->input('next_of_kin_phone');
        $member->next_of_kin_address = request()->input('next_of_kin_address');
        $member->next_of_kin_relationship= request()->input('next_of_kin_relationship');
        $member->code= request()->input('code');
        $member->phone_no= request()->input('phone_no');
        $member->email = request()->input('email');
        $member->city = request()->input('city');
        $member->address = request()->input('address');
        $member->picture = $photoname??NULL;
        $member->status = request()->input('status');
        $member->status_reason = request()->input('status_reason');
        $member->save();
        $alerts = [
        'bustravel-flash'         => true,
        'bustravel-flash-type'    => 'success',
        'bustravel-flash-title'   => 'Member Updating',
        'bustravel-flash-message' => 'Member has successfully been updated',
    ];

        return redirect()->route('investmentclub.members.edit', $id)->with($alerts);
    }

    //Delete Operator
    public function delete($id)
    {
        $member = Member::find($id);
        $name = $member->first_name.' '. $member->last_name.' '. $member->middle_name;
        $member->delete();
        $alerts = [
            'bustravel-flash'         => true,
            'bustravel-flash-type'    => 'error',
            'bustravel-flash-title'   => 'Operator Deleted',
            'bustravel-flash-message' => "Operator , ". $name ."has successfully been deleted",
        ];

        return Redirect::route('investmentclub.members')->with($alerts);
    }
}
