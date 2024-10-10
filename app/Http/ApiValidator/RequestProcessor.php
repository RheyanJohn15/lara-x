<?php

namespace App\Http\ApiValidator;

use App\Http\Services\v1\Authenticate;
use App\Http\ApiValidator\ApiException;
use App\Service\ActivityLogger;

class RequestProcessor
{

    /**
     * Class Request Processor
     *
     * Author: Rheyan John @github RheyanJohn15
     * Description: This class process the request after it undergoes validation
     * Date Created: October 10, 2024
     * Last Updated: October 10, 2024
     */


    private $RESPONSE;
    public function __construct($req, $context, $method, $token)
    {
        switch ($context) {
            case 'auth':
                $result = new Authenticate($method, $req);
                self::LogActivity("Authentication", $token, $result);
                break;
            default:
                throw new ApiException(ApiException::REQUEST_PROCESS_ERROR);
                break;
        }
    }

    private function parseData($data)
    {
        $data = [
            'success' => true,
            'message' => $data[1],
            'method' => $data[0],
            'data' => $data[2]
        ];

        return $data;
    }

    private function LogActivity($header, $token, $result){
        $response = $result->getResult();

        $log = new ActivityLogger($header, $response[0], $token);
        $log->save();

        $this->RESPONSE = $response;
    }

    public function getResponse()
    {
        $parseData = self::parseData($this->RESPONSE);

        return $parseData;
    }
}
