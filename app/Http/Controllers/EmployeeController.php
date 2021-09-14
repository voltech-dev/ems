<?php

namespace App\Http\Controllers;

use App\Mail\EMSMail;
use App\Models\Attendance;
use App\Models\Dtssp;
use App\Models\EmpDetails;
use App\Models\ProjectDetails;
use App\Models\Leave;
use App\Models\LeaveBalance;
use App\Models\Holiday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Exports\ProjectAttExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SuperUserExport;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\User;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function mail()
    {
        $suject = 'This is test mail from Emp';
        $details = [
            'title' => 'Mail from ems.com',
            'body' => 'This is for testing email using smtp',
        ];
        Mail::to('admin@gmail.com')->send(new EMSMail($suject, $details));
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
                'in_time.required' => 'Punch Time required',
            ]);
        $isdata = Attendance::where(['date' => date('Y-m-d', strtotime($request->attendance_date)),'emp_id'=> $request->empid])->first();
        if ($isdata) {
            $model = Attendance::where(['date' => date('Y-m-d', strtotime($request->attendance_date)),'emp_id'=> $request->empid])->first();
        } else {
            $model = new Attendance();
        }

        $model->emp_id = $request->empid;
        $model->project_id = $request->projectid;
        $model->date = date('Y-m-d', strtotime($request->attendance_date));

        $x = preg_replace('/\s*:\s*/', ':', $request->in_time);
        $model->in_time = date("H:i", strtotime($x));
        if ($request->out_time != '') {
            $y = preg_replace('/\s*:\s*/', ':', $request->out_time);
            $model->out_time = date("H:i", strtotime($y));
        }
        if ($request->out_time == '' || $request->in_time == '') {
            $model->status = 'Waiting for Punch';
            $model->flag = '2';
        } else {
            $diff = (strtotime($model->out_time) - strtotime($model->in_time));
            $hours = intval($diff / 3600);
            // ($hours >= 8) ? $model->status = 'Present' : (($hours >= 4) ? $model->status = 'Half-Day' : $model->status = 'Absent');
            if($hours >=8){
                $model->status = 'Present';
                $model->flag = '1';                
            }elseif($hours >= 4){
                $model->status = 'Half-Day';
                $model->flag = '0.5';
            }else{
                $model->status = 'Absent';
                $model->flag = '0';
            }
            $model->work_time = $hours;
        }
		$model->autoupdate=NULL;
        $model->save();
        return redirect('/attendance-view/');
    }

    public function outtime($id)
    {
        $att = Attendance::findOrFail($id);
        return view('employee.outtime', [
            'attModel' => $att]);
    }
    public function holidays()
    {
          return view('settings.holidays');
    }
    public function holidaystore(Request $request)
    {
       if($request->check=="all"){  
        $project_details = ProjectDetails::get();
        foreach($project_details as $project){
         $ifExist = Holiday::where(['project_id'=>$project->id,'holiday'=>date('Y-m-d', strtotime($request->date))])->first();
         if($ifExist){
         $ifExist->delete();
         }
          $model = new Holiday();
          $model->holiday =date('Y-m-d', strtotime($request->date));
          $model->project_id=$project->id;
          $model->description = $request->check;
          $model->leave_details =$request->leave_details;
          $model->save(); 
        }
        return view('settings.holidays');
        

       }
       
       else{
      
       $ifExist = Holiday::where(['project_id'=>$request->project,'holiday'=>date('Y-m-d',strtotime($request->date))])->first();
       if($ifExist){
        $model = Holiday::where(['project_id'=>$request->project])->first(); 
       }else{
        $model = new Holiday();
       }

       
        $model->holiday = date('Y-m-d', strtotime($request->date));
        $model->project_id = $request->project;
        $model->description = $request->check;
        $model->leave_details =$request->leave_details;
        $model->save();
          return view('settings.holidays');
    }
    }

    public function leavedata(Request $request)
    {
        $jointable =
        [
        ['table' => 'project_details AS b', 'on' => 'a.project_id=b.id', 'join' => 'LEFT JOIN'],
    ];
        $columns = [
            ['db' => 'a.id', 'dt' => 0, 'field' => 'id', 'as' => 'slno'],
            ['db' => 'a.holiday', 'dt' => 1,'field' => 'holiday'],
            ['db' => 'b.project_name', 'dt' => 2, 'field' => 'project_name'],
           // ['db' => 'project_id', 'dt' => 2],
            ['db' => 'a.leave_details', 'dt' => 3,'field' => 'leave_details'],

        ];
        // $where = 'status=>Entry Completed';
        echo json_encode(
            Dtssp::simple($_GET, 'holiday_lists AS a', 'a.id', $columns, $jointable, $where = null)
        );

    }

    public function leavedays(Request $request){

       $post =$request->all();
       
       $holiday_list = Holiday::where(['holiday'=>date('Y-m-d', strtotime($post['date_value']))])->first();
       if($holiday_list){
       $leave_details =$holiday_list->leave_details;
       }else{
        $leave_details=""; 
       }
       echo json_encode(['leave_details' => $leave_details]);
       
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
	 public function todayattendance(Request $request, ProjectDetails $proj)
    {
		//  $Employee = EmpDetails::where(function ($query) use ($request) {
        //     if (isset($request->project)) {
        //         $query->where(['project_id' => $request->project]);
        //     }
		// 	 $query->where(['status_id' => 1]);
        // })->get(); 
        $date = date('Y-m-d');
        $Employee = EmpDetails::all();
		 return view('SuperUsers.todayattendance',['model1' =>$proj, 'model' => $Employee,'date'=>$date]);
	}
    public function todayattposts(Request $request, ProjectDetails $proj)
    {
        $proje = $request->project;
        $status = $request->status;
        $date = date('Y-m-d');
        $attendance = Attendance::where(['project_id'=>$proje,'date'=>$date,'status'=>$status])->get();
		 return view('SuperUsers.todayattendance_post',['model1' =>$proj, 'model' => $attendance,'date'=>$date]);
	}
    public function todayattpost(Request $request, ProjectDetails $proj)
    {
        $proje = $request->project;
        $status = $request->status;
        $date = date('Y-m-d');
        if($proje && $status != ''){
            $attendance = Attendance::where(['project_id'=>$proje,'date'=>$date,'status'=>$status])->get();
        }elseif($proje !='' && $status == ''){
            $attendance = Attendance::where(['project_id'=>$proje,'date'=>$date])->get();
        }else{
            $date = date('Y-m-d');
            $Employee = EmpDetails::all();
            return redirect('/todayattendance');
        }      
		 return view('SuperUsers.todayattendance_post',['model1' =>$proj, 'model' => $attendance,'date'=>$date]);
	}
	
    public function superuser_attendance(Request $request, ProjectDetails $proj)
    {
		 $Employee = EmpDetails::where(function ($query) use ($request) {
            if (isset($request->project)) {
                $query->where(['project_id' => $request->project]);
            }
			 $query->where(['status_id' => 1]);
        })->get();
		 /*
        $id = auth()->user()->id;
        $attendance = Attendance::where(function ($query) use ($request, $prop, $id) {

            $date_from = $request->has('date_from') ? $request->get('date_from') : null;
            $date_to = $request->has('date_to') ? $request->get('date_to') : null;
            if (isset($date_from) && isset($date_to)) {
                $query->whereBetween('date', [date('Y-m-d', strtotime($date_from)), date('Y-m-d', strtotime($date_to))]);
            }
            if (isset($request->project)) {
                $query->where(['project_id' => $request->project]);
            }
            if (isset($request->status)) {
                $query->where(['status' => $request->status]);
            }
			 if(!isset($date_from) && !isset($date_to) && !isset($request->project)) {
            $query->where(['date' => date('Y-m-d', strtotime(today()))]);
			 }
        })->get();
           return view('SuperUsers.superuser_attendance', ['model1' =>$prop, 'model' => $attendance]);
		   */
		    return view('SuperUsers.superuser_attendance', ['model1' =>$proj, 'model' => $Employee]);
  
    }
    public function superuser_leavemgmt(Request $request, ProjectDetails $prop)
    {
        $id = auth()->user()->id;
        $leave = Leave::where(function ($query) use ($request, $prop, $id) {

            $date_from = $request->has('date_from') ? $request->get('date_from') : null;
            $date_to = $request->has('date_to') ? $request->get('date_to') : null;
            if (isset($date_from) && isset($date_to) && !isset($request->superuser) && !isset($request->action)) {
                $query->whereBetween('date_from', [date('Y-m-d', strtotime($date_from)), date('Y-m-d', strtotime($date_to))]);
            }
            if(isset($request->superuser) && isset($request->action)){
                $query->where(['project_id' => $request->superuser, 'action' => $request->action]);
            }
            if(isset($request->superuser) && isset($date_from) && isset($date_to) && !isset($request->action)){
                $query->where(['project_id' => $request->superuser])
                ->whereBetween('date_from', [date('Y-m-d', strtotime($date_from)), date('Y-m-d', strtotime($date_to))]);
            }
            if(isset($request->action) && isset($date_from) && isset($date_to) && !isset($request->superuser)){
                $query->where(['action' => $request->action])
                ->whereBetween('date_from', [date('Y-m-d', strtotime($date_from)), date('Y-m-d', strtotime($date_to))]);
            }
            if (isset($date_from) && !isset($date_to)) {
                $query->whereBetween('date_from', [date('Y-m-d', strtotime($date_from)), date('Y-m-d', strtotime(today()))]);
            }
            if (isset($request->superuser) && isset($date_from) && isset($date_to) && isset($request->action)) {
                $query->where(['project_id' => $request->superuser, 'action' => $request->action, 'date_from', [date('Y-m-d', strtotime($date_from)), date('Y-m-d', strtotime($date_to))]]);
            }
            if (isset($request->superuser) && !isset($date_from) && !isset($date_to) && !isset($request->action)) {
                $query->where(['project_id' => $request->superuser]);
            }
            if (isset($request->action) && !isset($date_from) && !isset($date_to) && !isset($request->superuser)) {
                $query->where(['action' => $request->action]);
            }
            if(!isset($date_from) && !isset($date_to)) {
            $query->where(['date_from' => date('Y-m-d', strtotime(today()))]);
			}
        })->get();
           return view('SuperUsers.superuser_leavemgmt', ['model1' =>$prop, 'model' => $leave]);
  
    } 
    public function exportIntoExcel()
    {
    return Excel::download(new SuperUserExport, 'Adminattendance.xlsx');
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
        $model->action = 'Waiting for approval';
        $model->save();
        return redirect('/leave-view');
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
            if (isset($request->action)) {
                $query->where(['action' => $request->action]);
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
            ['id.*.required' => ' Select Approve Employee']
        );
        foreach ($request->id as $list) {
            $approve = Leave::find(['id' => $list])->first();
            $date_from = $approve->date_from;
            $date_to = $approve->date_to ? $approve->date_to : $approve->date_from;
            $dateRange = CarbonPeriod::create($date_from, $date_to);
            $nowDate = date('Y-m-d');
            foreach ($dateRange as $rang) {
                if ($nowDate > $rang) {  
				if(LeaveBalance::where(['emp_id' => $approve->emp_id])->exists()) {
                    $lb = LeaveBalance::where(['emp_id' => $approve->emp_id])->first();  				   
                    if($lb->days > 0 && $lb){ 
                    $lb->days =  $lb->days -1;   
      
                    $att = Attendance::where(['date' => $rang, 'emp_id' => $approve->emp_id])->exists();
                    $att->status = 'Leave';
                    $att->save();
                    $lb->save();
                    }   
				 }
                }
                $approve->action = $request->approve;
                $approve->save();
            }
        }
        return redirect('/leave-show');
    }    
	
    public function attendanceexport(Request $request)
    {
        return Excel::download(new ProjectAttExport, 'invoices.xlsx');
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
            if (isset($request->status)) {
                $query->where(['status' => $request->status]);
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
    public function empdetails(Request $request, $id)
    {
        $emp = EmpDetails::find($id);
        return view('employee.emp_details', [
            'model' => $emp,
        ]);
    }
    public function projectemp(Request $request)
    {

        $jointable =
            [
            ['table' => 'project_details AS b', 'on' => 'a.project_id=b.id', 'join' => 'LEFT JOIN'],
            ['table' => 'designations AS c', 'on' => 'a.designation_id=c.id', 'join' => 'LEFT JOIN'],
            ['table' => 'locations AS d', 'on' => 'a.location_id=d.id', 'join' => 'LEFT JOIN'],
        ];
        $columns = [
            ['db' => 'a.id', 'dt' => 0, 'field' => 'id', 'as' => 'slno'],
            ['db' => 'a.emp_code', 'dt' => 1, 'field' => 'emp_code', 'as' => 'emp_code'],
            ['db' => 'a.emp_name', 'dt' => 2, 'field' => 'emp_name', 'as' => 'emp_name'],
            ['db' => 'a.mail', 'dt' => 3, 'field' => 'mail', 'as' => 'mail'],
            ['db' => 'c.designation_name', 'dt' => 4, 'field' => 'designation_name', 'as' => 'designation_name'],
            ['db' => 'b.project_name', 'dt' => 5, 'field' => 'project_name', 'as' => 'project'],
            ['db' => 'd.location', 'dt' => 6, 'field' => 'location', 'as' => 'location'],

            ['db' => 'a.id', 'dt' => 7, 'field' => 'id', 'as' => 'id'],

        ];
        $where = 'project_id =' . auth()->user()->project_id;
        echo json_encode(
            Dtssp::simple($_GET, 'emp_details AS a', 'a.id', $columns, $jointable, $where)
        );
    }

     public function credential($id)
    {
        $emp = EmpDetails::findOrFail($id);
        return view('employee.credential', [
            'model' => $emp]);
    }

    public function storeuser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => 'required',
            'emp_id' => 'required',          
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->forceFill([
            'password' => Hash::make($request->password),
        ]);
        $user->role = 'Employee';
        $user->emp_id = $request->emp_id;
        
        if ($user->save()) {
            return redirect()->back()->with(['status' => 'User Created successfully.']);
        }
      
    }
    public function musterroll(Request $request,ProjectDetails $proj)
    {   
        $disp  = ProjectDetails::first(); 
// echo $disp->id;// exit(0);
        $emp = EmpDetails::where('project_id',$disp->id)->get();; 
        $day = date('m');
        $y = date('Y');
        $list=array();
        $month = $day;
        $year = $y;
	return view('SuperUsers.musterroll', ['model1' =>$proj, 'model' => $emp,'day'=>$day,'y'=>$y,'list'=>$list,'month'=>$month,'year'=>$year]);
       
    }
    public function musterrollpost(Request $request,ProjectDetails $proj)
    {   
        $project = $request->project;
        $day = $request->month;
        $y = $request->year;
        if($project == "all"){
            $emp = EmpDetails::all(); 
        }else{
            $emp = EmpDetails::where('project_id',$project)->get(); 
        }
        
        //$day = date('m');
        //$y = date('Y');
        $list=array();
        $month = $day;
        $year = $y;
	return view('SuperUsers.musterroll', ['model1' =>$proj, 'model' => $emp,'day'=>$day,'y'=>$y,'list'=>$list,'month'=>$month,'year'=>$year]);
       
    }

}