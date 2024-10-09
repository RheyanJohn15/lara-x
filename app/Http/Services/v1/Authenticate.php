<?php
namespace App\Http\Services\v1;

class Authenticate{
    private $REQ;
    public function __construct($method, $req)
    {
        $this->REQ = $req;

        $result = $this->$method();

        return $result;
    }

    public function login(){

    }


}
