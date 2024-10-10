<?php
namespace App\Service;
use App\Models\PersonalAccessToken;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class ActivityLogger{

    private $HEADER;
    private $ACTION;

    public function __construct($header, $action)
    {
        $this->HEADER = $header;
        $this->ACTION = $action;
    }


    public function save(){
        $log = new ActivityLog();
        $log->act_header = $this->HEADER;
        $log->act_action = $this->ACTION;
        $log->act_model = "User";
        $log->act_model_id = Auth::id();
        $log->save();
        
    }
}
