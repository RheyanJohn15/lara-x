<?php
namespace App\Service;
use App\Models\PersonalAccessToken;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class ActivityLogger{

    private $HEADER;
    private $ACTION;
    private $TOKEN;

    public function __construct($header, $action, $token)
    {
        $this->HEADER = $header;
        $this->ACTION = $action;
        $this->TOKEN = $token;

    }

    private function getAuthUser(){
        $sepToken = explode('|', $this->TOKEN);
        $auth = PersonalAccessToken::where('tokenable_id', $sepToken[0])->where('token', $sepToken[1])->first();

        if($auth){
            return $auth->id;
        }
    }

    public function save(){
        $authID = self::getAuthUser();

        $log = new ActivityLog();
        $log->act_header = $this->HEADER;
        $log->act_action = $this->ACTION;
        $log->act_model = "User";
        $log->act_model_id = Auth::id();
        $log->access_token_id = $authID;
        $log->save();
        
    }
}
