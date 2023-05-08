<?php

namespace Tests\Feature\Http\Controllers;


use Tests\TestCase;

class EquivalenceControllerTest extends TestCase
{
  public function login()
  {
    $response = $this->post('/api/login',[
      'email'=> 'admin@itpsm.edu.sv',
      'password' => 'password'
    ]);

    return $response['data']['token'];
  }

  public function test_list_equivalence()
  {
    $token = $this->login();
    $response = $this->get('/api/equivalence', ["HTTP_Authorization" =>"Bearer {$token}"]);
    $response->dump();
    $response->assertStatus(200);
  }
  public function test_list_equivalence_byStudent_id()
  {
    $token = $this->login();
    $response = $this->get('/api/equivalence/1', ["HTTP_Authorization" =>"Bearer {$token}"]);
    $response->dump();
    $response->assertStatus(200);
  }

  public function test_create_outerequivalence()
  {
    $token = $this->login();
    $response = $this->post('/api/equivalence',["id"=>"1","score"=>"7","curriculum_subject_id"=>"1","curricula_id"=>"1","IsInnerEquivalence"=>"0", "subjectname"=>"ITSPMTEST","institution"=>"ITSPMTEST"], ["HTTP_Authorization" =>"Bearer {$token}"]);
    $response->dump();
    $response->assertStatus(201);
  }

  public function test_create_innerequivalence()
  {
    $token = $this->login();
    $response = $this->post('/api/equivalence',["id"=>"1","score"=>"7","curriculum_subject_id"=>"1","curricula_id"=>"1","IsInnerEquivalence"=>"1", "subjectname"=>"ITSPMTEST","institution"=>"ITSPMTEST"], ["HTTP_Authorization" =>"Bearer {$token}"]);
    $response->dump();
    $response->assertStatus(201);
  }



}
