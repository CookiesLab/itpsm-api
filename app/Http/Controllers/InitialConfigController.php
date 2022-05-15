<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\InitialConfig\InitialConfigManager;

class InitialConfigController extends Controller
{
  /**
   * InitialConfig Manager Service
   *
   * @var App\Services\InitialConfigManager\InitialConfigManagementInterface;
   *
   */
  protected $InitialConfigManagerService;

  /**
   * responseType
   *
   * @var String
   *
   */
  protected $responseType;

  public function __construct(
    InitialConfigManager $InitialConfigManagerService
  ) {
    $this->InitialConfigManagerService = $InitialConfigManagerService;
    $this->responseType = 'initialConfigs';
  }


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function getInitialConfig()
  {
    $data = $this->InitialConfigManagerService->getInitialConfig(request()->all());

    return response()->json([
      'data' => $data,
      'jsonapi' => [
        'version' => "1.00"
      ]
    ], 200);
  }

}
