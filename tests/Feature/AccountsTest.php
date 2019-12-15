<?php

namespace adolfbagenda\InvestmentClub\Tests;

use adolfbagenda\InvestmentClub\Member;
use adolfbagenda\InvestmentClub\Account;
use adolfbagenda\InvestmentClub\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountsTest extends TestCase
{
    use RefreshDatabase;

    //testing getting members list
    public function testGetAccounts()
    {
        $user = factory(User::class)->create();
        $member = factory(Member::class)->create();
        $account = factory(Account::class)->create(['member_id'=>$member->id]);
        //When user visit the members page
      $response = $this->actingAs($user)->get('/club/accounts'); // your route to get Accounts
      //$this->assertTrue(true);
      $response->assertStatus(200);
        // should be able to read the Member
        $response->assertSee($account->account_member->first_name);
    }
   // Members create form
    public function testAccountCreateForm()
  {
      $user = factory(User::class)->create();
      $response = $this->actingAs($user)->get('/club/accounts/create');
      $response->assertStatus(200);
      $response->assertSee('amount');
  }

    //testing create Members
    public function testCreateAccount()
    {
      $member = factory(Member::class)->create();
        $data = [
          'member_id'=>$member->id,
          'open_date'=>'2019-12-10',
          'amount'=>'200000',
          'fine'=>'0',
          'last_saving'=>'50000',
          'status'=>1
      ];
        $user = factory(User::class)->create();
        //When user submits member request to create endpoint
      $this->actingAs($user)->post('/club/accounts', $data); // your route to create Account
      //It gets stored in the database
      $this->assertEquals(1, Account::all()->count());
    }
    // Members edit form
     public function testAccountEditForm()
   {

       $user = factory(User::class)->create();
       $member = factory(Member::class)->create();
       $account = factory(Account::class)->create(['member_id'=>$member->id]);
       $response = $this->actingAs($user)->get('/club/accounts/'.$account->id.'/edit');
       $response->assertStatus(200);
       $response->assertSee('account');
   }

    //testing accounts Update
    public function testUpdateAccount()
    {
        $user = factory(User::class)->create();
        $member = factory(Member::class)->create();
        $account = factory(Account::class)->create(['member_id'=>$member->id]);
        $account->amount = '40000';
        $this->actingAs($user)->patch('/club/accounts/'.$account->id.'/update', $account->toArray()); // your route to update Member
        //The account should be updated in the database.
        $this->assertDatabaseHas('accounts', ['id'=> $account->id, 'amount' => '40000']);
    }

    // testing Accounts Delete
    public function testDeleteAccount()
    {
        $user = factory(User::class)->create();
        $member = factory(Member::class)->create();
        $account = factory(Account::class)->create(['member_id'=>$member->id]);
        $this->actingAs($user)->delete('/club/accounts/'.$account->id.'/delete'); // your route to delete Account
        //The member should be deleted from the database.
        $this->assertDatabaseMissing('accounts', ['id'=> $account->id]);
    }
}
