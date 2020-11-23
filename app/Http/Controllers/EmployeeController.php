<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\EmpDetails;
use App\Models\Leave;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function attendance()
    {
        $emp = EmpDetails::findOrFail(auth()->user()->emp_id);
        return view('employee.attendance', [
            'model' => $emp]);
    }

    public function attendancestore(Request $request)
    {
        $this->validate($request, [
            'in_time' => 'required',
        ],
            [
                'in_time.required' => ' Punch Time required',
            ]);
        $model = new Attendance();
        $model->emp_id = $request->empid;
        $model->project_id = $request->projectid;
        $model->date = date('Y-m-d', strtotime($request->attendance_date));

        $x = preg_replace('/\s*:\s*/', ':', $request->in_time);
        $model->in_time = date("H:i", strtotime($x));

        $y = preg_replace('/\s*:\s*/', ':', $request->out_time);
        $model->out_time = date("H:i", strtotime($y));

        if ($request->out_time == '' || $request->in_time == '') {
            $model->status = 'Waiting for Punch';
        } else {
            $diff = (strtotime($model->out_time) - strtotime($model->in_time));
            $hours = intval($diff / 3600);
            ($hours >= 6) ? $model->status = 'Present' : (($hours >= 4) ? $model->status = 'Half-Day' : $model->status = 'Absent');
            $model->work_time = $hours;
        }
        $model->save();
        return redirect('/attendance-view/' . $model->emp_id);
    }

    public function attendanceview(Request $request, $id)
    {

        $emp = EmpDetails::findOrFail($id);

        $attendance = Attendance::where(function ($query) use ($request, $id) {

            $date_from = $request->has('date_from') ? $request->get('date_from') : null;
            $date_to = $request->has('date_to') ? $request->get('date_to') : null;
            if (isset($date_from) && isset($date_to)) {
                $query->whereBetween('date', [date('Y-m-d', strtotime($date_from)), date('Y-m-d', strtotime($date_to))]);
            }
            $query->where(['emp_id' => $id]);
        })->get();
        return view('employee.attendance-view', [
            'model' => $attendance,
            'modelemp' => $emp,
        ]);

    }
    public function leaveform()
    {
        $emp = EmpDetails::findOrFail(auth()->user()->emp_id);
        return view('employee.leaveform', [
            'model' => $emp]);
    }

    public function leavestore(Request $request)
    {
        $this->validate($request, [
            'date_from' => 'required',
        ],
            [
                'date_from.required' => ' Leave Date Required ',
            ]);
        $model = new Leave();
        $model->emp_id = $request->empid;
        $model->project_id = $request->projectid;
        $model->date_from = date('Y-m-d', strtotime($request->date_from));
        $model->date_to = $request->date_to ? date('Y-m-d', strtotime($request->date_to)) : null;
        $model->reason = $request->reason;
        $model->leave_type = $request->leave_type;
        $model->col_date = $request->col_date ? date('Y-m-d', strtotime($request->col_date)) : null;
        $model->action = 'Waiting for approvel';
        $model->save();
        return redirect('/');
    }

    public function leaveview(Request $request)
    {

        $leave = Leave::where(function ($query) use ($request) {

            $date_from = $request->has('date_from') ? $request->get('date_from') : null;
            $date_to = $request->has('date_to') ? $request->get('date_to') : null;
            if (isset($date_from) && isset($date_to)) {
                $query->whereBetween('date_from', [date('Y-m-d', strtotime($date_from)), date('Y-m-d', strtotime($date_to))]);
            }
            $query->where(['project_id' => auth()->user()->project_id]);
        })->get();
        return view('employee.leave-view', [
            'modelLeave' => $leave,
        ]);

    }
}
