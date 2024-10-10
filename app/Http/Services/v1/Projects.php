<?php
namespace App\Http\Services\v1;
use App\Models\ProjectInfo;
use Illuminate\Support\Facades\Auth;
class Projects{
     /**
     * Class Projects
     *
     * Author: Rheyan John @github RheyanJohn15
     * Description: Project Class handles alls CRUD and non-CRUD operations for Projects information
     * Date Created: October 10, 2024
     * Last Updated: October 10, 2024
     */

     private $RESPONSE;

     public function __construct($method, $req)
     {
         $this->$method($req);
     }

     private function add($req){
        $proj = new ProjectInfo();

        $proj->pi_name = $req->name;
        $proj->pi_description = $req->description;
        $proj->user_id = Auth::id();
        $proj->save();

        $this->RESPONSE = ['Added', "Project is Successfully Added", 'null'];
     }

     private function list($req){
        $list = ProjectInfo::where('user_id', Auth::id())->get();

        $this->RESPONSE = ['Lists', "Fetch all projects", $list];
     }

     public function getResult()
     {
         return $this->RESPONSE;
     }
}
