<?php

namespace App\Http\ApiValidator;

use App\Http\ApiValidator\ApiException;
use App\Http\ApiValidator\RequestProcessor;
use Illuminate\Support\Facades\Auth;
use App\Models\PersonalAccessToken;

class Validate
{

    /**
     * Class Validate
     *
     * Author: Rheyan John @github RheyanJohn15
     * Description: This class validates an api request from its context to method to its request parameters and authentication
     * Date Created: October 10, 2024
     * Last Updated: October 10, 2024
     */

    private $AUTH = false;
    private $RESPONSE;

    public function __construct($req, $context, $method)
    {
        //Check If Context is valid
        if (!array_key_exists($context, self::API_LIST)) {
            throw new ApiException(ApiException::INVALID_CONTEXT);
        }

        //Check if Method is valid
        if (!array_key_exists($method, self::API_LIST[$context])) {
            throw new ApiException(ApiException::INVALID_METHOD);
        }

        //Check Request Body for valid parameters
        if (!self::CheckParam($context, $method, $req)) {
            throw new ApiException(ApiException::INVALID_PARAMS);
        }

        //Check if the request is authenticated or needs authentication
        if (self::isAuthRequired($context, $method)) {
            $this->AUTH = true;
        }

        //Check If the request is authenticated
        if ($this->AUTH) {
            $sendRequest = new RequestProcessor($req, $context, $method);
            if (!self::Authenticate()) {
                throw new ApiException(ApiException::NOT_AUTHENTICATED);
            }
            $this->RESPONSE = $sendRequest->getResponse();
        } else {
            $sendRequest = new RequestProcessor($req, $context, $method);
            $this->RESPONSE = $sendRequest->getResponse();
        }
    }


    private function CheckParam($context, $method, $req)
    {
        $paramsList = self::API_LIST[$context][$method]['params'];

        if($paramsList[0] == 'empty'){
            return true;
        }

        $validity = 0;
        foreach ($paramsList as $param) {
            if ($req->$param) {
                $validity++;
            }
        }

        if ($validity == count($paramsList)) {
            return true;
        }

        return false;
    }

    private function isAuthRequired($context, $method)
    {
        return self::API_LIST[$context][$method]['isAuth'];
    }

    private function Authenticate()
    {
        return Auth::check();
    }

    public function getResponse()
    {
        return $this->RESPONSE;
    }

    //List of Valid API's
    private const API_LIST = [
        'auth' => [
            'login' => ['params' => ['email', 'password'], 'isAuth' => false],
            'checkauth'=> ['params' => ['empty'], 'isAuth'=> false]
        ],
        'projects' => [
            'add' => ['params'=> ['name', 'description'], 'isAuth'=> true],
            'list' => ['params'=> ['empty'], 'isAuth'=> true],
            'delete' => ['params'=> ['id'], 'isAuth'=> true],
            'info' => ['params'=> ['id'], 'isAuth'=> true],
            'uploadlogo'=> ['params'=> ['id', 'file'], 'isAuth'=> true],
            'update'=> ['params'=> ['id', 'name', 'description'], 'isAuth'=> true],
        ]
    ];
}
