<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\v1\AutoLoadController;
use App\Models\Requests;
use Illuminate\Http\Request;
use DB;
use Twilio\Rest\Client;

class ReqFeelSafeController extends Controller
{

  public function __construct()
  {
    $this->limit = 20;
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function UpdateReq(Request $request)
  {
   
  }
}
