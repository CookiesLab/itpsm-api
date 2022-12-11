<?php

namespace Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Feature\Http\Controllers\AuthControllerTest;

class SectionsControllerTest extends TestCase
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
    public function test_list_sections()
    {
       //$token=new AuthControllerTest();
       //var_dump($token->login());
          $token = $this->login();
        $response = $this->get('/api/sections', ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(200);
    }


    public function test_create_sections()
    {
      $token = $this->login();
        $response = $this->post('/api/sections',["period_id"=>6,"code"=>10,"teacher_id"=>1,"curriculum_subject_id"=>2,"quota"=>1,"id"=>"6","year"=>2124,"status"=>"C","label"=>"Ciclo 10-2124","start_week"=>"1","end_week"=>"1"], ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(201);
    }



    public function test_delete_sections()
    {
      //TODO=>validar porque no permite borrar
      $token = $this->login();
        $response = $this->delete('/api/careers/14', ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(302);
    }
  public function test_list_sections_students()
  {
    //$token=new AuthControllerTest();
    //var_dump($token->login());
    $token = $this->loginStudent();
    $response = $this->get('/api/section/getsubjects/4', ["HTTP_Authorization" =>"Bearer {$token}"]);
    $response->dump();
    $response->assertStatus(200);
  }

}
