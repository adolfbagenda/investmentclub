<?php

namespace adolfbagenda\InvestmentClub\Tests;

use adolfbagenda\InvestmentClub\Member;
use adolfbagenda\InvestmentClub\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MembersTest extends TestCase
{
    use RefreshDatabase;

    //testing getting members list
    public function testGetMembers()
    {
        $user = factory(User::class)->create();
        $member = factory(Member::class)->create();
        //When user visit the members page
      $response = $this->actingAs($user)->get('/club/members'); // your route to get Members
      //$this->assertTrue(true);
      $response->assertStatus(200);
        // should be able to read the Member
        $response->assertSee($member->first_name);
    }
   // Members create form
    public function testMemeberCreateForm()
  {
      $user = factory(User::class)->create();
      $response = $this->actingAs($user)->get('/club/members/create');
      $response->assertStatus(200);
      $response->assertSee('first_name');
  }

    //testing create Members
    public function testCreateMember()
    {
      $this->withoutExceptionHandling();
        $data = [
        'first_name'=>'Festo',
        'middle_name'=>'Aisha',
        'last_name'=>'Kembaba',
        'gender'=>'1',
        'national_id'=>'',
        'nationality'=>'Uganda',
        'date_of_birth'=>'1967-12-12',
        'joining_date'=>'2019-12-12',
        'marital_status'=>'1',
        'spouse_name'=>'',
        'spouse_phone_no'=>'',
        'father_name'=>'',
        'mother_name'=>'',
        'next_of_kin'=>'',
        'next_of_kin_phone'=>'',
        'next_of_kin_address'=>'',
        'next_of_kin_relationship'=>'',
        'code'=>'+256',
        'phone_no'=>'',
        'email'=>'',
        'city'=>'',
        'address'=>'',
        'picture'=>'',
        'status'=>1,
        'status_reason'=>''

      ];
        $user = factory(User::class)->create();
        //When user submits member request to create endpoint
      $this->actingAs($user)->post('/club/members', $data); // your route to create member
      //It gets stored in the database
      $this->assertEquals(1, Member::all()->count());
    }
    // Members edit form
     public function testMemeberEditForm()
   {
     
       $user = factory(User::class)->create();
       $member = factory(Member::class)->create();
       $response = $this->actingAs($user)->get('/club/members/'.$member->id.'/edit');
       $response->assertStatus(200);
       $response->assertSee('first_name');
   }

    //testing members Update
    public function testUpdateMember()
    {
        $user = factory(User::class)->create();
        $member = factory(Member::class)->create();
        $member->first_name = 'Mbabazi';
        $this->actingAs($user)->patch('/club/members/'.$member->id.'/update', $member->toArray()); // your route to update Member
        //The member should be updated in the database.
        $this->assertDatabaseHas('members', ['id'=> $member->id, 'first_name' => 'Mbabazi']);
    }

    // testing Members Delete
    public function testDeleteMember()
    {
        $user = factory(User::class)->create();
        $member = factory(Member::class)->create();
        $this->actingAs($user)->delete('/club/members/'.$member->id.'/delete'); // your route to delete Member
        //The member should be deleted from the database.
        $this->assertDatabaseMissing('members', ['id'=> $member->id]);
    }
}
