<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

class AcademicHistoryControllerTest extends  TestCase
{
  public function login()
  {
    $response = $this->post('/api/login',[
      'email'=> 'admin@itpsm.edu.sv',
      'password' => 'password'
    ]);

    return $response['data']['token'];
  }

  public function test_list_academicHistory()
  {
    $token = $this->login();
    $response = $this->get('/api/academichistory', ["HTTP_Authorization" =>"Bearer {$token}"]);
    $response->dump();
    $response->assertStatus(200);
  }
  public function test_list_academichistory_byStudent_id()
  {
    $token = $this->login();
    $response = $this->get('/api/academichistory/1', ["HTTP_Authorization" =>"Bearer {$token}"]);
    $response->dump();
    $response->assertStatus(200);
  }

  public function test_create_outerequivalence()
  {
    $token = $this->login();
    $response = $this->post('/api/academichistory',["student_id"=>"1","subject_id"=>"7","curriculum_id"=>"1","curricula_id"=>"1","totalScore"=>"0", "isEquivalence"=>"7","year"=>"2022", "period"=>"2"], ["HTTP_Authorization" =>"Bearer {$token}"]);
    $response->dump();
    $response->assertStatus(201);
  }




}
