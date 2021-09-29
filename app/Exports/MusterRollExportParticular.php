<?php
namespace App\Exports;
use App\Models\EmpDetails;
use App\Models\Doc_type;
use App\Models\ProjectDetails;
use Carbon\Carbon;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
//error_reporting(0);

class MusterRollExportParticular implements FromView
{ 
    protected $project;
    protected $day;
    protected $y;

 function __construct($project,$day,$y) {
        $this->project = $project;
        $this->day = $day;
        $this->y = $y;
 }

    public function view(): View 
    {
        if($this->project == "all"){
            $emp = EmpDetails::all(); 
        }else{
            $emp = EmpDetails::where('project_id',$this->project)->get(); 
        }
	return view('SuperUsers.musterrollsearchparticluars', ['model' => $emp,'day'=>$this->day,'y'=>$this->y]);
    }
}