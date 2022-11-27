<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Feature\Http\Controllers\AuthControllerTest;

class CommentsControllerTest extends TestCase
{
  public function login()
  {
      $response = $this->post('/api/login',[
        'email'=> 'admin@itpsm.edu.sv',
        'password' => 'password'
      ]);

      return $response['data']['token'];

  }

    public function test_list_comments()
    {
       //$token=new AuthControllerTest();
       //var_dump($token->login());
          $token = $this->login();
        $response = $this->get('/api/comments/5', ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(200);
    }
  public function test_list_comments_404()
  {
    //$token=new AuthControllerTest();
    //var_dump($token->login());
    $token = $this->login();
    $response = $this->get('/api/comments/3', ["HTTP_Authorization" =>"Bearer {$token}"]);
    $response->dump();
    $response->assertStatus(404);
  }
  public function test_create_comments()
  {
    //$token=new AuthControllerTest();
    //var_dump($token->login());
    $token = $this->login();
    $response = $this->post('/api/comments',["id"=>5,"comment"=>"test","status"=>2], ["HTTP_Authorization" =>"Bearer {$token}"]);
    $response->dump();
    $response->assertStatus(201);
  }


}
