<?php
namespace App\Http\Services\v1;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\ApiValidator\ApiException;

class Authenticate
{
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
            $this->RESPONSE = ['login', "Successfully Logged In", 'null'];
        } else {
            throw new ApiException(ApiException::PASSWORD_INCORRECT);
        }
    }

    public function getResult()
    {
        return $this->RESPONSE;
    }
}
