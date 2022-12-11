<?php

namespace Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Feature\Http\Controllers\AuthControllerTest;

class ScoreEvaluationControllerTest extends TestCase
{
  public function login()
  {
      $response = $this->post('/api/login',[
        'email'=> 'gulgowski.javonte@hotmail.com',
        'password' => '6BZKYGN3'
      ]);

      return $response['data']['token'];

  }

    public function test_list_score_evaluations()
    {
       //$token=new AuthControllerTest();
       //var_dump($token->login());
          $token = $this->login();
        $response = $this->get('/api/score-evaluations?=&query={"query":[{"field":"ev.id","op":"=","data":"48"}]}', ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(200);
    }


    public function test_create_scores()
    {
      $token = $this->login();
        $response = $this->post('/api/score/insertGrades',["grades"=>[["evaluation_id"=>38,"student_id"=>4,"score"=>8,"oldscore"=>9]]], ["HTTP_Authorization" =>"Bearer {$token}"]);
        $response->dump();
        $response->assertStatus(201);
    }


}
