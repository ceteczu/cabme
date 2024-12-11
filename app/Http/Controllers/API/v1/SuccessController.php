<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\v1\GcmController;
use Illuminate\Http\Request;
use DB;
class SuccessController extends Controller
{
    public function __construct()
    {
       $this->limit=20;   
    }
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
   $response['msg']="Payment completed successfully"; 
   return response()->json($response);
  
}