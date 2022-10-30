<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{

    public function login()
    {
        $response = $this->post('/api/login',[
          'email'=> 'admin@itpsm.edu.sv',
          'password' => 'password'
        ]);
       
        return $response['data']['token'];
       
    }
    public function test_login_success()
    {
        $response = $this->post('/api/login',[
          'email'=> 'admin@itpsm.edu.sv',
          'password' => 'password'
        ]);
        $response->dump();
        print($response['data']['token']);
        $response->assertStatus(200);
    }
  public function test_login_fail()
  {
    $response = $this->post('/api/login',[
      'email'=> 'admin@itpsm.edu.sv',
      'password' => 'pasword'
    ]);
    $response->assertStatus(401);
    //$response->assertStatus(401)->assertJsonValidationErrorFor(string $key, $responseKey = 'errors');
  }
  //TODO: validar que devuelva errores en el objeto
  public function test_login_without_data()
  {
    $response = $this->post('/api/login',[
      'email'=> 'admin@itpsm.edu.sv'
    ]);

    $response->assertStatus(302);
  }
}
