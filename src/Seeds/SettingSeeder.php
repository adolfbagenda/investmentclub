<?php

namespace adolfbagenda\InvestmentClub\Seeds;

use adolfbagenda\InvestmentClub\GeneralSetting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $setting1 = factory(GeneralSetting::class)->create([
          'setting_prefix' => 'africastalking_username',
           'setting_description' => 'AfricasTalking username',
           'setting_value' => 'justdoit'
        ]);
        $setting2 = factory(GeneralSetting::class)->create([
          'setting_prefix' => 'africastalking_key',
           'setting_description' => 'AfricasTalking Public Key',
           'setting_value' => 'justdoit'
        ]);
        $setting3 = factory(GeneralSetting::class)->create([
          'setting_prefix' => 'main_currency',
           'setting_description' => 'Currency',
           'setting_value' => 'Ugx'
        ]);
        $setting4 = factory(GeneralSetting::class)->create([
          'setting_prefix' => 'monthly_fee',
           'setting_description' => 'Monthly Fee',
           'setting_value' => '100000'
        ]);
        $setting5 = factory(GeneralSetting::class)->create([
          'setting_prefix' => 'penalities',
           'setting_description' => 'penalities',
           'setting_value' => '0.5'
        ]);
        $setting6 = factory(GeneralSetting::class)->create([
          'setting_prefix' => 'penalities_enabled',
           'setting_description' => 'Penalities Enabled',
           'setting_value' => '0'
        ]);
        $setting7 = factory(GeneralSetting::class)->create([
          'setting_prefix' => 'company_name',
           'setting_description' => 'Company Name',
           'setting_value' => 'Title'
        ]);

    }
}
