<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Feature\Http\Controllers\AuthControllerTest;

class CurriculaSubjectControllerTest extends TestCase
{
  public function login()
  {
      $response = $this->post('/api/login',[
        'email'=> 'admin@itpsm.edu.sv',
        'password' => 'password'
      ]);

      return $response['data']['token'];

  }

    public function test_list_curricula_subject()
    {
       //$token=new AuthControllerTest();
       //var_dump($token->login());
          $token = $this->login();
        $response = $this->get('/api/curriculum-subjects?=&query={"query":[{"field":"curriculum_id","op":"=","data":"1"}]}', ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(200);
    }

  public function test_list_curricula_subject_404()
  {
    //$token=new AuthControllerTest();
    //var_dump($token->login());
    $token = $this->login();
    $response = $this->get('/api/curriculum-subjects?=&query={"query":[{"field":"curriculum_id","op":"=","data":"1000"}]}', ["HTTP_Authorization" =>"Bearer {$token}"]);
    $response->dump();
    $json= $response->getOriginalContent();
    var_dump($json['data']==[]);
    if($json['data']==[]){
      $response->assertOk();
    }

  }
  public function test_create_curricula_subject_invalid_curriculum()
  {
    //$token=new AuthControllerTest();
    //var_dump($token->login());
    $token = $this->login();
    $response = $this->post('/api/curriculum-subjects',['uv'=>10,'curriculum_id'=>3,'subject_id'=>10,'cycle'=>1], ["HTTP_Authorization" =>"Bearer {$token}"]);
    $response->dump();

    //$response->assertStatus(201);
    $response->assertHeader('Content-Type', 'text/html; charset=UTF-8');

  }
  public function test_create_curricula_subject()
  {
    //$token=new AuthControllerTest();
    //var_dump($token->login());
    $token = $this->login();
    $response = $this->post('/api/curriculum-subjects',['uv'=>10,'curriculum_id'=>4,'subject_id'=>10,'cycle'=>1], ["HTTP_Authorization" =>"Bearer {$token}"]);
    $response->dump();

    $response->assertStatus(201);


  }
  public function test_DELETE_curricula_subject()
  {
    //$token=new AuthControllerTest();
    //var_dump($token->login());
    $token = $this->login();
    $response = $this->delete('/api/curriculum-subjects/47', ["HTTP_Authorization" =>"Bearer {$token}"]);
    $response->dump();

    $response->assertStatus(201);


  }
}
