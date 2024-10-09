<?php
namespace App\Http\ApiValidator;
use App\Http\Services\v1\Authenticate;
use App\Http\ApiValidator\ApiException;

class RequestProcessor {
    private $RESPONSE;
    public function __construct($req, $context, $method)
    {
        switch($context){
            case 'auth':
                $result = new Authenticate($method, $req);
                $this->RESPONSE = $result->getResult();
                break;
            default:
                throw new ApiException(ApiException::REQUEST_PROCESS_ERROR);
                break;
        }
    }

    private function parseData($data){
        $data = [
            'success' => true,
            'message' => $data[1],
            'method'=> $data[0],
            'data'=> $data[2]
        ];

        return $data;
    }

    public function getResponse(){
       $parseData = self::parseData($this->RESPONSE);

       return $parseData;
    }
}
