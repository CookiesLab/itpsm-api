<?php

namespace Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Feature\Http\Controllers\AuthControllerTest;

class StudentCurriculaControllerTest extends TestCase
{
  public function login()
  {
      $response = $this->post('/api/login',[
        'email'=> 'admin@itpsm.edu.sv',
        'password' => 'password'
      ]);

      return $response['data']['token'];

  }

    public function test_list_students_curricula()
    {
       //$token=new AuthControllerTest();
       //var_dump($token->login());
          $token = $this->login();
        $response = $this->get('/api/student-curricula?=&query={"query":[{"field":"st.id","op":"=","data":"4"}]}', ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(200);
    }

    public function test_create_student_curricula()
    {
      $token = $this->login();
        $response = $this->post('/api/student-curricula',["cum"=>8.4,"entry_year"=>2022,"graduation_year"=>2025,"scholarship_rate"=>0,"student_id"=>5,"curriculum_id"=>1,"scholarship_id"=>1], ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(201);
    }


}
