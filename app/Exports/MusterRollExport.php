<?php
namespace App\Exports;
use App\Models\EmpDetails;
use App\Models\Doc_type;
use App\Models\ProjectDetails;
use Carbon\Carbon;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
//error_reporting(0);

class MusterRollExport implements FromView
{
    public function view(): View 
    {
        $month = date('m');
        $year = date('Y');
            for($d=1; $d<=31; $d++)
                {
                    $time=mktime(12, 0, 0, $month, $d, $year);          
                        if (date('m', $time)==$month)       
                    $list[] = date('d', $time);
                }

    $first = current($list);
    $last = end($list);
        $proj = ProjectDetails::all();
        $disp  = ProjectDetails::first(); 
        $emp = EmpDetails::where('project_id',$disp->id)->get();
        $day = date('m');
        $y = date('Y');
        $list=array();
        $month = $day;
        $year = $y;
	return view('SuperUsers.musterrollsearch', ['model1' =>$proj, 'model' => $emp,'day'=>$day,'y'=>$y,'list'=>$list,'month'=>$month,'year'=>$year,'last'=>$last]);
    }
}