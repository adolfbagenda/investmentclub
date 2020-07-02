<?php

namespace adolfbagenda\InvestmentClub\Seeds;

use adolfbagenda\InvestmentClub\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $permission1 = factory(Permission::class)->create(['name' => 'Manage IC General Settings']);
        $permission2 = factory(Permission::class)->create(['name' => 'View IC Members']);
        $permission3 = factory(Permission::class)->create(['name' => 'Create IC Members']);
        $permission4 = factory(Permission::class)->create(['name' => 'Update IC Members']);
        $permission5 = factory(Permission::class)->create(['name' => 'Delete IC Members']);
        $permission6 = factory(Permission::class)->create(['name' => 'View IC Accounts']);
        $permission7 = factory(Permission::class)->create(['name' => 'Create IC Accounts']);
        $permission8 = factory(Permission::class)->create(['name' => 'Update IC Accounts']);
        $permission9 = factory(Permission::class)->create(['name' => 'Delete IC Accounts']);
        $permission10 = factory(Permission::class)->create(['name' => 'View IC Payments']);
        $permission11 = factory(Permission::class)->create(['name' => 'Create IC Payments']);
        $permission12 = factory(Permission::class)->create(['name' => 'Update IC Payments']);
        $permission13 = factory(Permission::class)->create(['name' => 'Delete IC Payments']);
        $permission14 = factory(Permission::class)->create(['name' => 'Manage IC Payments']);
        $permission15 = factory(Permission::class)->create(['name' => 'Manage IC Permissions']);
        $permission16 = factory(Permission::class)->create(['name' => 'Manage IC Roles']);
        $permission17 = factory(Permission::class)->create(['name' => 'View IC Reports']);
        $permission18 = factory(Permission::class)->create(['name' => 'View IC  Advanced Reports']);
        $permission19 = factory(Permission::class)->create(['name' => 'View IC Users']);
        $permission20 = factory(Permission::class)->create(['name' => 'Create IC Users']);
        $permission21 = factory(Permission::class)->create(['name' => 'Update IC Users']);
        $permission22 = factory(Permission::class)->create(['name' => 'Delete IC Users']);
        $permission23 = factory(Permission::class)->create(['name' => 'Approve Payments']);
        $permission24 = factory(Permission::class)->create(['name' => 'Approve Loans']);

        $role1 = factory(Role::class)->create(['name' => 'IC Super Admin']);
        $role1->givePermissionTo([
          $permission1, $permission2, $permission3, $permission4, $permission5, $permission6,
          $permission7, $permission8, $permission9, $permission10, $permission11, $permission12,
          $permission13, $permission14, $permission15, $permission16, $permission17, $permission18,
          $permission19, $permission20, $permission21, $permission22,$permission23, $permission24
        ]);
        $role2 = factory(Role::class)->create(['name' => 'IC Administrator']);
        $role2->givePermissionTo([
          $permission2, $permission3, $permission4, $permission5, $permission6,
          $permission7, $permission8, $permission9, $permission10, $permission11, $permission12,
          $permission13, $permission14, $permission16, $permission17, $permission18,
          $permission19, $permission20, $permission21, $permission22,$permission23, $permission24
        ]);
        $role3 = factory(Role::class)->create(['name' => 'IC Treasurer']);
        $role3->givePermissionTo([
          $permission2, $permission6, $permission10, $permission11, $permission12,
          $permission13, $permission14, $permission17, $permission18,
          $permission23, $permission24
        ]);
        $role4 = factory(Role::class)->create(['name' => 'IC User']);
        $role4->givePermissionTo([
          $permission2, $permission4,
          $permission6, $permission8, $permission9, $permission10, $permission11,$permission17
        ]);
        $user = config('investmentclub.user_model', User::class)::where('email', 'admin@admin.com')->first();
        if (is_null($user)) {
          $user_class = config('investmentclub.user_model', User::class);
            $user1 = factory($user_class)->create([
            'name'        => 'IC Super Admin',
            'email'       => 'admin@admin.com',
            'password'    => Hash::make('password'), // password
            'status'=>1 ,
            'email_verified_at'=>now(),
          ]);
            $user1->syncRoles($role1->id);
        } else {
            $user->syncRoles($role1->id);
        }
    }
}
