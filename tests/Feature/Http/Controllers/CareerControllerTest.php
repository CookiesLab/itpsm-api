<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Feature\Http\Controllers\AuthControllerTest;

class CareerControllerTest extends TestCase
{
  public function login()
  {
      $response = $this->post('/api/login',[
        'email'=> 'admin@itpsm.edu.sv',
        'password' => 'password'
      ]);
     
      return $response['data']['token'];
     
  }
   
    public function test_list_career()
    {
       //$token=new AuthControllerTest();
       //var_dump($token->login());
          $token = $this->login();
        $response = $this->get('/api/careers', ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(200);
    }
    public function test_id_career()
    {
      $token = $this->login();
        $response = $this->get('/api/careers/1', ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(200);
    }
    public function test_bad_id_career()
    {
      $token = $this->login();
        $response = $this->get('/api/careers/100', ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(404);
    }
    public function test_create_career()
    {
      $token = $this->login();
        $response = $this->post('/api/careers',["name"=>"prueba de creacion"], ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(201);
    }  
    public function test_create_without_info_career()
    {
      //TODO:validar porque pide redireccion
      $token = $this->login();
        $response = $this->post('/api/careers',[], ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(302);
    }  
    public function test_update_career()
    {
      $token = $this->login();
        $response = $this->put('/api/careers/3',["name"=>"prueba de actualizacion"], ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(201);
    }
    public function test_update_bad_id_career()
    {
      $token = $this->login();
        $response = $this->put('/api/careers/300',["name"=>"prueba de actualizacion"], ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(404);
    }
    public function test_update_without_info_career()
    {
      $token = $this->login();
        $response = $this->put('/api/careers/4',[], ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(302);
    }
    public function test_delete_career()
    {
      //TODO:validar porque no permite borrar
      $token = $this->login();
        $response = $this->delete('/api/careers/5', ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(201);
    }
  
  
}
