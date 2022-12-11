<?php

namespace Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Feature\Http\Controllers\AuthControllerTest;

class SubjectsControllerTest extends TestCase
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
    public function test_list_subjects()
    {
       //$token=new AuthControllerTest();
       //var_dump($token->login());
          $token = $this->login();
        $response = $this->get('/api/subjects', ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(200);
    }


    public function test_create_subjects()
    {
      $token = $this->login();
        $response = $this->post('/api/subjects',["name"=>"prueba","code"=>"101010"], ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(201);
    }



    public function test_delete_subjects()
    {
      //TODO=>validar porque no permite borrar
      $token = $this->login();
        $response = $this->delete('/api/subjects/46', ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(302);
    }
  public function test_list_subjects_id()
  {
    //$token=new AuthControllerTest();
    //var_dump($token->login());
    $token = $this->login();
    $response = $this->get('/api/subjects/46', ["HTTP_Authorization" =>"Bearer {$token}"]);
    $response->dump();
    $response->assertStatus(200);
  }

}
