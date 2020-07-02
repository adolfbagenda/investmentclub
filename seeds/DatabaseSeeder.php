<?php

namespace adolfbagenda\InvestmentClub\Seeds;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $this->call(Permission_Roles_UsersSeeder::class);
    }
}
