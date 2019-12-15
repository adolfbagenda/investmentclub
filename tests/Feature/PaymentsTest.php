<?php

namespace adolfbagenda\InvestmentClub\Tests;

use adolfbagenda\InvestmentClub\Member;
use adolfbagenda\InvestmentClub\Account;
use adolfbagenda\InvestmentClub\Payment;
use adolfbagenda\InvestmentClub\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentsTest extends TestCase
{
    use RefreshDatabase;

    //testing getting payments list
    public function testGetPayments()
    {
        $user = factory(User::class)->create();
        $member = factory(Member::class)->create();
        $account = factory(Account::class)->create(['member_id'=>$member->id]);
        $payments = factory(Payment::class)->create(['account_id'=>$account->id]);
        //When user visit the payments page
      $response = $this->actingAs($user)->get('/club/payments'); // your route to get Payments
      //$this->assertTrue(true);
      $response->assertStatus(200);
        // should be able to read the Payment
        $response->assertSee($payments->account_no->account_member->first_name);
    }
   // Members create form
    public function testPaymentCreateForm()
  {
      $user = factory(User::class)->create();
      $response = $this->actingAs($user)->get('/club/payments/create');
      $response->assertStatus(200);
      $response->assertSee('amount');
  }

    //testing create Members
    public function testCreatePayment()
    {
      $member = factory(Member::class)->create();
      $account = factory(Account::class)->create(['member_id'=>$member->id]);
        $data = [
          'account_id'=>$account->id,
          'pay_date'=>'2019-12-15',
          'amount'=>'200000',
          'reference'=>'Cent Bank',
          'description'=>'Centenary',
          'status'=>1
      ];
        $user = factory(User::class)->create();
        //When user submits payments request to create endpoint
      $this->actingAs($user)->post('/club/payments', $data); // your route to create Payments
      //It gets stored in the database
      $this->assertEquals(1, Payment::all()->count());
    }
    // Members edit form
     public function testPaymentEditForm()
   {

       $user = factory(User::class)->create();
       $member = factory(Member::class)->create();
       $account = factory(Account::class)->create(['member_id'=>$member->id]);
       $payment = factory(Payment::class)->create(['account_id'=>$account->id]);
       $response = $this->actingAs($user)->get('/club/payments/'.$payment->id.'/edit');
       $response->assertStatus(200);
       $response->assertSee('amount');
   }

    //testing accounts Update
    public function testUpdatePayment()
    {
        $user = factory(User::class)->create();
        $member = factory(Member::class)->create();
        $account = factory(Account::class)->create(['member_id'=>$member->id]);
        $payment = factory(Payment::class)->create(['account_id'=>$account->id]);
        $payment->amount = '400000';
        $this->actingAs($user)->patch('/club/payments/'.$payment->id.'/update', $payment->toArray()); // your route to update Payment
        //The payment should be updated in the database.
        $this->assertDatabaseHas('payments', ['id'=> $payment->id, 'amount' => '400000']);
    }

    // testing Payments Delete
    public function testDeletePayment()
    {
        $user = factory(User::class)->create();
        $member = factory(Member::class)->create();
        $account = factory(Account::class)->create(['member_id'=>$member->id]);
        $payment = factory(Payment::class)->create(['account_id'=>$account->id]);
        $this->actingAs($user)->delete('/club/payments/'.$payment->id.'/delete'); // your route to delete Account
        //The member should be deleted from the database.
        $this->assertDatabaseMissing('payments', ['id'=> $account->id]);
    }
}
