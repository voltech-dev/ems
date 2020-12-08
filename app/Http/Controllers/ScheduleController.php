<?php
namespace App\Http\Controllers;

use App\Mail\EMSMail;
use App\Models\EmpDetails;
use App\Models\HolidayLists;
use App\Models\ProjectDetails;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class ScheduleController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function Testmail()
    {
        $suject = 'This is test mail';
        $details = [
            'title' => 'Mail from ems.com',
            'body' => 'This is for testing email using smtp',
        ];
        Mail::to('prakashv85@gmail.com')->send(new EMSMail($suject, $details));
    }

    public function markattendance()
    {
        $description = null;

        $dt = Carbon::now();
        $dt->toDateString();

        $today = new Carbon();

        $projects = ProjectDetails::all();
        echo '<table border="1">';
        foreach ($projects as $project) {
            /* find the holiday */
            if ($today->dayOfWeek == Carbon::SUNDAY) {
                $description = 'W.O';
            } else {
                if (HolidayLists::where(['holiday' => $dt->toDateString(), 'project_id' => $project->id])->exists()) {
                    $description = 'Holiday';
                } elseif (HolidayLists::where(['holiday' => $dt->toDateString(), 'project_id' => null])->exists()) {
                    $description = 'Holiday';
                } else {
                    $description = 'absent';
                }
            }

            $emps = EmpDetails::where(['project_id' => $project->id, 'status_id' => 1])->get();
            foreach ($emps as $emp) {
                $attendance = Attendance::where(['project_id' => $project->id, 'date' => $dt->toDateString(), 'emp_id' => $emp->id])->first();
                if ($attendance === null) {
                  //  $att = new Attendance();
                    $att->emp_id = $dt->$emp->id;
                    $att->project_id = $project->id;
                    $att->date = $dt->toDateString();
                    $att->in_time = '00:00:00';
                    $att->out_time = '00:00:00';
                    $att->status = $description;
                   // $att->save();                    
                }
            }
            /*  updation */

        }
        echo '</table>';
    }

}
/*

$emps = EmpDetails::where(['status_id' => 1])->get();
foreach ($emps as $emp) {
echo '<tr><td>' . $emp->emp_name . '</td><td>' . $dt->toDateString() . '</td><td>'. $description.'</td><td>'. $project->project_name.'</td></tr>';
}
 */
