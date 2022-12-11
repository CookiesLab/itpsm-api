<?php

namespace Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Feature\Http\Controllers\AuthControllerTest;

class TeachersControllerTest extends TestCase
{
  public function login()
  {
      $response = $this->post('/api/login',[
        'email'=> 'admin@itpsm.edu.sv',
        'password' => 'password'
      ]);

      return $response['data']['token'];

  }
  public function loginStudent()
  {
    $response = $this->post('/api/login',[
      'email'=> 'PR01220011@itpsm.edu.sv',
      'password' => 'NW5YYADK'
    ]);

    return $response['data']['token'];

  }
  public function loginTeacher()
  {
    $response = $this->post('/api/login',[
      'email'=> 'gulgowski.javonte@hotmail.com',
      'password' => '6BZKYGN3'
    ]);

    return $response['data']['token'];

  }
    public function test_list_teachers()
    {
       //$token=new AuthControllerTest();
       //var_dump($token->login());
          $token = $this->login();
        $response = $this->get('/api/teachers', ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(200);
    }
  public function test_list_all_teachers()
  {
    //$token=new AuthControllerTest();
    //var_dump($token->login());
    $token = $this->login();
    $response = $this->get('/api/teachers/all', ["HTTP_Authorization" =>"Bearer {$token}"]);
    $response->dump();
    $response->assertStatus(200);
  }
  public function test_list_teachers_sections()
  {
    //$token=new AuthControllerTest();
    //var_dump($token->login());
    $token = $this->loginTeacher();
    $response = $this->get('/api/teachers/sections',["id"=>1], ["HTTP_Authorization" =>"Bearer {$token}"]);
    $response->dump();
    $response->assertStatus(302);
  }
  public function test_list_teachers_users()
  {
    //$token=new AuthControllerTest();
    //var_dump($token->login());
    $token = $this->login();
    $response = $this->post('/api/teachers/generate-system-users', ["HTTP_Authorization" =>"Bearer {$token}"]);
    $response->dump();
    $response->assertStatus(302);
  }
  public function test_delete_teachers()
  {
    //$token=new AuthControllerTest();
    //var_dump($token->login());
    $token = $this->login();
    $response = $this->delete('/api/teachers/10', ["HTTP_Authorization" =>"Bearer {$token}"]);
    $response->dump();
    $response->assertStatus(302);
  }
  public function test_info_teachers()
  {
    //$token=new AuthControllerTest();
    //var_dump($token->login());
    $token = $this->login();
    $response = $this->get('/api/teachers/10', ["HTTP_Authorization" =>"Bearer {$token}"]);
    $response->dump();
    $response->assertStatus(200);
  }
    public function test_create_teachers()
    {
      $token = $this->login();
        $response = $this->post('/api/teachers',["entry_date"=>2022,"name"=>"prueba","last_name"=>"prueba","birth_date"=>"2022-12-11","nit"=>"15155115","dui"=>"1010101","isss_number"=>"48184","nup_number"=>"101515","email"=>"prueba@prueba.com","genre"=>"F","address"=>"rueba","phone_number"=>"77777777","home_phone_number"=>"22222222","municipality_id"=>1,"department_id"=>1,"country_id"=>1,"status"=>1], ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(201);
    }

  public function test_update_teachers()
  {
    $token = $this->login();
    $response = $this->put('/api/teachers/11',["entry_date"=>2023,"name"=>"prueba","last_name"=>"prueba","birth_date"=>"2022-12-11","nit"=>"15155115","dui"=>"1010101","isss_number"=>"48184","nup_number"=>"101515","email"=>"prueba@prueba.com","genre"=>"F","address"=>"rueba","phone_number"=>"77777777","home_phone_number"=>"22222222","municipality_id"=>1,"department_id"=>1,"country_id"=>1,"status"=>1], ["HTTP_Authorization" =>"Bearer {$token}"]);
    $response->dump();
    $response->assertStatus(200);
  }



}
