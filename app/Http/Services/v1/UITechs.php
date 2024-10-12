<?php
namespace App\Http\Services\v1;
use App\Models\UITech;
class UITechs{
        /**
     * Class UITechs
     *
     * Author: Rheyan John @github RheyanJohn15
     * Description: This class handles all backend operations in UI/UX Technology Page
     * Date Created: October 13, 2024
     * Last Updated: October 13, 2024
     */

     private $RESPONSE;

     public function __construct($method, $req)
     {
         $this->$method($req);
     }

     private function save($req){
        $check = UITech::where('pi_id', $req->id)->where('type', $req->context)->first();

        if($check){
            $check->update([
                'value'=> $req->value
            ]);
        }else{
            $tech = new UITech();

            $tech->type = $req->context;
            $tech->value = $req->value;
            $tech->pi_id = $req->id;
    
            $tech->save();
        }

        $this->RESPONSE = ['UI Tech Configuration', "Successfully updated UI/UX Technology Configuration", 'null'];
     }

     private function get($req){
        $tech = UITech::where('pi_id', $req->id)->get();

        $this->RESPONSE = ['Get Tech Data', "Get Data", $tech ? $tech : 'null'];
     }

     public function getResult()
     {
         return $this->RESPONSE;
     }
 
}