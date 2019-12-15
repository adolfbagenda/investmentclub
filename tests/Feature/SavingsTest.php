<?php

namespace adolfbagenda\InvestmentClub\Tests;

use adolfbagenda\InvestmentClub\Member;
use adolfbagenda\InvestmentClub\Account;
use adolfbagenda\InvestmentClub\Payment;
use adolfbagenda\InvestmentClub\Saving;
use adolfbagenda\InvestmentClub\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SavingsTest extends TestCase
{
    use RefreshDatabase;

    //testing getting payments list
    public function testGetSavings()
    {
        $user = factory(User::class)->create();
        $member = factory(Member::class)->create();
        $account = factory(Account::class)->create(['member_id'=>$member->id]);
        $payment = factory(Payment::class)->create(['account_id'=>$account->id]);
        $savings = factory(Saving::class)->create(['payment_id'=>$payment->id]);
        //When user visit the payments page
      $response = $this->actingAs($user)->get('/club/savings'); // your route to get Payments
      //$this->assertTrue(true);
      $response->assertStatus(200);
        // should be able to read the Payment
        $response->assertSee($savings->amount);
    }
    //testing create Members
    public function testCreateSaving()
    {
      $member = factory(Member::class)->create();
      $account = factory(Account::class)->create(['member_id'=>$member->id]);
      $payment = factory(Payment::class)->create(['account_id'=>$account->id]);
        $data = [
          'payment_id'=>$payment->id,
          'month'=>'2019-12-15',
          'amount'=>'200000',
          'status'=>1
      ];
        $user = factory(User::class)->create();
        //When user submits payments request to create endpoint
      $this->actingAs($user)->post('/club/savings', $data); // your route to create Payments
      //It gets stored in the database
      $this->assertEquals(1, Saving::all()->count());
    }

    //testing accounts Update
    public function testUpdateSaving()
    {
        $user = factory(User::class)->create();
        $member = factory(Member::class)->create();
        $account = factory(Account::class)->create(['member_id'=>$member->id]);
        $payment = factory(Payment::class)->create(['account_id'=>$account->id]);
        $saving = factory(Saving::class)->create(['payment_id'=>$payment->id]);
        $saving->amount = '400000';
        $this->actingAs($user)->patch('/club/savings/'.$saving->id.'/update', $saving->toArray()); // your route to update Payment
        //The payment should be updated in the database.
        $this->assertDatabaseHas('savings', ['id'=> $saving->id, 'amount' => '400000']);
    }

    // testing Payments Delete
    public function testDeleteSaving()
    {
        $user = factory(User::class)->create();
        $member = factory(Member::class)->create();
        $account = factory(Account::class)->create(['member_id'=>$member->id]);
        $payment = factory(Payment::class)->create(['account_id'=>$account->id]);
        $saving = factory(Saving::class)->create(['payment_id'=>$payment->id]);
        $this->actingAs($user)->delete('/club/savings/'.$saving->id.'/delete'); // your route to delete Account
        //The member should be deleted from the database.
        $this->assertDatabaseMissing('savings', ['id'=> $saving->id]);
    }
}
