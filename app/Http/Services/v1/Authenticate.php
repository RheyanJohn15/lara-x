<?php
namespace App\Http\Services\v1;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\ApiValidator\ApiException;

class Authenticate
{
    /**
     * Class Validate
     *
     * Author: Rheyan John @github RheyanJohn15
     * Description: Authentication class for all users, handles all authentication logics
     * Date Created: October 10, 2024
     * Last Updated: October 10, 2024
     */

    private $RESPONSE;

    public function __construct($method, $req)
    {
        $this->$method($req);
    }

    private function login($req)
    {
        $credentials = $req->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $userExists = User::where('email', $req->email)->exists();

        if (!$userExists) {
            throw new ApiException(ApiException::EMAIL_NOT_FOUND);
        }

        if (Auth::attempt($credentials)) {
            $req->session()->regenerate();
            $token = $req->user()->createToken("API_Token")->plainTextToken;
            $this->RESPONSE = ['login', "Successfully Logged In", $token];
        } else {
            throw new ApiException(ApiException::PASSWORD_INCORRECT);
        }
    }

    private function checkauth($req){

        $auth = false;
        if (Auth::check()) {
          $auth = true;
        }

        $this->RESPONSE = ['checkauth', "User is authenticated", $auth];
    }

    public function getResult()
    {
        return $this->RESPONSE;
    }
}
