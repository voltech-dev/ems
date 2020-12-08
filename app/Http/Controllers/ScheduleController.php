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
        echo '<table>';
        foreach ($projects as $project) {
            if ($today->dayOfWeek == Carbon::SUNDAY) {
                $description = 'W.O';
            } else {
                $holidays = HolidayLists::where(['holiday' => $dt->toDateString()])->get();
                foreach ($holidays as $holiday) {
                    if ($holiday->project_id == $project->id) {
                        $description = $holiday->description;
                    } else {
                        $description = $holiday->description;
                    }
                }
            }
            $emps = EmpDetails::where(['project_id' => $project->id, 'status_id' => 1])->get();
            foreach ($emps as $emp) {
                echo '<tr><td>' . $emp->emp_name . '</td><td>' . $dt->toDateString() . '</td><td>'. $description.'</td></tr>';
            }
        }
        echo '</table>';
    }

}
