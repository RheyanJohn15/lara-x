<?php
namespace App\Http\Services\v1;

use App\Http\ApiValidator\ApiException;
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

     private function delete($req){
        $project = ProjectInfo::where('pi_id', $req->id)->first();

        $project->delete();

        $this->RESPONSE = ['Deleted', "Project is successfully deleted", 'null'];
     }

     private function info($req){
        $project = ProjectInfo::where('pi_id', $req->id)->first();

        $this->RESPONSE = ['Information', "Get Project Information", $project];
     }

     private function uploadlogo($req){
        $file = $req->file('file');

        if(!in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png'])){
            throw new ApiException(ApiException::INVALID_IMAGE_TYPE);
        }
        $extension = $file->getClientOriginalExtension();
        $newFileName = "P_LOGO$req->id.$extension";
        $file->move(public_path('ProjectLogos/'), $newFileName);

        $project = ProjectInfo::where('pi_id', $req->id)->first();

        $project->update([
            'pi_logo' => $newFileName
        ]);

        $this->RESPONSE = ['Upload Logo', "Logo is successfully updated", 'null'];
     }

     private function update($req){
         $project = ProjectInfo::where('pi_id', $req->id)->first();
         $project->update([
            'pi_name'=> $req->name,
            'pi_description'=> $req->description
         ]);
         
         $this->RESPONSE = ['Update Project', "Successfully Updated", 'null'];
     }

     public function getResult()
     {
         return $this->RESPONSE;
     }
}
