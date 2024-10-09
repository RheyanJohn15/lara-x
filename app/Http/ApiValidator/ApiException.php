<?php
namespace App\Http\ApiValidator;
use Illuminate\Http\JsonResponse;

class ApiException  extends \Exception {
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
        ], 400);
    }

    //Exception List
    public const INVALID_CONTEXT= 'Not a valid request context check api url and see context if its valid';
    public const INVALID_METHOD = 'Not a valid request method check api url and see method if its valid';
    public const INVALID_PARAMS = 'The request body or request payload is incomplete or invalid';
    public const NOT_AUTHENTICATED = 'Cannot Access API not Authenticated';
    public const NO_DATA_FOUND = 'No data found in this api request';
    public const REQUEST_PROCESS_ERROR = 'There is something wrong with the request Processor Cannot handle Request';
    public const EMAIL_NOT_FOUND = 'Your email address is not registered in the system';
    public const PASSWORD_INCORRECT = "Password did not match to your email";

}
