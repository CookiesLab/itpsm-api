<?php

namespace Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Feature\Http\Controllers\AuthControllerTest;

class ScholarshipsControllerTest extends TestCase
{
  public function login()
  {
      $response = $this->post('/api/login',[
        'email'=> 'admin@itpsm.edu.sv',
        'password' => 'password'
      ]);

      return $response['data']['token'];

  }

    public function test_list_scholarships()
    {
       //$token=new AuthControllerTest();
       //var_dump($token->login());
          $token = $this->login();
        $response = $this->get('/api/scholarships', ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(200);
    }
    public function test_id_scholarships()
    {
      $token = $this->login();
        $response = $this->get('/api/scholarships/1', ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(200);
    }

    public function test_create_scholarships()
    {
      $token = $this->login();
        $response = $this->post('/api/scholarships',["id"=>15,"name"=>"prueba","scholarship_foundation"=>"323"], ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(201);
    }

    public function test_update_scholarships()
    {
      $token = $this->login();
        $response = $this->put('/api/scholarships/4',["id"=>15,"name"=>"prueba","scholarship_foundation"=>"adgrd"], ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(200);
    }


    public function test_delete_scholarships()
    {
      //TODO:validar porque no permite borrar
      $token = $this->login();
        $response = $this->delete('/api/scholarships/4', ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(302);
    }


}
