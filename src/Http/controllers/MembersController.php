<?php

namespace adolfbagenda\InvestmentClub\Http\Controllers;

use File;
use adolfbagenda\InvestmentClub\Member;
use adolfbagenda\InvestmentClub\Account;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use adolfbagenda\InvestmentClub\ToastNotification;
use adolfbagenda\InvestmentClub\FileUpload;

class MembersController extends Controller
{
  public $path = 'app/public/photos',
         $thumbnails = 'app/public/photo_thumbs';
    public function __construct()
    {
        $this->middleware('web');
        $this->middleware('auth');
        $this->middleware('can:View IC Members')->only('index');
        $this->middleware('can:Update IC Members')->only('edit','update');
        $this->middleware('can:Create IC Members')->only('create','store','delete');

    }

    //fetching members route('investmentclub.members')
    public function index()
    {
      if(auth()->user()->hasAnyRole('IC User'))
        {
         $members = Member::where('user_id',auth()->user()->id)->get();
       }else{
        $members = Member::all();
       }


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
        if ($request->hasFile('picture')) {
     $image_upload =request()->picture;
     $title= request()->input('first_name').request()->input('last_name');
    $photoname=  FileUpload::upload($image_upload,$this->path,$this->thumbnails,$title);
  }
        //saving to the database
        $user_class = config('investmentclub.user_model', User::class);
            $user = new $user_class();
            $user->name= request()->input('first_name').' '.request()->input('middle_name').' '.request()->input('last_name');
            $user->email= request()->input('email');
            $user->password=bcrypt('password');
            $user->save();
            $user->syncRoles('IC User');
        $member = new Member;
        $member->user_id =$user->id;
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
        $user->status =$member->status;
        $user->save();
        $account = new Account;
        $account->member_id = $member->id;
        $account->open_date = request()->input('open_date')??date('Y-m-d');
        $account->amount = request()->input('amount')??'0';
        $account->fine = request()->input('fine')??'0';
        $account->last_saving = request()->input('last_saving')??'0';
        $account->status = request()->input('status');
        $account->save();
        return redirect()->route('investmentclub.members')->with(ToastNotification::toast($member->first_name.' '.$member->last_name.'  Detials Successfully Saved','Member Saving'));
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
        $validation = request()->validate([
          'first_name'      => 'required',
          'last_name'     => 'required',
          'email'          =>'required|email|unique:members,email,'.$id,
        ]);
        // saving logo to Picture folder
        $photoname =request()->input('picture');
        if ($request->hasFile('picture')) {
          $validation2 = request()->validate(Member::$image_rules);
           $image_upload =request()->picture;
           $title= request()->input('first_name').request()->input('last_name');
          $photoname=  FileUpload::upload($image_upload,$this->path,$this->thumbnails,$title);
        }
        //saving to the database
        $member = Member::find($id);
        $user= config('investmentclub.user_model', User::class)::find($member->user_id);
        if($user){
          $user->email=request()->input('email');
          $user->status = request()->input('status')??$member->status;
          $user->save();
          $UserId =$user->id;

        }else{
          $user_class = config('investmentclub.user_model', User::class);
              $user = new $user_class();
              $user->name= request()->input('first_name').' '.request()->input('middle_name').' '.request()->input('last_name');
              $user->email= request()->input('email');
              $user->password=bcrypt('password');
              $user->status = request()->input('status')??$member->status;
              $user->save();
              $user->syncRoles('IC User');
            $UserId =$user->id;
        }
        $member->user_id =$UserId;
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
        $member->picture = $photoname??$member->picture;
        $member->status = request()->input('status')??$member->status;
        $member->status_reason = request()->input('status_reason');
        $member->save();
        return redirect()->route('investmentclub.members.edit', $id)->with(ToastNotification::toast($member->first_name.' '.$member->last_name.'  Detials Successfully Updated','Member Updating'));
    }

    //Delete Operator
    public function delete($id)
    {
        $member = Member::find($id);
        $name = $member->first_name.' '. $member->last_name.' '. $member->middle_name;
        $member->delete();

        return Redirect::route('investmentclub.members')->with(ToastNotification::toast($name.'  ,has successfully been deleted','Member Deleting','error'));
    }
}
