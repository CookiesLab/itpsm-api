<?php

namespace Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Feature\Http\Controllers\AuthControllerTest;

class EvaluationsControllerTest extends TestCase
{
  public function login()
  {
      $response = $this->post('/api/login',[
        'email'=> 'gulgowski.javonte@hotmail.com',
        'password' => '6BZKYGN3'
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

    public function test_get_evaluations()
    {
       //$token=new AuthControllerTest();
       //var_dump($token->login());
          $token = $this->login();
        $response = $this->get('/api/evaluations?=&query={"query":[{"field":"s.id","op":"=","data":"11"}]}', ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(200);
    }
  public function test_create_evaluations()
  {
    //$token=new AuthControllerTest();
    //var_dump($token->login());
    $token = $this->login();
    $response = $this->post('/api/evaluations',["name"=>"a","description"=>"a","date"=>"2022-12-08","percentage"=>1,"section_id"=>11,"principal_id"=>null], ["HTTP_Authorization" =>"Bearer {$token}"]);
    $response->dump();
    $response->assertStatus(201);
  }
  public function test_delete_evaluations()
  {
    //$token=new AuthControllerTest();
    //var_dump($token->login());
    $token = $this->login();
    $response = $this->delete('/api/evaluations/48',["HTTP_Authorization" =>"Bearer {$token}"]);
    $response->dump();
    $response->assertStatus(302);
  }
  public function test_approval_request()
  {
    //$token=new AuthControllerTest();
    //var_dump($token->login());
    $token = $this->login();
    $response = $this->put('/api/requestAprobacion/11',["HTTP_Authorization" =>"Bearer {$token}"]);
    $response->dump();
    $response->assertStatus(302);
  }
  public function test_publish_evaluations()
  {
    //$token=new AuthControllerTest();
    //var_dump($token->login());
    $token = $this->login();
    $response = $this->put('/api/evaluations/publish/11',["HTTP_Authorization" =>"Bearer {$token}"]);
    $response->dump();
    $response->assertStatus(302);
  }
  public function test_publish_grades()
  {
    //$token=new AuthControllerTest();
    //var_dump($token->login());
    $token = $this->login();
    $response = $this->put('/api/evaluations/publishgrades/38',["HTTP_Authorization" =>"Bearer {$token}"]);
    $response->dump();
    $response->assertStatus(302);
  }
  public function test_grades_student()
  {
    //$token=new AuthControllerTest();
    //var_dump($token->login());
    $token = $this->loginStudent();
    $response = $this->get('/api/evaluations/student/4',["HTTP_Authorization" =>"Bearer {$token}"]);
    $response->dump();
    $response->assertStatus(200);
  }
}
