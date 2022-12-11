<?php

namespace Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Feature\Http\Controllers\AuthControllerTest;

class PeriodControllerTest extends TestCase
{
  public function login()
  {
      $response = $this->post('/api/login',[
        'email'=> 'admin@itpsm.edu.sv',
        'password' => 'password'
      ]);

      return $response['data']['token'];

  }

    public function test_list_periods()
    {
       //$token=new AuthControllerTest();
       //var_dump($token->login());
          $token = $this->login();
        $response = $this->get('/api/periods', ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(200);
    }
    public function test_id_periods()
    {
      $token = $this->login();
        $response = $this->get('/api/periods/1', ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(200);
    }

    public function test_create_periods()
    {
      $token = $this->login();
        $response = $this->post('/api/periods',["code"=>10,"year"=>2124,"status"=>"C"], ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(201);
    }

    public function test_update_periods()
    {
      $token = $this->login();
        $response = $this->put('/api/careers/1',["status"=>"C"], ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(302);
    }


    public function test_delete_periods()
    {
      //TODO:validar porque no permite borrar
      $token = $this->login();
        $response = $this->delete('/api/careers/10', ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(302);
    }


}
