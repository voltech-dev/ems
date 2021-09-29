<?php
namespace App\Http\Controllers;

use App\Exports\SalTemplate;
use App\Exports\AppraisalTemplate;
use App\Exports\LeaveBalanceTemplate;
use App\Exports\SalaryStatementExport;
use App\Exports\BankRemittanceExport;
use App\Exports\BankRemittanceExportAll;
use App\Exports\EPFRemittanceExportAll;
use App\Exports\SalaryStatementExportAll;
use App\Exports\ESIRemittanceExportAll;
use App\Exports\ESIRemittanceExport;
use App\Exports\EPFRemittanceExport;
use App\Import\SalTemplateImport;
use App\Import\AppraisalTemplateImport;
use App\Import\LeaveBalanceTemplateImport;
use App\Models\Dtssp;
use App\Models\EmpDetails;
use App\Models\EmpRemunerationDetails;
use App\Models\EmpSalary;
use App\Models\EmpSalaryActual;
use App\Models\EmpSalaryUploads;
use App\Models\EmpStatutorydetails;
use App\Models\SalaryMonths;
use App\Models\AppraisalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class EmpSalaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
      //  $salary = EmpSalary::all();
       // return view('empsalary.index',['salary'=>$salary]);
       return view('empsalary.index');
    }
    public function empsalaryclone(Request $request)
    {
        $empsalary = EmpSalary::get();
       return view('empsalary.salarystatement',['empsalary'=>$empsalary])->with('success','choose month and project');
    }
    public function bankremittance()
    {
        $empsalary = EmpSalary::get();    
       return view('Reports.bankremittance',['empsalary'=>$empsalary]);
    }
    public function epfremittance()
    {
        $empsalary = EmpSalary::get();    
       return view('Reports.epfremittance',['empsalary'=>$empsalary]);
    }
    public function esiremittance()
    {
        $empsalary = EmpSalary::get();    
       return view('Reports.esiremittance',['empsalary'=>$empsalary]);
    }
    public function salarystatementpost(Request $request)
    {
        $items[] = NULL;
        $project = $request->project_id;
        $month = $request->month;    
        $fdate = "01-".$month;
        $firstdate = date('Y-m-d',strtotime($fdate)); 
       // $today = \Carbon\Carbon::now(); //Current Date and Time
        $lastDayofMonth =    \Carbon\Carbon::parse($firstdate)->endOfMonth()->toDateString();
        $empdetails = EmpDetails::where('project_id','=',$project)->get();
        foreach($empdetails as $ee){
            $empsalary1 = EmpSalary::where(['empid'=>$ee->id])->whereBetween('month', [$firstdate,  $lastDayofMonth])->first();
           if($empsalary1){
               $items[] = $empsalary1->empid;
           }
        }
        $empsalary = EmpSalary::whereIn('empid',$items)->whereBetween('month', [$firstdate,  $lastDayofMonth])->get();
        return view('empsalary.salarystatement',['empsalary'=>$empsalary,'project'=>$project, 'month'=>$month]);      
    }
    public function bankremittancepost(Request $request)
    {
        $items[] = NULL;
        $project = $request->project_id;
        $month = $request->month;    
        $fdate = "01-".$month;
        $firstdate = date('Y-m-d',strtotime($fdate)); 
       // $today = \Carbon\Carbon::now(); //Current Date and Time
        $lastDayofMonth =    \Carbon\Carbon::parse($firstdate)->endOfMonth()->toDateString();
        $empdetails = EmpDetails::where('project_id','=',$project)->get();
        foreach($empdetails as $ee){
            $empsalary1 = EmpSalary::where(['empid'=>$ee->id])->whereBetween('month', [$firstdate,  $lastDayofMonth])->first();
           if($empsalary1){
               $items[] = $empsalary1->empid;
           }
        }
        $empsalary = EmpSalary::whereIn('empid',$items)->whereBetween('month', [$firstdate,  $lastDayofMonth])->get();
        return view('Reports.bankremittance',['empsalary'=>$empsalary,'project'=>$project, 'month'=>$month]);      
    }
    public function epfremittancepost(Request $request)
    {
        $items[] = NULL;
        $project = $request->project_id;
        $month = $request->month;    
        $fdate = "01-".$month;
        $firstdate = date('Y-m-d',strtotime($fdate)); 
       // $today = \Carbon\Carbon::now(); //Current Date and Time
        $lastDayofMonth =    \Carbon\Carbon::parse($firstdate)->endOfMonth()->toDateString();
        $empdetails = EmpDetails::where('project_id','=',$project)->get();
        foreach($empdetails as $ee){
            $empsalary1 = EmpSalary::where(['empid'=>$ee->id])->whereBetween('month', [$firstdate,  $lastDayofMonth])->first();
           if($empsalary1){
               $items[] = $empsalary1->empid;
           }
        }
        $empsalary = EmpSalary::whereIn('empid',$items)->whereBetween('month', [$firstdate,  $lastDayofMonth])->get();
        return view('Reports.epfremittance',['empsalary'=>$empsalary,'project'=>$project, 'month'=>$month]);      
    }
    public function esiremittancepost(Request $request)
    {
        $items[] = NULL;
        $project = $request->project_id;
        $month = $request->month;    
        $fdate = "01-".$month;
        $firstdate = date('Y-m-d',strtotime($fdate)); 
       // $today = \Carbon\Carbon::now(); //Current Date and Time
        $lastDayofMonth =    \Carbon\Carbon::parse($firstdate)->endOfMonth()->toDateString();
        $empdetails = EmpDetails::where('project_id','=',$project)->get();
        foreach($empdetails as $ee){
            $empsalary1 = EmpSalary::where(['empid'=>$ee->id])->whereBetween('month', [$firstdate,  $lastDayofMonth])->first();
           if($empsalary1){
               $items[] = $empsalary1->empid;
           }
        }
        $empsalary = EmpSalary::whereIn('empid',$items)->whereBetween('month', [$firstdate,  $lastDayofMonth])->get();
        return view('Reports.esiremittance',['empsalary'=>$empsalary,'project'=>$project, 'month'=>$month]);      
    }
    public function salarystatementexport($project,$month)
    {
  
        $fdate = "01-".$month;
        $firstdate = date('Y-m-d',strtotime($fdate)); 
        $lastDayofMonth =    \Carbon\Carbon::parse($firstdate)->endOfMonth()->toDateString();
       
       // $empdetails = EmpDetails::where('project_id','=',$project)->first();
       // $empsalary = EmpSalary::where(['empid'=>$empdetails->id])->whereBetween('month', [$firstdate,  $lastDayofMonth])->get();
      // return view('empsalary.salarystatement',['empsalary'=>$empsalary,'project'=>$project, 'month'=>$month]);      

        return Excel::download(new SalaryStatementExport($project,$firstdate,$lastDayofMonth,$month), 'salarystatement.xlsx');
    }
    public function salarystatementexports()
    {  
        $empsalary = EmpSalary::get();    
        return Excel::download(new SalaryStatementExportAll($empsalary), 'salarystatement.xlsx');
    }
    public function epfremittanceexports()
    {  
        $empsalary = EmpSalary::get();    
        return Excel::download(new EPFRemittanceExportAll($empsalary), 'EPF Remittance.xlsx');
    }
    public function esiremittanceexports()
    {  
        $empsalary = EmpSalary::get();    
        return Excel::download(new ESIRemittanceExportAll($empsalary), 'ESI.xlsx');
    }
    public function bankremittanceexports()
    {
        $empsalary = EmpSalary::get(); 
        return Excel::download(new BankRemittanceExportAll($empsalary), 'Bank Remittance.xlsx');
    }

    public function esiremittanceexport($project,$month)
    {
        $fdate = "01-".$month;
        $firstdate = date('Y-m-d',strtotime($fdate)); 
        $lastDayofMonth =    \Carbon\Carbon::parse($firstdate)->endOfMonth()->toDateString();
        return Excel::download(new ESIRemittanceExport($project,$firstdate,$lastDayofMonth,$month), 'ESI.xlsx');
    }
    public function bankremittanceexport($project,$month)
    {
        $fdate = "01-".$month;
        $firstdate = date('Y-m-d',strtotime($fdate)); 
        $lastDayofMonth =    \Carbon\Carbon::parse($firstdate)->endOfMonth()->toDateString();
        return Excel::download(new BankRemittanceExport($project,$firstdate,$lastDayofMonth,$month), 'Bank Remittance.xlsx');
    }
    public function epfremittanceexport($project,$month)
    {
        $fdate = "01-".$month;
        $firstdate = date('Y-m-d',strtotime($fdate)); 
        $lastDayofMonth =    \Carbon\Carbon::parse($firstdate)->endOfMonth()->toDateString();
        return Excel::download(new EPFRemittanceExport($project,$firstdate,$lastDayofMonth,$month), 'EPF Remittance.xlsx');
    }
    public function salarylist(Request $request)
    {
        $jointable =
            [
            ['table' => 'emp_details AS b', 'on' => 'a.empid=b.id', 'join' => 'JOIN'],
            ['table' => 'project_details AS c', 'on' => 'b.project_id=c.id', 'join' => 'JOIN'],
        ];
        $columns = [
            ['db' => 'a.id', 'dt' => 0, 'field' => 'id', 'as' => 'slno'],
            ['db' => 'b.emp_code', 'dt' => 1, 'field' => 'emp_code'],
            ['db' => 'b.emp_name', 'dt' => 2, 'field' => 'emp_name'],
            ['db' => 'c.project_name', 'dt' => 3, 'field' => 'project_name'],
            ['db' => 'a.paiddays', 'dt' => 4, 'field' => 'paiddays'],
            ['db' => 'a.gross', 'dt' => 5, 'field' => 'gross'],
            ['db' => 'a.total_earning', 'dt' => 6, 'field' => 'total_earning'],
            ['db' => 'a.total_deduction', 'dt' => 7, 'field' => 'total_deduction'],
            ['db' => 'a.net_amount', 'dt' => 8, 'field' => 'net_amount'],
            ['db' => 'a.earned_ctc', 'dt' => 9, 'field' => 'earned_ctc'],
            ['db' => 'a.id', 'dt' => 10, 'field' => 'id'],

        ];
       // $where = 'c.project_name = "'.$request->project.'"';
        echo json_encode(
            Dtssp::simple($_GET, 'emp_salaries AS a', 'a.id', $columns, $jointable, $where=null)
        );

    }
	 public function mailindex(Request $request)
    {
        return view('empsalary.mailindex');
    }
    public function appraisalrequestlist(Request $request)
    {

        $jointable =
            [
            ['table' => 'project_details AS b', 'on' => 'b.id=a.project_id', 'join' => 'JOIN'],
        ];
        $columns = [
            ['db' => 'a.id', 'dt' => 0, 'field' => 'id', 'as' => 'slno'],
            ['db' => 'a.emp_code', 'dt' => 1, 'field' => 'emp_code'],
            ['db' => 'a.emp_name', 'dt' => 2, 'field' => 'emp_name'],
            ['db' => 'b.project_name', 'dt' => 3, 'field' => 'project_name'],
			['db' => 'a.last_appraisal_date', 'dt' => 4, 'field' => 'last_appraisal_date'],
        ];
		 $mailflag =Null;
        //$where = 'a.email_status is null';
        echo json_encode(
           // Dtssp::simple($_GET, 'emp_salaries AS a', 'a.id', $columns, $jointable, $where)
           Dtssp::simple($_GET, 'emp_details AS a', 'a.id', $columns, $jointable)
        );
    }
	 public function viewmaillist(Request $request)
    {

        $jointable =
            [
            ['table' => 'emp_details AS b', 'on' => 'a.empid=b.id', 'join' => 'JOIN'],
            ['table' => 'project_details AS c', 'on' => 'b.project_id=c.id', 'join' => 'JOIN'],
        ];
        $columns = [
            ['db' => 'a.id', 'dt' => 0, 'field' => 'id', 'as' => 'slno'],
            ['db' => 'b.emp_code', 'dt' => 1, 'field' => 'emp_code'],
            ['db' => 'b.emp_name', 'dt' => 2, 'field' => 'emp_name'],
            ['db' => 'c.project_name', 'dt' => 3, 'field' => 'project_name'],
			['db' => 'a.month', 'dt' => 4, 'field' => 'month', 
			'formatter' => function( $d, $row ) {
            return date( 'M y', strtotime($d));
			}],
            ['db' => 'a.paiddays', 'dt' => 5, 'field' => 'paiddays'],
            ['db' => 'a.gross', 'dt' => 6, 'field' => 'gross'],
            ['db' => 'a.total_earning', 'dt' => 7, 'field' => 'total_earning'],
            ['db' => 'a.total_deduction', 'dt' => 8, 'field' => 'total_deduction'],
            ['db' => 'a.net_amount', 'dt' => 9, 'field' => 'net_amount'],
            ['db' => 'a.earned_ctc', 'dt' => 10, 'field' => 'earned_ctc'],
            ['db' => 'a.id', 'dt' => 11, 'field' => 'id'],

        ];
		 $mailflag =Null;
        $where = 'a.email_status is null';
        echo json_encode(
            Dtssp::simple($_GET, 'emp_salaries AS a', 'a.id', $columns, $jointable, $where)
        );
    }
	
	
    public function show(Request $request, $id)
    {
        $salary = EmpSalary::findOrFail($id);
        $actual = EmpSalaryActual::where(['empid'=>$salary->empid])->first();
        return view('empsalary.show', [
            'model' => $salary,
            'actual' => $actual
            ]);
    }

    public function generate(Request $request)
    {
        return view('empsalary.generateindex');
    }

    public function viewgeneratelist(Request $request)
    {
        $jointable =
            [
            ['table' => 'emp_details AS b', 'on' => 'a.empid=b.id', 'join' => 'JOIN'],
            ['table' => 'project_details AS c', 'on' => 'b.project_id=c.id', 'join' => 'JOIN'],
        ];
        $columns = [
            ['db' => 'b.id', 'dt' => 0, 'field' => 'id'],
            ['db' => 'b.emp_code', 'dt' => 1, 'field' => 'emp_code'],
            ['db' => 'b.emp_name', 'dt' => 2, 'field' => 'emp_name'],
            ['db' => 'c.project_name', 'dt' => 3, 'field' => 'project_name'],
            ['db' => 'a.leavedays', 'dt' => 4, 'field' => 'leavedays'],
            ['db' => 'a.lop_days', 'dt' => 5, 'field' => 'lop_days'],
            ['db' => 'a.conveyance', 'dt' => 6, 'field' => 'conveyance'],
            ['db' => 'a.laptop', 'dt' => 7, 'field' => 'laptop'],
            ['db' => 'a.travel', 'dt' => 8, 'field' => 'travel'],
            ['db' => 'a.mobile', 'dt' => 9, 'field' => 'mobile'],
            ['db' => 'a.tds', 'dt' => 10, 'field' => 'tds'],
        ];
        $where = 'a.status="Uploaded"';
        echo json_encode(
            Dtssp::simple($_GET, 'emp_salary_uploads AS a', 'a.id', $columns, $jointable, $where)
        );
    }

    public function salaryprocess(Request $request)
    {
        $pf_rates = 12;
        $esi_rates = 0.75;
        $pf_emr_rates = 13;
        $esi_emr_rates = 3.25;
        foreach ($request->genIds as $key) {

            $employer_state_insurance = 0;
            $employee_state_insurance = 0;
            $provident_fund = 0;
            $provident_fund_emr = 0;
            $pf_wages = 0;
            $esi_wages = 0;
            $professional_tax = 0;

            $model = EmpSalaryUploads::where(['id' => $key])->first();
            $Emp = EmpDetails::where(['id' => $model->empid])->first();

            $remunerationmodel = EmpRemunerationDetails::where(['empid' => $Emp->id])->first();
            $statutory = EmpStatutorydetails::where(['empid' => $Emp->id])->first();

            $Actualcheck = EmpSalaryActual::Where(['empid' => $model->empid, 'month' => $model->month])->first();

            if ($Actualcheck) {
                $Actual = EmpSalaryActual::Where(['empid' => $model->empid, 'month' => $model->month])->first();
            } else {
                $Actual = new EmpSalaryActual();
            }

            $sal = EmpSalary::where(['empid' => $model->empid, 'month' => $model->month])->first();
            if ($sal) {
                $Salary = EmpSalary::where(['empid' => $model->empid, 'month' => $model->month])->first();
            } else {
                $Salary = new EmpSalary();
            }

            $m = date("m", strtotime($model->month));
            $y = date("Y", strtotime($model->month));
            $maxDays = cal_days_in_month(CAL_GREGORIAN, $m, $y);
            $present_days = $maxDays - $model->lop_days;
            $Salary->user = auth()->user()->id;
            $Salary->empid = $model->empid;
            $Salary->month = $model->month;
            $Salary->gross = $remunerationmodel->gross_salary;
            $Salary->paiddays = $present_days;
            $Salary->forced_lop = $model->lop_days;
            $Salary->basic = round(($remunerationmodel->basic / $maxDays) * $present_days);
            $Salary->hra = round(($remunerationmodel->hra / $maxDays) * $present_days);
            $Salary->conveyance_earning = round(($remunerationmodel->conveyance / $maxDays) * $present_days);
            $Salary->medical_earning = round(($remunerationmodel->medical / $maxDays) * $present_days);
            $Salary->education_earning = round(($remunerationmodel->education / $maxDays) * $present_days);
            $Salary->spl_allowance = round(($remunerationmodel->splallowance / $maxDays) * $present_days);
            $Salary->over_time = $model->over_time;
            $Salary->arrear = $model->arrear;
            $Salary->advance = $model->advance;
            $Salary->total_earning = round($Salary->basic + $Salary->hra + $Salary->conveyance_earning + $Salary->medical_earning + $Salary->spl_allowance + $Salary->over_time + $Salary->arrear + $Salary->advance);

            $pf_wages = round(($remunerationmodel->gross_salary / $maxDays) * $present_days) - $Salary->hra;
            if ($remunerationmodel->pf_applicablity == 'Yes') {
                if ($remunerationmodel->restrict_pf == 'Yes') {
                    if ($pf_wages > 15000) {
                        $provident_fund = round(15000 * ($pf_rates / 100));
                        $provident_fund_emr = round(15000 * ($pf_emr_rates / 100));
                    } else {
                        $provident_fund = round($pf_wages * ($pf_rates / 100));
                        $provident_fund_emr = round(15000 * ($pf_emr_rates / 100));
                    }
                } else {
                    $provident_fund = round($pf_wages * ($pf_rates / 100));
                    $provident_fund_emr = round(15000 * ($pf_emr_rates / 100));
                }
            }

            $Salary->pf = $provident_fund;
            $esi_wages = round((($remunerationmodel->gross_salary / $maxDays) * $present_days) + $Salary->over_time);
            if ($remunerationmodel->esi_applicability == 'Yes') {
                if ($remunerationmodel->gross_salary <= 21000) {
                    $employee_state_insurance = ceil(number_format(($esi_wages * ($esi_rates / 100)), 2, '.', ''));
                    $employer_state_insurance = ceil(number_format(($esi_wages * ($esi_emr_rates / 100)), 2, '.', ''));
                }
            }
            $Salary->esi = $employee_state_insurance;

            if ($statutory->professionaltax == 'Yes') {
                if ($remunerationmodel->gross_salary > 12500) {
                    $professional_tax = 209;
                } else if ($remunerationmodel->gross_salary <= 12500 && $remunerationmodel->gross_salary > 10000) {
                    $professional_tax = 171;
                } else if ($remunerationmodel->gross_salary <= 10000 && $remunerationmodel->gross_salary > 7500) {
                    $professional_tax = 115;
                } else if ($remunerationmodel->gross_salary <= 7500 && $remunerationmodel->gross_salary > 5000) {
                    $professional_tax = 53;
                } else if ($remunerationmodel->gross_salary <= 5000 && $remunerationmodel->gross_salary > 3500) {
                    $professional_tax = 23;
                } else {
                    $professional_tax = 0;
                }
            }
            $Salary->professional_tax = $professional_tax;
            $Salary->loan = $model->loan;
            $Salary->insurance = $model->insurance;
            $Salary->rent = $model->rent;
            $Salary->tds = $model->tds;
            $Salary->other_deduction = $model->others;
            $Salary->total_deduction = round($Salary->pf + $Salary->esi + $Salary->professional_tax + $Salary->loan + $Salary->insurance + $Salary->rent + $Salary->tds + $Salary->other_deduction);
            $Salary->conveyance_allowance = $model->conveyance;
            $Salary->laptop_allowance = $model->laptop;
            $Salary->travel_allowance = $model->travel;
            $Salary->mobile_allowance = $model->mobile;
            $Salary->net_amount = ($Salary->total_earning + $Salary->conveyance_allowance + $Salary->laptop_allowance + $Salary->travel_allowance + $Salary->mobile_allowance) - $Salary->total_deduction;
            $Salary->pf_employer_contribution = $provident_fund_emr;
            $Salary->esi_employer_contribution = $employer_state_insurance;

            $Salary->earned_ctc = $Salary->net_amount + $Salary->pf_employer_contribution + $Salary->esi_employer_contribution;
            $Salary->pf_wages = $pf_wages;
            $Salary->esi_wages = $esi_wages;
			$created_at = date('Y-m-d H:i:s');
			$Salary->email_hash = hash('ripemd128', $Salary->empid . $Salary->month . $created_at);
            $Salary->save();

            $Actual->empid = $Emp->id;
            $Actual->month = $model->month;
            $Actual->basic = $remunerationmodel->basic;
            $Actual->hra = $remunerationmodel->hra;
            $Actual->conveyance = $remunerationmodel->conveyance;
            $Actual->medical = $remunerationmodel->medical;
            $Actual->education = $remunerationmodel->education;
            $Actual->splallowance = $remunerationmodel->splallowance;
            $Actual->gross = $remunerationmodel->gross_salary;
            $Actual->save();

            $model->status = 'Salary Generated';
            $model->save();
            $result[] = 'Success';
        }

        return response()->json([
            'success' => $result,
        ]);

    }

    public function salarymonth(Request $request)
    {
        return view('empsalary.salary_month');
    }

    public function payslippdf(Request $request,$id)
    {
        $model = EmpSalary::findOrFail($id);
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

  

    public function monthstore(Request $request)
    {
        $month = '01-' . $request->sal_month;
        $currentmonth = date('Y-m-d', strtotime($month));

        $salarymonth = date('Y-m', strtotime($currentmonth));

        $salmonth = SalaryMonths::where(['month' => $currentmonth])->count();
        $uploadedmonth = EmpSalaryUploads::where(['status' => 'Uploaded'])->count();
        if ($uploadedmonth == 0 && $salmonth == 0) {
            $ModelEmp = EmpDetails::where(['status_id' => '1'])->get();
            foreach ($ModelEmp as $emp) {
                $empdojmonth = date('Y-m', strtotime($emp->doj));
                if ($empdojmonth <= $salarymonth) {
                    $modelupload = new EmpSalaryUploads;
                    $modelupload->empid = $emp->id;
                    $modelupload->month = date('Y-m-d', strtotime($month));
                    $modelupload->status = 'Uploaded';
                    $modelupload->save();
                }
            }
            $salmonth = new SalaryMonths;
            $salmonth->month = $currentmonth;
            $salmonth->save();
            return redirect()->back()->with(['status' => 'The Salary Month is Generated.']);
        } else {
            return redirect()->back()->with(['error' => 'Generate salary for Created month before create New Month']);
        }

    }
    public function salaryupload(Request $request)
    {
        return view('empsalary.salaryupload');
    }
    public function appraisalupload(Request $request)
    {
        return view('ProjectAppraisal.appraisalupload');
    }
    public function leavebalancetemplate(Request $request)
    {
        return view('employee.leavebalanceupload');
    }
    public function downloadleavebalancetemplate(Request $request)
    {
        $data = $request->all();
        return Excel::download(new LeaveBalanceTemplate($data), 'LeaveBalanceTemplate.xlsx');

    }
    public function downloadappraisaltemplate(Request $request)
    {
        $data = $request->all();
        return Excel::download(new AppraisalTemplate($data), 'AppraisalTemplate.xlsx');

    }
    public function downloadtemplate(Request $request)
    {
        $data = $request->all();
        return Excel::download(new SalTemplate($data), 'salaryTemplate.xlsx');

    }
    public function Importtemplate(Request $request)
    {
        $data = $request->all();
        if (Excel::import(new SalTemplateImport($data), request()->file('file_upload'))) {
            return redirect()->back()->with(['status' => 'success']);
        }

    }
    public function importappraisaltemplate(Request $request)
    {
        $data = $request->all();
        if (Excel::import(new AppraisalTemplateImport($data), request()->file('file_upload'))) {
            return redirect()->back()->with(['status' => 'success']);
        }

    }
    public function importleavebalancetemplate(Request $request)
    {
        $data = $request->all();
        if (Excel::import(new LeaveBalanceTemplateImport($data), request()->file('file_upload'))) {
            return redirect()->back()->with(['status' => 'success']);
        }

    }
    /*  appraisal request */
    public function appraisalrequest()
    {
        return view('AppraisalRequest.index');
    }
    public function appraisalrequestpost(Request $request)
    {       
		 foreach ($request->Ids as $key) {
		  $emp = EmpDetails::findOrFail($key); 
          $appraisalrequest = AppraisalRequest::updateOrCreate(['empid'=>$emp->id],['project_id' => $emp->project_id,'status' => "Requested"]);
          $result ='success';
		}		
	   return response()->json([
            'success' => $result,
        ]);
    }
    /* appraisal request end */
}
