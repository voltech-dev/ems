<?php
namespace App\Http\Controllers;
use App\Mail\EMSMail;
use App\Models\Attendance;
use App\Models\Dtssp;
use App\Models\EmpDetails;
use App\Models\ProjectDetails;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Exports\ProjectAttExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SuperUserExport;

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

    public function mail()
    {
        $suject = 'This is test mail';
        $details = [
            'title' => 'Mail from ems.com',
            'body' => 'This is for testing email using smtp',
        ];
        Mail::to('prakashv85@gmail.com')->send(new EMSMail($suject, $details));
    }

}