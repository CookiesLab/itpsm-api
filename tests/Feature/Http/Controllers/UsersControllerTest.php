<?php

namespace Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Feature\Http\Controllers\AuthControllerTest;

class UsersControllerTest extends TestCase
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
    public function test_list_users()
    {
       //$token=new AuthControllerTest();
       //var_dump($token->login());
          $token = $this->login();
        $response = $this->get('/api/users', ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(200);
    }


    public function test_create_users()
    {
      $token = $this->login();
        $response = $this->post('/api/users',["name"=>"prueba","email"=>"pr@pr.com","password"=>"aasf"], ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(201);
    }

  public function test_update_users()
  {
    $token = $this->login();
    $response = $this->put('/api/users/59',["name"=>"prueba2","email"=>"pr@pr.com","password"=>"aasf"], ["HTTP_Authorization" =>"Bearer {$token}"]);
    $response->dump();
    $response->assertStatus(200);
  }



}
