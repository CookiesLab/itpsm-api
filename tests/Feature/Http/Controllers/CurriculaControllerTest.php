<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Feature\Http\Controllers\AuthControllerTest;

class CurriculaControllerTest extends TestCase
{
  public function login()
  {
      $response = $this->post('/api/login',[
        'email'=> 'admin@itpsm.edu.sv',
        'password' => 'password'
      ]);
     
      return $response['data']['token'];
     
  }
   
    public function test_list_curricula()
    {
       //$token=new AuthControllerTest();
       //var_dump($token->login());
          $token = $this->login();
        $response = $this->get('/api/curricula', ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(200);
    }
    public function test_id_curricula()
    {
      $token = $this->login();
        $response = $this->get('/api/curricula/1', ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(200);
    }
    public function test_bad_id_curricula()
    {
      $token = $this->login();
        $response = $this->get('/api/careers/100', ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(404);
    }
    public function test_create_curricula()
    {
      $token = $this->login();
        $response = $this->post('/api/curricula',["name"=>"prueba de creacion","year"=>"2021","is_active"=>"1","is_approved"=>"0","career_id"=>"1"], ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(201);
    }  
    public function test_create_without_info_curricula()
    {
      //TODO:validar porque pide redireccion
      $token = $this->login();
        $response = $this->post('/api/curricula',[], ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(302);
    }  
    public function test_update_curricula ()
    {
      $token = $this->login();
        $response = $this->put('/api/curricula/3',["name"=>"prueba de actualizacion","year"=>"2000","is_active"=>"1","is_approved"=>"0","career_id"=>"1"], ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        //TODO:validar si es correcto que devuelva 200
        $response->assertStatus(200);
    }
    public function test_update_bad_id_career()
    {
      $token = $this->login();
        $response = $this->put('/api/curricula/300',["name"=>"prueba de actualizacion","year"=>"2000","is_active"=>"1","is_approved"=>"0","career_id"=>"1"], ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(404);
    }
    public function test_update_without_info_career()
    {
      $token = $this->login();
        $response = $this->put('/api/curricula/4',[], ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(302);
    }
    public function test_delete_career()
    {
      //TODO:validar porque no permite borrar
      $token = $this->login();
        $response = $this->delete('/api/curricula/3', ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(201);
    }
  
  
}
