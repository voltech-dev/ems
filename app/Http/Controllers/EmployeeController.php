<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\EmpDetails;
use App\Models\Leave;
use App\Models\Dtssp;
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
        $isdata = Attendance::where(['date' => date('Y-m-d', strtotime($request->attendance_date))])->first();
        if ($isdata) {
            $model = Attendance::where(['date' => date('Y-m-d', strtotime($request->attendance_date))])->first();
        } else {
            $model = new Attendance();
        }

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
            ($hours >= 8) ? $model->status = 'Present' : (($hours >= 4) ? $model->status = 'Half-Day' : $model->status = 'Absent');
            $model->work_time = $hours;
        }
        $model->save();
        return redirect('/attendance-view/' . $model->emp_id);
    }

    public function attendanceview(Request $request)
    {

        $id = auth()->user()->emp_id;       
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
        $emp = EmpDetails::where(['id' => auth()->user()->emp_id])->get();
        $leave = Leave::where(function ($query) use ($request) {

            $date_from = $request->has('date_from') ? $request->get('date_from') : null;
            $date_to = $request->has('date_to') ? $request->get('date_to') : null;
            if (isset($date_from) && isset($date_to)) {
                $query->whereBetween('date_from', [date('Y-m-d', strtotime($date_from)), date('Y-m-d', strtotime($date_to))]);
            }
            
            $query->where(['emp_id' => auth()->user()->emp_id]);
        })->get();
        return view('employee.leave-view', [
            'modelLeave' => $leave,
            'modelEmp' => $emp,
        ]);
    }

    public function leaveshow(Request $request)
    {
        $emp = EmpDetails::where(['project_id' => auth()->user()->project_id])->get();
        $leave = Leave::where(function ($query) use ($request) {

            $date_from = $request->has('date_from') ? $request->get('date_from') : null;
            $date_to = $request->has('date_to') ? $request->get('date_to') : null;
            if (isset($date_from) && isset($date_to)) {
                $query->whereBetween('date_from', [date('Y-m-d', strtotime($date_from)), date('Y-m-d', strtotime($date_to))]);
            }
            if (isset($request->employee)) {
                $query->where(['emp_id' => $request->employee]);
            }
            $query->where(['project_id' => auth()->user()->project_id]);
        })->get();
        return view('employee.leave-show', [
            'modelLeave' => $leave,
            'modelEmp' => $emp,
        ]);
    }

    public function leaveapprove(Request $request)
    {
        $this->validate($request, ['id.*' => 'required'],
            ['id.*.required' => ' Select Aprrove Employee']
        );
        foreach ($request->id as $list) {
            $approve = Leave::find(['id' => $list])->first();

            $approve->action = $request->approve;
            $approve->save();
        }

        return redirect('/');
    }

    public function attendanceshow(Request $request)
    {
        $emp = EmpDetails::where(['project_id' => auth()->user()->project_id])->get();
        $attendance = Attendance::where(function ($query) use ($request) {

            $date_from = $request->has('date_from') ? $request->get('date_from') : null;
            $date_to = $request->has('date_to') ? $request->get('date_to') : null;
            if (isset($date_from) && isset($date_to)) {
                $query->whereBetween('date', [date('Y-m-d', strtotime($date_from)), date('Y-m-d', strtotime($date_to))]);

            }
            if (isset($request->employee)) {
                $query->where(['emp_id' => $request->employee]);
            }
            $query->where(['project_id' => auth()->user()->project_id]);
        })->get();
        return view('employee.attendance-show', [
            'model' => $attendance,
            'modelEmp' => $emp,
        ]);
    }
    public function empindex(Request $request)
    {
      return view('employee.employee-index');
    }
    

    public function projectemp(Request $request)
  {  
    $columns = [
        ['db' => 'id', 'dt' => 0],
        ['db' => 'emp_code', 'dt' => 1],
        ['db' => 'emp_name', 'dt' => 2],
        ['db' => 'mail', 'dt' => 3],
        ['db' => 'designation_id', 'dt' => 4],
        ['db' => 'project_id', 'dt' => 5],
        ['db' => 'location_id', 'dt' => 6],
        ['db' => 'id', 'dt' => 7],
        ['db' => 'id', 'dt' => 8],

    ];
     $where = 'project_id ='. auth()->user()->project_id;
    echo json_encode(
        Dtssp::simple($_GET, 'emp_details', 'id', $columns, $jointable = null, $where)
    );

  }
}
