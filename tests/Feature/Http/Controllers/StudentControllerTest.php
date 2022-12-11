<?php

namespace Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Feature\Http\Controllers\AuthControllerTest;

class StudentControllerTest extends TestCase
{
  public function login()
  {
      $response = $this->post('/api/login',[
        'email'=> 'admin@itpsm.edu.sv',
        'password' => 'password'
      ]);

      return $response['data']['token'];

  }

    public function test_list_students()
    {
       //$token=new AuthControllerTest();
       //var_dump($token->login());
          $token = $this->login();
        $response = $this->get('/api/students', ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(200);
    }
    public function test_id_students()
    {
      $token = $this->login();
        $response = $this->get('/api/students/1', ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(200);
    }

    public function test_create_students()
    {
      $token = $this->login();
        $response = $this->post('/api/students',["high_school_option"=>"Geneal","high_school_name"=>"a","is_private_high_school"=>false,"is_live_in_rural_area"=>false,"medicines"=>null,"country_id"=>"1","department_id"=>"1","municipality_id"=>"2","date_high_school_degree"=>1990,"entry_period"=>1,"entry_date"=>2022,"allergies"=>null,"diseases"=>null,"emergency_contact_phone"=>null,"emergency_contact_name"=>null,"father_phone_number"=>null,"father_name"=>null,"mother_phone_number"=>null,"mother_name"=>null,"blood_type"=>"A RH+","status"=>"A","relationship"=>"S","gender"=>"M","home_phone_number"=>"7777-7777","phone_number"=>"7777-7777","address"=>"a","birth_date"=>"2022-11-23","institutional_email"=>"PR01220012@itpsm.edu.sv","email"=>"A3@gmail.com","last_name"=>"Prueba","name"=>"Prueba","carnet"=>"PR01220012","id"=>"11","is_user_created"=>1,"municipality"=>"Apaneca","department"=>"Ahuachapán","country"=>"El Salvador","birth_date_with_format"=>"23/11/2022"], ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(201);
    }

    public function test_update_students()
    {
      $token = $this->login();
        $response = $this->put('/api/students/11',["high_school_option"=>"Geneal","high_school_name"=>"a","is_private_high_school"=>false,"is_live_in_rural_area"=>false,"medicines"=>null,"country_id"=>"1","department_id"=>"1","municipality_id"=>"2","date_high_school_degree"=>1990,"entry_period"=>1,"entry_date"=>2022,"allergies"=>null,"diseases"=>null,"emergency_contact_phone"=>null,"emergency_contact_name"=>null,"father_phone_number"=>null,"father_name"=>null,"mother_phone_number"=>null,"mother_name"=>null,"blood_type"=>"A RH+","status"=>"A","relationship"=>"S","gender"=>"M","home_phone_number"=>"7777-7777","phone_number"=>"7777-7777","address"=>"a","birth_date"=>"2022-11-23","institutional_email"=>"PR01220011@itpsm.edu.sv","email"=>"A2@gmail.com","last_name"=>"Prueba","name"=>"Prueba","carnet"=>"PR01220011","id"=>"11","is_user_created"=>1,"municipality"=>"Apaneca","department"=>"Ahuachapán","country"=>"El Salvador","birth_date_with_format"=>"23/11/2022"], ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(200);
    }


    public function test_delete_students()
    {
      //TODO=>validar porque no permite borrar
      $token = $this->login();
        $response = $this->delete('/api/students/7', ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(302);
    }


}
