<?php
namespace App\Http\Controllers;

use App\Mail\EMSMail;
use App\Mail\PayslipMail;
use App\Mail\OfferletterMail;
use App\Models\Attendance;
use App\Models\BusinessDays;
use App\Models\EmpDetails;
use App\Models\Documents;
use App\Models\EmpSalary;
use App\Models\HolidayLists;
use App\Models\ProjectDetails;
use App\Models\EmpRemunerationDetails;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Jobs\SendMissPunchMorning;
use Illuminate\Http\Request;
use App\Models\EmpSalaryActual;
use App\Models\LeaveBalance;
use App\Models\Leave;
use PDF;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    public function processQueue()
    {
	/*$mail ='v.jeyaprakash@voltechgroup.in';
        $subject = 'Missing Attendance Punch';
        $details = [
            'title' => 'Dear Associate,',
            'body' => [
                'line_1' => 'You have not punched your attendance today, failing of which can be treated as LOP for the entire day.',
                'line_2' => 'Kindly ignore if already punched your attendance',
            ],
        ];
		 Mail::to($mail)->send(new EMSMail($subject, $details));   */ 
		 DB::table('cron_test')->insert([
			'message' => 'cron running'			
		]);
    }
    public function punchmiss()
    {
	/*$mail ='v.jeyaprakash@voltechgroup.in'; */
        $dt = Carbon::now();
        $date = new BusinessDays();
        if (!$date->isWeekendDay(Carbon::now())) {
            $emps = EmpDetails::where(['status_id' => 1])->get();
            foreach ($emps as $Emp) {
                if (!Attendance::where(['emp_id' => $Emp->id,'date'=>$dt->toDateString()])->exists()) {
                    $subject = $Emp->emp_name .' Missing Attendance Punch';
                    $details = [
                        'title' => 'Dear Mr/Ms. '.$Emp->emp_name .',',
                        'body' => [
                            'line_1' => 'As per our record it is noted that your in-time for the date '.$dt->format('d-m-Y'). ' is not registered in our system.',
                            'line_2' => 'Hence you may please login and Punch IN your Attendance. In the event of failing to punch IN/OUT the day will be considered as LOP',							
							'line_3' => 'Kindly Contact HR Support Team 9500006902 in case of any query',
                        ],
                    ];
                   Mail::to($Emp->mail)->send(new EMSMail($subject, $details));
				 // Mail::to($mail)->send(new EMSMail($subject, $details));				  
                  // $emailJob = new SendMissPunchMorning($subject, $details);
                  // dispatch($emailJob);				 
                }
            }
        }
		
    }
	
	public function payslipmail(Request $request)
    {
       
		 foreach ($request->Ids as $key) {
		  $salary = EmpSalary::findOrFail($key);
		  $emp = EmpDetails::findOrFail($salary->empid); 
		  $subject = 'Payslip for the Month of ' . date("F Y",strtotime($salary->month));
		  
		  if($emp->gender == 'Male') {
			$salutation ='Mr.';
		} elseif($emp->gender == 'Female') {
		 $salutation ='Ms.';
		} else {
			$salutation = '';
		}
		  $details = 'Dear '. $salutation . $emp->emp_name . ' (' . $emp->emp_code . ') <br> Your Payslip for the Month of '.date("F Y",strtotime($salary->month)).', is available in below link for your kind perusal.
                            <a href="http://ems.voltechgroup.com/public/payslippdf/'. $salary->email_hash .'"> please download your payslip by clicking here, within 30 days from the receipt of this mail</a>';
                        
                    Mail::to($emp->email_personal)->send(new PayslipMail($subject, $details));
					   $salary->email_status = 1;
					   $salary->save();
				
				   $result ='success';
		}		
	   return response()->json([
            'success' => $result,
        ]);
    }
	public function markattendance(){
		$attendance =  Attendance::where(['status' =>'Waiting for Punch'])->get();
		foreach($attendance as $att) {
			$model =  Attendance::findOrFail($att->id);		
			$model->status = 'Half-Day';
			$model->autoupdate = 1;  
			$model->save();
			}
	}

  /*  public function markattendance()
    {
        $description = null;

        $dt = Carbon::now();
        $dt->toDateString();

        $today = new Carbon();

        $projects = ProjectDetails::all();
        echo '<table border="1">';
        foreach ($projects as $project) {
            if ($today->dayOfWeek == Carbon::SUNDAY) {
                $description = 'W.O';
                $emps = EmpDetails::where(['project_id' => $project->id, 'status_id' => 1])->get();
                foreach ($emps as $emp) {
                    echo '<tr><td>' . $emp->emp_name . '</td><td>' . $dt->toDateString() . '</td><td>' . $description . '</td><td>' . $project->project_name . '</td></tr>';
                }
            } else {
                $holidays = HolidayLists::where(['holiday' => $dt->toDateString()])->get();
                foreach ($holidays as $holiday) {
                    if ($holiday->project_id == $project->id) {
                        $description = $holiday->description;
                        $emps = EmpDetails::where(['project_id' => $project->id, 'status_id' => 1])->get();
                        foreach ($emps as $emp) {
                            echo '<tr><td>' . $emp->emp_name . '</td><td>' . $dt->toDateString() . '</td><td>' . $description . '</td><td>' . $project->project_name . '</td></tr>';
                        }
                    } else {
                        $description = $holiday->description;
                        $emps = EmpDetails::where(['project_id' => $project->id, 'status_id' => 1])->get();
                        foreach ($emps as $emp) {
                            echo '<tr><td>' . $emp->emp_name . '</td><td>' . $dt->toDateString() . '</td><td>' . $description . '</td><td>' . $project->project_name . '</td></tr>';
                        }
                    }
                }
            }

        }
        echo '</table>';
    } */
	
	public function payslippdf(Request $request,$id)
    {
        $model = EmpSalary::where(['email_hash'=>$id])->first();
        $actual = EmpSalaryActual::where(['empid'=>$model->empid])->first();
        $options = [
            'orientation' => 'portrait',
            'encoding' => 'UTF-8',           
        ];
        $pdf = PDF::loadView('empsalary.payslippdf', [
            'model' => $model,
            'actual' => $actual,
        ]);

	return $pdf->inline();
		 
    }
	
	public function autoUpdate()
    {
        $dt = Carbon::now();	  
        $dt->toDateString();
        
        $today = new Carbon();
		//$today = Carbon::yesterday();

        $Employees = EmpDetails::all();
        foreach ($Employees as $emp) {
            $model = new Attendance();
            $saveFlag = 0;

            if ($today->dayOfWeek == Carbon::SUNDAY) {
                if (!Attendance::where(['date' => $dt->toDateString(), 'emp_id' => $emp->id])->exists()) {                   
                    $model->emp_id = $emp->id;                  
                    $model->project_id = $emp->project_id;
                    $model->date = $dt->toDateString();
                    $model->status = 'W.O'; 
					$model->autoupdate = 1; 
                    $saveFlag = 1;                
                }
            } else {
                if (!Attendance::where(['date' => $dt->toDateString(), 'emp_id' => $emp->id])->exists()) {
                    if (HolidayLists::where(['holiday' => $dt->toDateString(), 'project_id' => $emp->project_id])->exists()) {
                        $holiday = HolidayLists::where(['holiday' => $dt->toDateString(), 'project_id' => $emp->project_id])->first();
                        $model->emp_id = $emp->id;
                        $model->project_id = $emp->project_id;
                        $model->date = $dt->toDateString();
                        //$model->status = $holiday->description;
                        $model->status = 'Holiday';
						$model->autoupdate = 1; 
                        $saveFlag = 1; 
                    } else {
                        $leave = Leave::where(['emp_id' => $emp->id, 'project_id' => $emp->project_id,'action'=>'Approved'])
                            ->where('date_from', '<=', $dt->toDateString())
                            ->orWhere('date_to', '>=', $dt->toDateString())
                            ->first();
                         $lb = LeaveBalance::where(['emp_id' => $emp->id])->first();
                        if ($leave && $lb->days > 0) {
                            $model->emp_id = $emp->id;
                            $model->project_id = $emp->project_id;
                            $model->date = $dt->toDateString();
                            $model->status = 'Leave';
							$model->autoupdate = 1; 
                            $saveFlag = 1; 
                            $balance = $lb->days - 1;
                            $lb->days = $balance < 0 ? 0 : $balance;
                            $lb->save();
                        } else {
                            $model->emp_id = $emp->id;
                            $model->project_id = $emp->project_id;
                            $model->date = $dt->toDateString();
                            $model->status = 'Absent';
							$model->autoupdate = 1; 
                            $saveFlag = 1; 
                        }
                    }
                }
            }  
            if($saveFlag ==1){
                $model->save();
            }        
        }
    }

    public function sendmail(Request $request,$id,$empcode,$email)
    {
        $remuncheck = EmpRemunerationDetails::where('empid',$id)->exists();
        if($remuncheck){      
        
        $date = date('Y-m-d');
        $date1 = date('Y-m-d').rand();
        $name = $empcode.'_'.'Offer Letter'.'.pdf';
        $names = $empcode.'_'.'Offer Letter_'.$date1.'.pdf';
		$Emp = EmpDetails::find($id);
		$headerHtml = view()->make('empdetails.header')->render();
        $footerHtml = view()->make('empdetails.footer')->render();
		 $options = [
            'orientation' => 'portrait',
            'encoding' => 'UTF-8', 
			'header-html' => $headerHtml,
            'footer-html' => $footerHtml,	
        ];
        $pdf = PDF::loadView('empdetails.offerletter', ['model' => $Emp,]);     
        $pdf->setOptions($options); 
        $pdf->inline($Emp->emp_name.'.pdf');  
        Storage::put('public/employee/'.$empcode.'_'.'Offer Letter'.'.pdf', $pdf->output());
          
        $Empfile = new Documents;
        $Empfile->empid=$id;
        $Empfile->document_name = $name;
        $Empfile->document_dummy_name = $names;
        $Empfile->document_type = "Offer Letter";
        $Empfile->save();

        $email = Documents::where(['empid' => $id,'document_type'=>'Offer Letter'])->latest()->first();
        $emp = EmpDetails::findOrFail($id); 
                if($emp->gender == 'Male') {
                    $salutation ='Mr.';
                } elseif($emp->gender == 'Female') {
                 $salutation ='Miss/Mrs.';
                } else {
                    $salutation = '';
                }
            $docname1 = $email->empid;
            $docname = $email->document_name;
                 //   Mail::to("test@gmail.com")->send(new OfferletterMail($subject, $details,$docname));
                   $data["email"] = $emp->email_personal;                
                  // $data["title"] = "Voltech HR Services"; 
                  $data["title"] = "Reg: Offer of Appointment"; 
                  // $data["body"] = 'Dear   '. $salutation . $emp->emp_name . ' (' . $emp->emp_code . ')';
                  $data["body"] = 'Dear   '. $salutation . $emp->emp_name;
                   $data["body1"] = 'Greetings !';
                   $data["body2"] = 'Warm welcome to Voltech Family!';
                   $data["body3"] = 'We are pleased to share you Fixed term Appointment letter, kindly revert us with duly signed copy and please courier us the hard copy of the same along with below mentioned documents within  2 days from receipt of this email,';

                //    $data["body4"] = '1.	MIS Form (Attached)';
                   $data["body5"] = '1.	AUP (Attached)';
                   $data["body6"] = '2.	NDA (Attached)';

                   $data["body7"] = 'Note: With reference to clause 5, this offer and your continued employment is conditional upon the result of background checks';

                   $data["body8"] = 'http://hr.voltechgroup.com/img/uploads/VHRS-COC.pdf';

                   $data["body9"] = 'For further support please do get in touch with us.';
                   $data["body10"] = 'Contact: 9500006902, hr.support@voltechgroup.com / rishikeshav.jr@voltechgroup.com';

                   //$files = [str_replace('\\', '/', public_path('../storage/app/public/employee/'.$empcode.'_'.'Offer Letter'.'.pdf')),str_replace('\\', '/', public_path('../storage/app/public/employee/'.'VHRS_AUP_2021'.'.pdf')),str_replace('\\', '/', public_path('../storage/app/public/employee/'.'VHRS_NDA_2021'.'.pdf')),str_replace('\\', '/', public_path('../storage/app/public/employee/'.'MIS form-L&T'.'.pdf'))]; 
                   $files = [str_replace('\\', '/', public_path('../storage/app/public/employee/'.$empcode.'_'.'Offer Letter'.'.pdf')),str_replace('\\', '/', public_path('../storage/app/public/employee/'.'VHRS_AUP_2021'.'.pdf')),str_replace('\\', '/', public_path('../storage/app/public/employee/'.'VHRS_NDA_2021'.'.pdf'))]; 
                   Mail::send('emails.offerletter', $data, function($message)use($data, $files) {
                   // Mail::send(new OfferletterMail($details,$docname, $data, function($message)use($data, $files,$details)){
                    $message->to($data["email"], $data["email"])->cc(['raphealjerald.j@voltechgroup.com'])->subject($data["title"]);
                    foreach ($files as $file){
                    $message->attach($file);
                     }
                    });
                   
					$email->status = 1;
					   
                       if($email->save())	{
                        $result ='Mail Sent successfully!'; 
                       }	else{
                        $result ='Mail Not Sent'; 
                       }		
    return redirect('/empview/'.$id)->with('info',$result);
}else{
    return redirect('/empview/'.$id)->with('info','This Employee doesnot have remuneration details. Fill those details first.');
}
    }

   

}