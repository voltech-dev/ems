<?php
namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Imports\EmpImport;
use App\Models\Authorities;
use App\Models\Dtssp;
use App\Models\EmpBankdetails;
use App\Models\EmpDetails;
use App\Models\EmpRemunerationDetails;
use App\Models\EmpStaffPayScales;
use App\Models\EmpStatutorydetails;
use App\Models\Locations;
use App\Models\ProjectDetails;
use App\Models\Qualifications;
use App\Models\Educations;
use App\Models\Certificates;
use App\Models\Documents;
use App\Models\Statuses;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmpExport;
use Illuminate\Support\Facades\Storage;
use PDF;
use App\Models\CheckList;
use App\Models\LeaveBalance;

class EmpDetailsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return view('empdetails.index');
    }

    public function leavebalance(Request $request)
    {
        return view('empdetails.leavebalance',[
            'model'=>LeaveBalance::all()
        ]);
    }
    public function leavereset(Request $request)
    {
        LeaveBalance::truncate();
        $emps = EmpDetails::where(['status_id'=>1])->get(); 
        foreach( $emps as  $emp){
            $lc = new LeaveBalance();
            $lc->emp_id = $emp->id;
            $lc->days = 30;
            $lc->save();
        }
        return redirect('/leavebalance');
    }

    public function lbdata(Request $request)
    {

        $jointable =
            [
            ['table' => 'emp_details AS a', 'on' => 'a.id=master.emp_id', 'join' => 'JOIN'],
            ['table' => 'project_details AS b', 'on' => 'a.project_id=b.id', 'join' => 'JOIN'],
            ['table' => 'designations AS c', 'on' => 'a.designation_id=c.id', 'join' => 'JOIN'],           
        ];
        $columns = [
            ['db' => 'master.id', 'dt' => 0, 'field' => 'id', 'as' => 'slno'],
            ['db' => 'a.emp_code', 'dt' => 1, 'field' => 'emp_code'],
            ['db' => 'a.emp_name', 'dt' => 2, 'field' => 'emp_name'],          
            ['db' => 'c.designation_name', 'dt' => 3, 'field' => 'designation_name'],
            ['db' => 'b.project_name', 'dt' => 4, 'field' => 'project_name'],
            ['db' => 'master.days', 'dt' => 5, 'field' => 'days'],
            ['db' => 'master.id', 'dt' => 6, 'field' => 'id'],

        ];
        // $where = 'status=>Entry Completed';
        echo json_encode(
            Dtssp::simple($_GET, 'leave_balance AS master', 'master.id', $columns, $jointable, $where = null)
        ); 

    }

    public function lbedit(Request $request,$id)
    {
        if ($request->isMethod('post')) {
            $lbupdate = LeaveBalance::findOrFail($id);
            $lbupdate->days = $request->balance_leave;
            $lbupdate->save();
            return redirect('/leavebalance');
        } else {
            return view('empdetails.lbedit',[
                'model'=>LeaveBalance::findOrFail($id)
            ]);
        }       

    }

    public function create(Request $request)
    {
        return view('empdetails.add', [
            [],
        ]);
    }

    public function edit(Request $request, $id)
    {
        $emp = EmpDetails::findOrFail($id);
        return view('empdetails.edit', [
            'model' => $emp]);
    }

    public function export()
    {
        return Excel::download(new EmpExport, 'users.xlsx');
    }

    public function show(Request $request, $id)
    {
        $emp = EmpDetails::findOrFail($id);
        return view('empdetails.show', [
            'model' => $emp]);
    }

    public function viewdata(Request $request)
    {

        $jointable =
            [
            ['table' => 'project_details AS b', 'on' => 'a.project_id=b.id', 'join' => 'JOIN'],
            ['table' => 'designations AS c', 'on' => 'a.designation_id=c.id', 'join' => 'JOIN'],
            ['table' => 'locations AS d', 'on' => 'a.location_id=d.id', 'join' => 'LEFT JOIN'],
        ];
        $columns = [
            ['db' => 'a.id', 'dt' => 0, 'field' => 'id', 'as' => 'slno'],
            ['db' => 'a.emp_code', 'dt' => 1, 'field' => 'emp_code'],
            ['db' => 'a.emp_name', 'dt' => 2, 'field' => 'emp_name'],
            ['db' => 'a.mail', 'dt' => 3, 'field' => 'mail'],
            ['db' => 'c.designation_name', 'dt' => 4, 'field' => 'designation_name'],
            ['db' => 'b.project_name', 'dt' => 5, 'field' => 'project_name'],
         //   ['db' => 'd.location', 'dt' => 6, 'field' => 'location', 'as' => 'location'],

            ['db' => 'a.id', 'dt' => 6, 'field' => 'id'],

        ];
        // $where = 'status=>Entry Completed';
        echo json_encode(
            Dtssp::simple($_GET, 'emp_details AS a', 'a.id', $columns, $jointable, $where = null)
        ); 

    }
	
    public function update(Request $request, $id)
    {

        $emp_update = EmpDetails::find($request->empid);

        $emp_update->emp_code = $request->emp_code;
        $emp_update->emp_name = $request->emp_name;
        $emp_update->gender = $request->gender;
        $emp_update->designation_id = $request->designation;
        $emp_update->project_id = $request->project_id;
        $emp_update->location_id = $request->location_id;
		$emp_update->office_location = $request->office_location;
        $emp_update->mail = $request->email;
		$emp_update->email_personal = $request->email_personal;
        $emp_update->mobile = $request->mobile;
        $emp_update->blood_group = $request->blood;
        if($request->dob)
        $emp_update->date_of_birth = date('Y-m-d', strtotime($request->dob));
        if($request->doj)
        $emp_update->date_of_joining = date('Y-m-d', strtotime($request->doj));
        if($request->dol)
        $emp_update->date_of_leaving = date('Y-m-d', strtotime($request->dol));
        if($request->lad)
        $emp_update->last_appraisal_date = date('Y-m-d', strtotime($request->lad));
	    if($request->appraisal_due_date)
        $emp_update->appraisal_due_date = date('Y-m-d', strtotime($request->appraisal_due_date));
		if($request->date_of_offer)
        $emp_update->date_of_offer = date('Y-m-d', strtotime($request->date_of_offer));
	   if($request->offer_accepted)
        $emp_update->offer_accepted = date('Y-m-d', strtotime($request->offer_accepted));
        
        $emp_update->address_1 = $request->address_1;
        $emp_update->address_2 = $request->address_2;
        $emp_update->address_3 = $request->address_3;
        $emp_update->address_4 = $request->address_4;
        $emp_update->address_5 = $request->address_5;
        $emp_update->address_6 = $request->address_6;
        $emp_update->address_7 = $request->address_7;
        $emp_update->address_8 = $request->address_8;
        $emp_update->status_id = $request->status_id;
		
		 if ($request->hasFile('file_upload')) {
        
        if (Storage::exists(storage_path().'/employee/'. $request->emp_code))
        {
           
            Storage::delete(storage_path(). '/employee/'. $request->emp_code);
        }

        $filenameWithExt = $request->file('file_upload');
        $empname = $request->emp_code;
        $filename = pathinfo($empname, PATHINFO_FILENAME);
        $extension = $request->file('file_upload')->getClientOriginalExtension();
        $fileNameToStore = $filename  . '.' . $extension;
        $path = $request->file('file_upload')->storeAs('/public/employee/', $fileNameToStore);
        $emp_update->photo = $fileNameToStore;

		 }
     

        if ($emp_update->save()) {
            return redirect('/remunerationedit/' . $emp_update->id);

        }
    }

    public function store(Request $request)
    {
        $Empdet = new EmpDetails;

        $this->validate($request, [
            'emp_code' => 'required',
            'emp_name' => 'required',
            'project_id' => 'required',
           // 'location_id' => 'required',
            'email' => 'required|email',
            
        ]);

        $Empdet->emp_code = $request->emp_code;
        $Empdet->emp_name = $request->emp_name;
        $Empdet->gender = $request->gender;
        $Empdet->designation_id = $request->designation;
        $Empdet->project_id = $request->project_id;
        $Empdet->location_id = $request->location_id;
        $Empdet->mail = $request->email;
		$Empdet->email_personal = $request->email_personal;
        $Empdet->mobile = $request->mobile;
        $Empdet->blood_group = $request->blood;

        if($request->dob)
        $Empdet->date_of_birth = date('Y-m-d', strtotime($request->dob));
        if($request->doj)
        $Empdet->date_of_joining = date('Y-m-d', strtotime($request->doj));
        if($request->dol)
        $Empdet->date_of_leaving = date('Y-m-d', strtotime($request->dol));
        if($request->lad)
        $Empdet->last_appraisal_date = date('Y-m-d', strtotime($request->lad));
		if($request->appraisal_due_date)
        $Empdet->appraisal_due_date = date('Y-m-d', strtotime($request->appraisal_due_date));
		if($request->date_of_offer)
        $Empdet->date_of_offer = date('Y-m-d', strtotime($request->date_of_offer));
	    if($request->offer_accepted)
        $Empdet->offer_accepted = date('Y-m-d', strtotime($request->offer_accepted));
	
        $Empdet->address_1 = $request->address_1;
        $Empdet->address_2 = $request->address_2;
        $Empdet->address_3 = $request->address_3;
        $Empdet->address_4 = $request->address_4;
        $Empdet->address_5 = $request->address_5;
        $Empdet->address_6 = $request->address_6;
        $Empdet->address_7 = $request->address_7;
        $Empdet->address_8 = $request->address_8;
        $Empdet->status_id = $request->status_id;

		 if ($request->hasFile('file_upload')) {
        
            $filenameWithExt = $request->file('file_upload');
            $empname = $request->emp_code;
            $filename = pathinfo($empname, PATHINFO_FILENAME);
            $extension = $request->file('file_upload')->getClientOriginalExtension();
            $fileNameToStore = $filename  . '.' . $extension;
            $path = $request->file('file_upload')->storeAs('/public/employee/', $fileNameToStore);
            $Empdet->photo = $fileNameToStore;
		 }
        if ($Empdet->save()) {
            $empid = EmpDetails::where('id', $Empdet->id)->first();
            return redirect('/remuneration/' . $empid->id);

        }

    }

    public function destroy(Request $request, $id)
    {

        $batch = Batch::findOrFail($id);

        $batch->delete();
        return "OK";

    }
	
	public function offerletter(Request $request, $id)
    {
		$Emp = EmpDetails::find($id);
		$headerHtml = view()->make('empdetails.header')->render();
        $footerHtml = view()->make('empdetails.footer')->render();
		 $options = [
            'orientation' => 'portrait',
            'encoding' => 'UTF-8', 
			'header-html' => $headerHtml,
            'footer-html' => $footerHtml,	
        ];
        $pdf = PDF::loadView('empdetails.offerletter', [
            'model' => $Emp,          
        ]);
		 $pdf->setOptions($options);
		return $pdf->inline($Emp->emp_name.'.pdf');       
    }
	
	public function checklist(Request $request,$id)
    {
	   $chk = CheckList::where(['emp_id'=>$id])->first(); 
        return view('empdetails.checklist',[
		'emp_id'=>$id,
		'chk'=>$chk,
		]);
    }
	
	public function checklist_edit(Request $request,$id)
    {
	   $chk = CheckList::where(['emp_id'=>$id])->first(); 
        return view('empdetails.checklist_edit',[
		'emp_id'=>$id,
		'chk'=>$chk,
		]);
    }
	
	public function chklststore(Request $request)
    {
	
	if (CheckList::where(['emp_id'=>$request->emp_id])->exists()) {
    $chk = CheckList::where(['emp_id'=>$request->emp_id])->first(); 
	} else {
	 $chk = new CheckList(); 
	}
   
	$chk->emp_id = $request->emp_id;
	$chk->resume = $request->resume;
	$chk->evaluation = $request->evaluation;
	$chk->application = $request->application;
	$chk->ctc = $request->ctc;
	$chk->edu = $request->edu;
	$chk->exp = $request->exp;
	$chk->relieving = $request->relieving;
	$chk->payslip = $request->payslip;
	$chk->adhar = $request->adhar;
	$chk->pan = $request->pan;
	$chk->passbook = $request->passbook;
	$chk->cheque = $request->cheque;
	$chk->passport = $request->passport;
	$chk->save();
	//return redirect('empdetails.checklist');
	 return redirect('/checklist/' . $request->emp_id);
    }

    ################ Project  ##############

    public function projectcreation(Request $request)
    {

        return view('Project.projectcreation', [

        ]);
    }
    public function projectstore(Request $request)
    {
        $project = new ProjectDetails();
        $project->project_name = $request->project_name;
        $project->save();

        return view('Project.projectlist', [

        ]);
    }
    public function projectlist(Request $request)
    {
        return view('Project.projectlist', [
        ]);

    }

    public function projectdata(Request $request)
    {
        $columns = [
            ['db' => 'id', 'dt' => 0],
            ['db' => 'project_name', 'dt' => 1],

        ];
        // $where = 'status=>Entry Completed';
        echo json_encode(
            Dtssp::simple($_GET, 'project_details', 'id', $columns, $jointable = null, $where = null)
        );

    }
    public function projectedit(Request $request, $id)
    {
        $project = ProjectDetails::findOrFail($id);
        return view('Project.projectedit', [
            'model' => $project]);
    }

    public function projectupdate(Request $request, $id)
    {
        $project_update = ProjectDetails::find($request->id);
        $project_update->project_name = $request->project_name;
        $project_update->save();

        return view('Project.projectlist', [

        ]);
    }

    ############  location  #########

    public function locationcreation(Request $request)
    {

        return view('Location.locationcreation', [

        ]);
    }

    public function locationlist(Request $request)
    {
        return view('Location.locationlist', [
        ]);

    }

    public function locationdata(Request $request)
    {
        $columns = [
            ['db' => 'id', 'dt' => 0],
            ['db' => 'location', 'dt' => 1],

        ];
        // $where = 'status=>Entry Completed';
        echo json_encode(
            Dtssp::simple($_GET, 'locations', 'id', $columns, $jointable = null, $where = null)
        );

    }

    public function locationstore(Request $request)
    {
        $location = new Locations();
        $location->location = $request->location_name;
        $location->save();

        return view('Location.locationlist', [

        ]);
    }

    public function locationedit(Request $request, $id)
    {
        $location = Locations::findOrFail($id);
        return view('Location.locationedit', [
            'model' => $location]);
    }

    public function locationupdate(Request $request, $id)
    {
        $location_update = Locations::find($request->id);
        $location_update->location = $request->location_name;
        $location_update->save();

        return view('Location.locationlist', [

        ]);
    }
	
	############# Qualification  ############
public function qualificationcreation(Request $request)
{

    return view('empdetails.qualificationcreation', [

    ]);
}

public function qualificationstore(Request $request)
{
    $qualification = new Qualifications();
    $qualification-> qualification_name = $request->quali_name;
    $qualification->save();

    return view('empdetails.qualificationlist', [

    ]);
}

public function qualificationlist(Request $request)
    {
        return view('empdetails.qualificationlist', [
        ]);

    }

    public function qualificationdata(Request $request)
    {
        $columns = [
            ['db' => 'id', 'dt' => 0],
            ['db' => 'qualification_name', 'dt' => 1],

        ];
        // $where = 'status=>Entry Completed';
        echo json_encode(
            Dtssp::simple($_GET, 'qualifications', 'id', $columns, $jointable = null, $where = null)
        );

    }


    public function qualificationedit(Request $request, $id)
    {
        $quali_edit = Qualifications::findOrFail($id);
        return view('empdetails.qualificationedit', [
            'model' => $quali_edit]);
    }

    public function qualificationupdate(Request $request, $id)
    {
        $qualification_update = Qualifications::find($request->id);
        $qualification_update->qualification_name = $request->quali_name;
        $qualification_update->save();

        return view('empdetails.qualificationlist', [

        ]);
    }

############## status ####################

    public function statuslist(Request $request)
    {
        return view('Project.statuslist', [
        ]);

    }

    public function statusdata(Request $request)
    {
        $columns = [
            ['db' => 'id', 'dt' => 0],
            ['db' => 'status', 'dt' => 1],

        ];
        // $where = 'status=>Entry Completed';
        echo json_encode(
            Dtssp::simple($_GET, 'statuses', 'id', $columns, $jointable = null, $where = null)
        );

    }

    public function statuscreation(Request $request)
    {

        return view('Project.statuscreation', [

        ]);
    }

    public function statusstore(Request $request)
    {
        $status = new Statuses();
        $status->status = $request->status;
        $status->save();

        return view('Project.statuslist', [

        ]);
    }

    public function statusedit(Request $request, $id)
    {
        $status_edit = Statuses::findOrFail($id);
        return view('Project.statusedit', [
            'model' => $status_edit]);
    }

    public function statusupdate(Request $request, $id)
    {
        $status_update = Statuses::find($request->id);
        $status_update->status = $request->status;
        $status_update->save();

        return view('Project.statuslist', [

        ]);
    }

############## Authority ####################

    public function authoritylist(Request $request)
    {
        return view('Project.authoritylist', [
        ]);

    }

    public function authoritydata(Request $request)
    {
        $columns = [
            ['db' => 'id', 'dt' => 0],
            ['db' => 'authority_name', 'dt' => 1],

        ];
        // $where = 'status=>Entry Completed';
        echo json_encode(
            Dtssp::simple($_GET, 'authorities', 'id', $columns, $jointable = null, $where = null)
        );

    }

    public function authoritycreation(Request $request)
    {

        return view('Project.authoritycreation', [

        ]);
    }

    public function authoritystore(Request $request)
    {
        $auth = new Authorities();
        $auth->authority_name = $request->authority_name;
        $auth->save();

        return view('Project.authoritylist', [

        ]);
    }

    public function authorityedit(Request $request, $id)
    {
        $auth_edit = Authorities::findOrFail($id);
        return view('Project.authorityedit', [
            'model' => $auth_edit]);
    }

    public function authorityupdate(Request $request, $id)
    {
        $auth_update = Authorities::find($request->id);
        $auth_update->authority_name = $request->authority_name;
        $auth_update->save();

        return view('Project.authoritylist', [

        ]);
    }

########### Remuneration #################
    public function remuneration(Request $request, $id)
    {
        $emp_id = EmpDetails::findOrFail($id);
        return view('empdetails.remuneration', ['model' => $emp_id]);
    }

    public function remunerationedit(Request $request, $id)
    {
        $emp_id = EmpDetails::findOrFail($id);
        if(EmpRemunerationDetails::where(['empid'=>$id])->exists()){           
            return view('empdetails.remunerationedit', ['model' => $emp_id]);
        } else {
            return view('empdetails.remuneration', ['model' => $emp_id]);
        }       
    }

    public function salarystructure(Request $request)
    {
        $post = $request->all();

        $PayScale = EmpStaffPayScales::where(['salarystructure' => $post['sla_structure']])->first();

        $grossamount = $post['amount'];
        $basic = round($grossamount * $PayScale->basic);
        $hra = round($grossamount * $PayScale->hra);  
        $conveyance_allowance = round($PayScale->conveyance_allowance);
        $spl_allowance = round($grossamount - ($basic + $hra + $conveyance_allowance));
       
        echo json_encode(['basic' => $basic, 'hra' => $hra,  'ca' => $conveyance_allowance, 'spl' => $spl_allowance]);
      
    }

    public function remunerationstore(Request $request)
    {
        $remuneration = new EmpRemunerationDetails();

        $this->validate($request, [
            'salary_structure' => 'required',
            'gross_salary' => 'required',

        ]);

        $remuneration->empid = $request->empid;
        $remuneration->salary_structure = $request->salary_structure;
        $remuneration->esi_applicability = $request->esi_applicability;
        $remuneration->pf_applicablity = $request->pf_applicablity;
        $remuneration->restrict_pf = $request->restrict_pf;
        $remuneration->basic = $request->basic;
        $remuneration->hra = $request->hra;
        $remuneration->splallowance = $request->splallowance;       
        $remuneration->conveyance = $request->conveyance;
        $remuneration->education = $request->education;
        $remuneration->medical = $request->medical;
               
        $remuneration->gross_salary = $request->gross_salary;

        if ($remuneration->save()) {

            return redirect('/statutory/' . $request->empid);
        }
    }

    public function remunerationeditstore(Request $request)
    {
        $remuneration_edit = EmpRemunerationDetails::where(['empid' => $request->empid])->first();

        $this->validate($request, [
            'salary_structure' => 'required',
            'gross_salary' => 'required',

        ]);
        $remuneration_edit->salary_structure = $request->salary_structure;
        $remuneration_edit->esi_applicability = $request->esi_applicability;
        $remuneration_edit->pf_applicablity = $request->pf_applicablity;
        $remuneration_edit->restrict_pf = $request->restrict_pf;
        $remuneration_edit->basic = $request->basic;
        $remuneration_edit->hra = $request->hra;
        $remuneration_edit->splallowance = $request->splallowance;
      
       
        $remuneration_edit->medical = $request->medical;
        $remuneration_edit->conveyance = $request->conveyance;
        $remuneration_edit->education = $request->education;
           
        $remuneration_edit->gross_salary = $request->gross_salary;
        if ($remuneration_edit->save()) {
            return redirect('/statutoryedit/' . $request->empid);
        }
    }

############### Statutory Details ##############
    public function statutory(Request $request, $id)
    {
        $emp_id = EmpDetails::findOrFail($id);
        return view('empdetails.statutory_details', ['model' => $emp_id]);
    }

    public function statutorystore(Request $request)
    {
        $statutory = new EmpStatutorydetails();
        $statutory->empid = $request->empid;
        $statutory->esino = $request->esino;
        $statutory->esidispensary = $request->esidispensary;
        $statutory->epfno = $request->epfno;
        $statutory->epfuanno = $request->epfuanno;
        $statutory->professionaltax = $request->professionaltax;
        $statutory->gpa = $request->gpano;
        $statutory->gmc = $request->gmcno;
		$statutory->gpa_agency = $request->gpa_agency;
        $statutory->gmc_agency = $request->gmc_agency;
        if ($statutory->save()) {
            return redirect('/bank/' . $request->empid);
        }

    }

    public function statutoryedit(Request $request, $id)
    {
        $emp_id = EmpDetails::findOrFail($id);
        if(EmpStatutorydetails::where(['empid'=>$id])->exists()){ 
            return view('empdetails.statutory_edit', ['model' => $emp_id]);  
        }else {
            return view('empdetails.statutory_details', ['model' => $emp_id]);
        }
      
    }

    public function statutoryeditstore(Request $request)
    {
        $statutory_edit = EmpStatutorydetails::where(['empid' => $request->empid])->first();
        //$statutory->empid = $request->empid;
        $statutory_edit->esino = $request->esino;
        $statutory_edit->esidispensary = $request->esidispensary;
        $statutory_edit->epfno = $request->epfno;
        $statutory_edit->epfuanno = $request->epfuanno;
        $statutory_edit->professionaltax = $request->professionaltax;
        $statutory_edit->gpa = $request->gpano;
        $statutory_edit->gmc = $request->gmcno;
		$statutory_edit->gpa_agency = $request->gpa_agency;
        $statutory_edit->gmc_agency = $request->gmc_agency;
        if ($statutory_edit->save()) {
            return redirect('/bankedit/' . $request->empid);
        }

    }

    ############### Bank Details ##############

    public function bank(Request $request, $id)
    {
        $emp_id = EmpDetails::findOrFail($id);
        return view('empdetails.bankdetails', ['model' => $emp_id]);
    }

    public function bankstore(Request $request)
    {
        $banks = new EmpBankdetails();
        $banks->empid = $request->empid;
        $banks->bankname = $request->bankname;
        $banks->acnumber = $request->acnumber;
        $banks->branch = $request->branch;
        $banks->ifsc = $request->ifsc;

        if ($banks->save()) {

            return redirect('/education/' . $request->empid);
        }

    }
    public function bankedit(Request $request, $id)
    {
        $emp_id = EmpDetails::findOrFail($id);
        if(EmpBankdetails::where(['empid'=>$id])->exists()){ 
            return view('empdetails.bankdetails_edit', ['model' => $emp_id]);
        } else {
            return view('empdetails.bankdetails', ['model' => $emp_id]);
        }
        
    }

    public function bankeditstore(Request $request)
    {
        $banks_edit = EmpBankdetails::where(['empid' => $request->empid])->first();
        $banks_edit->empid = $request->empid;
        $banks_edit->bankname = $request->bankname;
        $banks_edit->acnumber = $request->acnumber;
        $banks_edit->branch = $request->branch;
        $banks_edit->ifsc = $request->ifsc;

        if ($banks_edit->save()) {

             return redirect('/educationedit/' . $request->empid);
        }

    }
	
	 ########### Education ############

    public function education(Request $request, $id)
    {
        $emp_id = EmpDetails::findOrFail($id);
        return view('empdetails.education', ['model' => $emp_id]);
    }

    public function educationstore(Request $request)
    {
        $education = new Educations();
        $education->empid = $request->empid;
        $education->qualification = $request->qualification;
        $education->board = $request->board;
        $education->institute = $request->institute;
        $education->year_of_passing = $request->yop;

        if ($education->save()) {

            return redirect('/certificate/' . $request->empid);
        }

    }

    public function educationedit(Request $request, $id)
    {
        $emp_id = EmpDetails::findOrFail($id);
        if(Educations::where(['empid'=>$id])->exists()){ 
            return view('empdetails.educationedit', ['model' => $emp_id]);
        } else {
            return view('empdetails.education', ['model' => $emp_id]);
        }
        
    }

    public function educationeditstore(Request $request)
    {
        $education_edit = Educations::where(['empid' => $request->empid])->first();
        $education_edit->empid = $request->empid;
        $education_edit->qualification = $request->qualification;
        $education_edit->board = $request->board;
        $education_edit->institute = $request->institute;
        $education_edit->year_of_passing = $request->yop;

        if ($education_edit->save()) {

            return redirect('/certificateedit/' . $request->empid);
        }

    }


    ########### End Education ########


    ########### Certificates #########
    public function certificate(Request $request, $id)
    {
        $emp_id = EmpDetails::findOrFail($id);
        return view('empdetails.certificate', ['model' => $emp_id]);
    }

    public function certificatestore(Request $request)
    {
        $certificate = new Certificates();
        $certificate->empid = $request->empid;
        $certificate->certificate_name = $request->certificate_name;
        $certificate->certificate_no = $request->certificate_no;
        $certificate->issue_authority = $request->issue_authority;
       
        if ($certificate->save()) {

            return redirect('empdetails');
        }

    }

    public function certificateedit(Request $request, $id)
    {
        $emp_id = EmpDetails::findOrFail($id);
        if(Certificates::where(['empid'=>$id])->exists()){ 
            return view('empdetails.certificateedit', ['model' => $emp_id]);
        } else {
            return view('empdetails.certificate', ['model' => $emp_id]);
        }
        
    }

    
    public function certificateeditstore(Request $request)
    {
        $certificate_edit = Certificates::where(['empid' => $request->empid])->first();
        $certificate_edit->empid = $request->empid;
        $certificate_edit->certificate_name = $request->certificate_name;
        $certificate_edit->certificate_no = $request->certificate_no;
        $certificate_edit->issue_authority = $request->issue_authority;
       
        if ($certificate_edit->save()) {

            return redirect('empdetails');
        }

    }

    ########## End Certificates ########
	
	  ########## emp file ###############

    public function empfile(Request $request, $id)
    {
        $emp_id = EmpDetails::findOrFail($id);
        return view('empdetails.empfile', ['model' => $emp_id]);
    }
     

    public function empfilestore(Request $request){
        $request->validate([
            'document_type' => 'required',
        ]);

        if ($request->hasFile('file_upload')) {
        
            
            $filenameWithExt = $request->file('file_upload')->getClientOriginalName();
            //$empname = $request->emp_code;
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file_upload')->getClientOriginalExtension();
            $fileNameToStore = $filename  . '.' . $extension;
            $path = $request->file('file_upload')->storeAs('/public/employee/', $fileNameToStore);
            $Empfile = new Documents;
            $Empfile->empid=$request->empid;
            $Empfile->document_name = $fileNameToStore;
            $Empfile->document_type = $request->document_type;
            
         }
         if($Empfile->save()){
            return redirect('empdetails');
         }

    }

    ########## end file ###############

    public function empview(Request $request, $id)
    {
        $emp_id = EmpDetails::findOrFail($id);
        return view('empdetails.emp_detailsview', ['model' => $emp_id]);
    }

    public function importExportView()
    {
        return view('empdetails.import');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
  

    /**
     * @return \Illuminate\Support\Collection
     */
    public function import(Request $request)
    {
        /*$path1 = $request->file('file')->store('temp');
        $path=storage_path('app').'/'.$path1;
        $data = \Excel::import(new UsersImport,$path);*/

        Excel::import(new UsersImport, request()->file('file'));

        return back();
    }
   
    public function ImportEmployee(Request $request)
    {
        if ($request->isMethod('post')) {
            if (Excel::import(new EmpImport, request()->file('file_upload'))) {
                return redirect()->back()->with(['status' => 'success']);
            }
        } else {
            return view('employee.employeeupload');
        } 
    }

}