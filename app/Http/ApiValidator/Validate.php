<?php
namespace App\Http\ApiValidator;
use App\Http\ApiValidator\ApiException;
use App\Http\ApiValidator\RequestProcessor;

class Validate {

    private $AUTH = false;
    private $RESPONSE;
    public function __construct($req, $context, $method, $authentication)
    {
        //Check If Context is valid
        if(!array_key_exists($context, self::API_LIST)){
            throw new ApiException(ApiException::INVALID_CONTEXT);
        }

        //Check if Method is valid
        if(!array_key_exists($method, self::API_LIST[$context])){
            throw new ApiException(ApiException::INVALID_METHOD);
        }

        //Check Request Body for valid parameters
        if(!self::CheckParam($context, $method, $req)){
            throw new ApiException(ApiException::INVALID_PARAMS);
        }

        //Check if the request is authenticated or needs authentication
        if(self::isAuthRequired($context, $method)){
            $this->AUTH = true;
        }
        $sendRequest = new RequestProcessor($req, $context, $method);
        if($this->AUTH){
            if(!self::Authenticate()){
                throw new ApiException(ApiException::NOT_AUTHENTICATED);
            }
           $this->RESPONSE = $sendRequest->getResponse();
        }else{
            $this->RESPONSE = $sendRequest->getResponse();
        }
    }


    private function CheckParam($context, $method, $req){
        $paramsList = self::API_LIST[$context][$method]['params'];
        $validity = 0;
        foreach($paramsList as $param){
           if($req->$param){
                $validity++;
           }
        }

        if($validity == count($paramsList)){
            return true;
        }

        return false;
    }

    private function isAuthRequired($context, $method){
        return self::API_LIST[$context][$method]['isAuth'];
    }

    private function Authenticate(){

    }

    public function getResponse(){
        return $this->RESPONSE;
    }

    private const API_LIST = [
        'auth' => [
            'login' => ['params'=> ['email', 'password'], 'isAuth' => false]
        ]
    ];
}
