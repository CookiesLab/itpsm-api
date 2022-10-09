<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login_success()
    {
        $response = $this->post('/api/login',[
          'email'=> 'admin@itpsm.edu.sv',
          'password' => 'password'
        ]);

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
