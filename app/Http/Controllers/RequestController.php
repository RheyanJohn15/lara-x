<?php

namespace App\Http\Controllers;
use App\Http\ApiValidator\Validate;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function GetRequestApi(Request $req, $context, $method){
        $validate = new Validate($req, $context, $method);

        return response()->json($validate->getResponse());
    }

    public function PostRequestApi(Request $req, $context, $method){
        $validate = new Validate($req, $context, $method);

        return response()->json($validate->getResponse());
    }
}
