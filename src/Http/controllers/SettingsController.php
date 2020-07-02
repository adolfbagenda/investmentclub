<?php

namespace adolfbagenda\InvestmentClub\Http\Controllers;
use adolfbagenda\InvestmentClub\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use adolfbagenda\InvestmentClub\ToastNotification;

class SettingsController extends Controller
{

    public function __construct()
    {
        $this->middleware('web');
        $this->middleware('auth');
        $this->middleware('can:Manage IC General Settings')->only('general_settings','store_general_settings','update_general_settings');
    }

    public function general_settings()
    {

           $settings = GeneralSetting::all();
        return view('investmentclub::settings.general_settings', compact('settings'));
    }

    public function store_general_settings(Request $request)
    {
        //validation
        $validation = request()->validate(GeneralSetting::$rules);
        //saving to the database
        $setting = new GeneralSetting();
        $setting->setting_prefix = strtolower(str_replace(' ', '_', request()->input('setting_prefix')));
        $setting->setting_description = request()->input('setting_description');
        $setting->setting_value = request()->input('setting_value');
        $setting->save();
        return redirect()->route('investmentclub.general_settings')->with(ToastNotification::toast('General Settings has successfully been saved','General Settings Saving'));
    }

    public function update_general_settings( Request $request)
    {
        //validation
        //$validation = request()->validate(BookingCustomField::$rules);
        //saving to the database
        $ids = request()->input('id');
        $description = request()->input('setting_description');
        $value = request()->input('setting_value');

        foreach($ids as $index => $id )
        {
          $setting =  GeneralSetting::find($id);
          $setting->setting_description = $description[$index];
          $setting->setting_value = $value[$index];
          $setting->save();
        }

        return redirect()->route('investmentclub.general_settings')->with(ToastNotification::toast('Successfully  Updated','Setting Updating'));
    }

    //Delete Field

}
