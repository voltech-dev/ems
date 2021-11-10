<?php
namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Models\Authorities;
use App\Models\Dtssp;
use App\Models\EmpBankdetails;
use App\Models\EmpDetails;
use App\Imports\EmpImport;
use App\Models\EmpRemunerationDetails;
use App\Models\EmpStaffPayScales;
use App\Models\EmpStatutorydetails;
use App\Models\AppraisalRequest;
use App\Models\Locations;
use App\Models\ProjectDetails;
use App\Models\Designation;
use App\Models\Qualifications;
use App\Models\Educations;
use App\Models\Certificates;
use App\Models\Documents;
use App\Models\Statuses;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmpExport;
use App\Exports\CheckListExport;
use App\Exports\LeaveBalanceExport;
use Illuminate\Support\Facades\Storage;
use PDF;
use App\Models\CheckList;
use App\Models\LeaveBalance;
use App\Models\Personaldetails;
use App\Models\BackgroundVerifications;
use App\Models\Grievances;
use App\Models\Exits;
use App\Models\Providentfunddetails;
use App\Models\Esidetails;
use App\Models\Departments;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Mail;
use App\Traits\FilterTrait;
use App\Models\Doc_type;
use App\Models\Appraisals;
use App\Mail\ResignedMail;
use Response;
use DB;
use Hash;
use Auth;


class EmpDetailsController extends Controller
{
    use FilterTrait;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $data = $request->all();
        $query = EmpDetails::query();  
       $emp = $query->paginate(10);

        return view('empdetails.index', [
            'emp' => $emp,
            'data' => $data,
        ]);
    }
    public function fetchempdata(Request $request)
    {
        $data = $request->all();
        $query = EmpDetails::query();
        $params = $data['filter'];
        $per_page = 10;

        if(isset($data['extrafilter'])) {
           $this->filterOperation($data['extrafilter'],$query);           
        }  
      
        if(isset($data['filter'])) { 
          
            if (!is_null($params['1']['value'])) {
                $query->where('emp_name','like','%'.$params['1']['value'].'%');

            }

            // if (!is_null($params['2']['value'])) {
            //     $query->where('project_id', '=', $params['2']['value']);
            // }
        }
      // echo $leads = $query->toSql();
           $emp = $query->paginate($per_page);
            return view('layouts.emppaginationdata', compact(['emp', 'data']))->with('i', (request()->input('page', 1) - 1) * 10)->render();
       
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
            ['table' => 'statuses AS e', 'on' => 'a.status_id=e.id', 'join' => 'LEFT JOIN'],
        ];
        $columns = [
            ['db' => 'a.id', 'dt' => 0, 'field' => 'id', 'as' => 'slno'],
            ['db' => 'a.emp_code', 'dt' => 1, 'field' => 'emp_code'],
            ['db' => 'a.emp_name', 'dt' => 2, 'field' => 'emp_name'],
            ['db' => 'a.mail', 'dt' => 3, 'field' => 'mail'],
            ['db' => 'c.designation_name', 'dt' => 4, 'field' => 'designation_name'],
            ['db' => 'b.project_name', 'dt' => 5, 'field' => 'project_name'],
            ['db' => 'e.status', 'dt' => 6, 'field' => 'status', 'as' => 'status'],
            ['db' => 'a.id', 'dt' => 7, 'field' => 'id'],

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
        $emp_update->age = $request->age;
        $emp_update->years_of_experience = $request->years;
        $emp_update->department_id = $request->department;

        if($request->dob)
        $emp_update->date_of_birth = date('Y-m-d', strtotime($request->dob));
        if($request->doj)
        $emp_update->date_of_joining = date('Y-m-d', strtotime($request->doj));
        if($request->dojlt)
        $emp_update->date_of_joining_lt = date('Y-m-d', strtotime($request->dojlt));
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

        $resignedmail = DB::table('users')->where('emp_id',$request->empid)->first();
        if($resignedmail->email == ""){

        }else{
            if($request->status_id == "7"){
                $emails = ['hr.support@voltechgroup.com','raphealjerald.j@voltechgroup.com'];   
              // $emails = ['preethikrishnavel3092@gmail.com'];                 
                $loc = DB::table('locations')->where('id',$request->location_id)->first();
                $subject = 'Voltech HR Services';
                $details = '<b>'.$request->emp_name.'</b>'.' Resigned from '.'<b>'.$loc->location.'</br>'.' site on '. date('d-m-Y') . '. So, Employee official Mail ID has to be deactivated.';
                Mail::to($emails)->send(new ResignedMail($subject, $details));
                $userdeactivate = DB::table('users')->where('emp_id',$request->empid)->update(['email'=>'']);
            }
        }

        
		
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
         
         $users = DB::table('users')->where('emp_id',$request->empid)->exists();
         if($users){
            $users = DB::table('users')->where('emp_id',$request->empid)->update(['password'=>Hash::make($request->emp_code)]);
            //$users->password = Hash::make($request->emp_code);
           // $users->save();            
         }else{
         }


        if ($emp_update->save()) {
            return redirect('/remunerationedit/' . $emp_update->id);

        }
    }

    public function store(Request $request)
    {
        $Empdet = new EmpDetails;

        $this->validate($request, [
            'emp_code' => 'required|unique:emp_details|min:5',
            'emp_name' => 'required',
            'project_id' => 'required',
           // 'location_id' => 'required',
           // 'email' => 'required|email',
            
        ]);

        $Empdet->emp_code = $request->emp_code;        
        $Empdet->emp_name = $request->emp_name;        
        $Empdet->gender = $request->gender;        
        $Empdet->designation_id = $request->designation;
        $Empdet->project_id = $request->project_id;
        $Empdet->location_id = $request->location_id;
        $Empdet->office_location = $request->office_location;
        $Empdet->mail = $request->email;
		$Empdet->email_personal = $request->email_personal;
        $Empdet->mobile = $request->mobile;
        $Empdet->blood_group = $request->blood;
        $Empdet->age = $request->age;
        $Empdet->years_of_experience = $request->years;  
        $Empdet->department_id = $request->department;

        if($request->dob)
        $Empdet->date_of_birth = date('Y-m-d', strtotime($request->dob));        
        if($request->doj)
        $Empdet->date_of_joining = date('Y-m-d', strtotime($request->doj));
        if($request->dojlt)
        $Empdet->date_of_joining_lt = date('Y-m-d', strtotime($request->dojlt));
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
        
      // if($Empdet = EmpDetails::updateOrCreate(['emp_code'=>$request->emp_code])){
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
	
	public function offerletter(Request $request, $id,$empcode)
    {
        $date = date('Y-m-d');
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
       // Storage::put('public/offerletter/'.$empcode.'_'.$date.'.pdf', $pdf->output());
		 
    }
    public function renewalget(Request $request, $id)
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
        $pdf = PDF::loadView('empdetails.renewal', [
            'model' => $Emp,          
        ]);
		 $pdf->setOptions($options);
         return $pdf->inline($Emp->emp_name.'.pdf');   
	//	return view('empdetails.renewal', [
       //     'model' => $emp]); 
      //  $data = ['title' => 'Welcome to ItSolutionStuff.com'];

     //   $pdf = PDF::loadView('myPDF', $data);

  

       // return $pdf->download('itsolutionstuff.pdf');

       // return view('empdetails.renewal');
    }
    public function renewal(Request $request, $id)
    {
		$Emp = EmpDetails::find($id);
        // echo $Emp->emp_code;
        // echo $request->renewal_date;         
        // echo $curr_date = $request->current_date;
        
        $Emp->renewal_offer_date =  date('Y-m-d', strtotime($request->renewal_date));        
        $Emp->save();
		$headerHtml = view()->make('empdetails.header')->render();
        $footerHtml = view()->make('empdetails.footer')->render();
		 $options = [
            'orientation' => 'portrait',
            'encoding' => 'UTF-8', 
			'header-html' => $headerHtml,
            'footer-html' => $footerHtml,	
        ];
        $pdf = PDF::loadView('empdetails.renewal', [
            'model' => $Emp, 'date' => $curr_date ,   
        ]);
        Storage::put('public/renewalofferletter/'.$Emp->emp_code.'_'.'Renewal Offer Letter'.'.pdf', $pdf->output());
      //  exit;
      $data["email"] = $Emp->mail;              
      // $data["title"] = "Voltech HR Services"; 
      $data["title"] = "Renewal Offer Letter"; 
      $data["body"] = 'Dear Associate';
      $data["body1"] = 'Please find the renewal offer letter for your reference. Kindly send the signed copy of the renewal offer letter as an acknowledgment';

       $files = [str_replace('\\', '/', public_path('../storage/app/public/renewalofferletter/'.$Emp->emp_code.'_'.'Renewal Offer Letter'.'.pdf'))]; 
       Mail::send('emails.renewalofferletter', $data, function($message)use($data, $files) {
       // Mail::send(new OfferletterMail($details,$docname, $data, function($message)use($data, $files,$details)){
        $message->to($data["email"], $data["email"])->cc(['raphealjerald.j@voltechgroup.com','sanusha.ns@voltechgroup.com'])->subject($data["title"]);       
        foreach ($files as $file){
        $message->attach($file);
         }
        });
		$pdf->setOptions($options);
        return $pdf->inline($Emp->emp_name.'.pdf');    
    }
	
	public function checklist(Request $request,$id)
    {
    $doc = Doc_type::all();
	    $chk = CheckList::where(['emp_id'=>$id])->first(); 
        return view('empdetails.checklist',[
		'emp_id'=>$id,'chk'=>$chk,'docs'=>$doc]);
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
    $chk->epf = $request->epf;
	$chk->mis = $request->mis;
	$chk->pcc = $request->pcc;
	$chk->aup = $request->aup;
	$chk->nda = $request->nda;
	$chk->sol = $request->sol;
	$chk->report = $request->report;
	$chk->id_card = $request->id;

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
        $project = ProjectDetails::paginate(10);
        return view('Project.projectlist',compact('project'))
        ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function projectdelete(Request $request,$id)
    {
        $project = ProjectDetails::where('id',$id)->first();
        $project->delete();
        return back();

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

        // return view('Project.projectlist', [

        // ]);
        $project = ProjectDetails::paginate(10);
        return view('Project.projectlist',compact('project'))
        ->with('i', (request()->input('page', 1) - 1) * 10);
        
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
        $esis = Esidetails::first();       
        
        $pfs = Providentfunddetails::first();
        $post = $request->all();

        $PayScale = EmpStaffPayScales::where(['salarystructure' => $post['sla_structure']])->first();

        $grossamount = $post['amount'];
        $pt = $post['pt'];
        $insurance = $post['insurance'];
        $basic = round($grossamount * $PayScale->basic);
        $hra = round($grossamount * $PayScale->hra);  
        $conveyance_allowance = round($PayScale->conveyance_allowance);
        $spl_allowance = round($grossamount - ($basic + $hra + $conveyance_allowance));
        $pf_wages = $grossamount -  $hra;
        if($pf_wages > 15000){
        $pf = 1800;
        $employer_pf = 1950;
        // $esi = 0;
        }else{
        $pf = round($pf_wages *$pfs->employee_pf/100);
      //  $esi = round($grossamount *$esis->employee_esi/100);
        $employer_pf = round($pf_wages * $pfs->employer_pf/100);
        }

        if($grossamount < 21000){
            $esi = round($grossamount *$esis->employee_esi/100);
            $employer_esi = round($grossamount * $esis->employer_esi/100);
        }else{
            $esi = 0;
            $employer_esi = 0;
        }        
        $netsalary = round($grossamount - $pf - $esi - $pt);        
       // $check1 = round($grossamount * $esis->employer_esi/100);
       // $ctc = round($grossamount + $check + $check1 + $insurance);
     //  $ctc = round($grossamount + $employer_pf + $esi + $insurance);
       $ctc = round($grossamount + $employer_pf + $employer_esi + $insurance);
       
        echo json_encode(['basic' => $basic, 'hra' => $hra,  'ca' => $conveyance_allowance, 'spl' => $spl_allowance, 'pf' => $pf, 'esi' => $esi, 'netsalary'=>$netsalary,'ctc'=>$ctc]);
      
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
        $remuneration->professional_tax = $request->pt;
        $remuneration->net_salary = $request->netsalary;
        $remuneration->insurance = $request->insurance;
        $remuneration->ctc = $request->ctc;
        
        $remuneration->local = $request->local;        
        $remuneration->laptop = $request->laptop;
        $remuneration->mobile = $request->mobile;
        $remuneration->takehome = $request->takehome;
               
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
       
        $remuneration_edit->professional_tax = $request->pt;
        
        $remuneration_edit->net_salary = $request->netsalary;
        $remuneration_edit->insurance = $request->insurance;
        $remuneration_edit->ctc = $request->ctc;

        $remuneration_edit->local = $request->local;        
        $remuneration_edit->laptop = $request->laptop;
        $remuneration_edit->mobile = $request->mobile;
        $remuneration_edit->takehome = $request->takehome;
           
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

            return redirect('/empfile/' . $request->empid);
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

            return redirect('/empfileedit/' . $request->empid);
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
    public function empfileedit(Request $request, $id)
    {
        $emp_id = EmpDetails::findOrFail($id);
        return view('empdetails.empfileedit', ['model' => $emp_id]);
    }
    public function empfileeditstore(Request $request){
        $request->validate([
            'document_type' => 'required',
        ]);
        $date = date("Y-m-d").rand();
        // echo $date;
        // exit();

        if ($request->hasFile('file_upload')) {
            $Empfile = new Documents;

            $filenameWithExt = $request->file('file_upload')->getClientOriginalName();
            //$empname = $request->emp_code;
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file_upload')->getClientOriginalExtension();
           // $fileNameToStore = $filename  . '.' . $extension;
           $fileNameToStores = $request->empcode.'_'. $request->document_type.'.'. $extension;
           $fileNameToStore = $request->empcode.'_'. $request->document_type.'_'. $date. '.' . $extension;
            $path = $request->file('file_upload')->storeAs('/public/employee/', $fileNameToStore);
            
            $Empfile->empid=$request->empid;
            $Empfile->document_name = $fileNameToStores;
            $Empfile->document_dummy_name = $fileNameToStore;
            $Empfile->document_type = $request->document_type;
            
         }
        //  if($Empfile->save()){
        //     return redirect('empdetails');
        //  }
                 
if ($Empfile->save()) {

    return redirect('/personaldetails_edit/' . $request->empid);
}
    


    }
    public function empfilestore(Request $request){
        $request->validate([
            'document_type' => 'required',
        ]);
        $date = date("Y-m-d").rand();

        if ($request->hasFile('file_upload')) {
            $Empfile = new Documents;
            

            $filenameWithExt = $request->file('file_upload')->getClientOriginalName();
            //$empname = $request->emp_code;
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file_upload')->getClientOriginalExtension();
           // $fileNameToStore = $filename  . '.' . $extension;
           $fileNameToStores = $request->empcode.'_'. $request->document_type.'.'. $extension;
           $fileNameToStore = $request->empcode.'_'. $request->document_type.'_'. $date. '.' . $extension;
            $path = $request->file('file_upload')->storeAs('/public/employee/', $fileNameToStore);
            
            $Empfile->empid=$request->empid;
            $Empfile->document_name = $fileNameToStores;
            $Empfile->document_dummy_name = $fileNameToStore;
            $Empfile->document_type = $request->document_type;
                        
         }
        //  if($Empfile->save()){
        //     return redirect('empdetails');
        //  }
                 
if ($Empfile->save()) {

    return redirect('/personal/' . $request->empid);
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

    public function import(Request $request)
    {       

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
	
	public function leavebalance(Request $request)
    {
        return view('empdetails.leavebalance',[
            'model'=>LeaveBalance::all()
        ]);
    }
    public function leavebalanceexport()
    {
        return Excel::download(new LeaveBalanceExport, 'leavebalance.xlsx');
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
            ['db' => 'master.leavebalance', 'dt' => 5, 'field' => 'leavebalance'],
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

    public function personal(Request $request,$id)
    {
        $emp_id = EmpDetails::findOrFail($id);
        return view('empdetails.personaldetails_add', ['model' => $emp_id]);
    }
    public function personalstore(Request $request)
    {
        $Personaldetails = new Personaldetails;
        // $Personaldetails->emp_code = $request->emp_code;
        // $Personaldetails->emp_name = $request->emp_name;
        $Personaldetails->empid = $request->empid;
        $Personaldetails->name_1 = $request->name1;
        $Personaldetails->relationship_1 = $request->relation1;
        $Personaldetails->dob_1 = date('Y-m-d', strtotime($request->dob1));
        $Personaldetails->name_2 = $request->name2;
        $Personaldetails->relationship_2 = $request->relation2;
        $Personaldetails->dob_2 = date('Y-m-d', strtotime($request->dob2));
        $Personaldetails->name_3 = $request->name3;
        $Personaldetails->relationship_3 = $request->relation3;
        $Personaldetails->dob_3 = date('Y-m-d', strtotime($request->dob3));
        if($Personaldetails->save()){
            return redirect('/bgv/' . $request->empid);
        }       
        
       // return redirect('empdetails');
    }
    public function personaldetails_edit(Request $request,$id)
    {
        $emp_id = EmpDetails::findOrFail($id);
        $personal = Personaldetails::where (['empid'=>$emp_id->id])->first();
       // return view('empdetails.emp_detailsview', ['model' => $emp_id]);
        return view('empdetails.personaldetails_edit', ['model' => $emp_id, 'personal'=>$personal]);
       // $lodview = Costingsheet::where (['tenderno'=>$id])->get();
        //return view('businessms.costingview', ['lodviews' => $lodview,'id'=>$id]);
    }
    public function personaldetails_editstore(Request $request,$id)
    {
         if($request->dob1 != '')
            $dob_1 = date('Y-m-d', strtotime($request->dob1));       
         if($request->dob2 != '')
            $dob_2 = date('Y-m-d', strtotime($request->dob2));
        if($request->dob3 != '')
            $dob_3 = date('Y-m-d', strtotime($request->dob3));

        $personal = Personaldetails::updateOrCreate(['empid'=>$id,],['name_1' => $request->name1,'relationship_1' => $request->relation1, 'dob_1' =>$dob_1,'name_2' => $request->name2,'relationship_2' => $request->relation2, 'dob_2' =>$dob_2,'name_3' => $request->name3,'relationship_3' => $request->relation3, 'dob_3' =>$dob_3]);
      
        return redirect('/bgv_edit/' . $request->empid);
    }
    public function bgv(Request $request,$id)
    {
        $emp_id = EmpDetails::findOrFail($id);
        return view('empdetails.bgv', ['model' => $emp_id]);
    }
    public function bgvedit(Request $request,$id)
    {
        $emp_id = EmpDetails::findOrFail($id);
        $bk = BackgroundVerifications::where (['empid'=>$emp_id->id])->first();
        return view('empdetails.bgv_edit', ['model' => $emp_id,'bk'=>$bk]);
    }
    public function bgvstore(Request $request)
    {
        Schema::hasTable('background_verifications');
        $back = new BackgroundVerifications;
        $back->empid = $request->empid;
        $back->document_sent = date('Y-m-d', strtotime($request->document_sent));
        $back->educational_check = $request->educational_check;
        $back->employment_check = $request->employment_check;
        $back->address_check = $request->address_check;
        $back->overall_check = $request->overall_status;
        $back->report = date('Y-m-d', strtotime($request->report)); 
        if(Schema::hasTable('background_verifications')){
        $back->save();
        return redirect('/exit/' . $request->empid);
        }else{
        return redirect('/bgv/' . $request->empid);
        }   
    }
    public function bgv_editpost(Request $request,$id)
    {
        $date = date('Y-m-d', strtotime($request->document_sent));
        $date1 = date('Y-m-d', strtotime($request->report)); 
       // $back = BackgroundVerifications::where (['empid'=>$id])->update(['document_sent'=>$date,'educational_check'=>$request->educational_check,'employment_check'=>$request->employment_check,'address_check'=>$request->address_check,'overall_check'=>$request->overall_status,'report'=>$date1]);
        // $back->empid = $request->empid;
        // $back->document_sent = date('Y-m-d', strtotime($request->document_sent));
        // $back->educational_check = $request->educational_check;
        // $back->employment_check = $request->employment_check;
        // $back->address_check = $request->address_check;
        // $back->overall_check = $request->overall_status;
        // $back->report = date('Y-m-d', strtotime($request->report)); 
       //if($back->save()){
        
      // }  

      $back = BackgroundVerifications::updateOrCreate(['empid'=>$id,],['document_sent' => $date,'educational_check' => $request->educational_check, 'employment_check' =>$request->employment_check, 'address_check' => $request->address_check, 'overall_check' =>$request->overall_status,'report'=>$date1]);

return redirect('/exit_edit/' . $request->empid);
    }
    public function grievance(Request $request,$id)
    {
        $emp_id = Grievances::where(['empid'=>$id])->first();
        return view('empdetails.grievance', ['model' => $emp_id]);
    }
    public function grievancecreate(Request $request)
    {
        return view('EmpDetails.grievance_create');
    }
    public function empgrievance(Request $request)
    {
        return view('employee.empgrievance_create');
    }
    public function empgrievanceshow(Request $request, $id)
    {
        $emp_id = Grievances::where(['grievance_no'=>$id])->first();
        return view('employee.empgrievanceshow', ['model' => $emp_id]);
    }
    public function grievance_edit(Request $request,$id)
    {
       // $emp_id = EmpDetails::findOrFail($id);
      //  $gr = Grievances::where (['empid'=>$emp_id->id])->first();
      $emp_id = Grievances::where(['id'=>$id])->first();
        return view('empdetails.grievance_edit', ['model' => $emp_id]);
    }
    public function empgrievance_edit(Request $request,$id)
    {
       // $emp_id = EmpDetails::findOrFail($id);
      //  $gr = Grievances::where (['empid'=>$emp_id->id])->first();
      $emp_id = Grievances::where(['id'=>$id])->first();
        return view('employee.empgrievance_edit', ['model' => $emp_id]);
    }
    public function grievancestore(Request $request)
    {
        $grievance = new Grievances;
        $grievance->empid = $request->employee_code;      
        $grievance->grievance_no = $request->grievance_no;       
        $grievance->employee_name = $request->employee_name;        
        $grievance->project = $request->project;        
        $grievance->designation = $request->designation;       
        $grievance->dateofgrievance = date('Y-m-d', strtotime($request->dateofgrievance));   
        $grievance->type_of_query = $request->type_of_queryies;      
        $grievance->query = $request->queryies;       
        $grievance->tat =  date('Y-m-d', strtotime($request->tat));
        $grievance->action = $request->action;
        $grievance->grievance_address = $request->grievance_address;
        $grievance->grievance_resolved_date = date('Y-m-d', strtotime($request->grievance_resolved_date)); 
        $grievance->remarks = $request->remarks;
        $grievance->status = $request->status;
        if($grievance->save()){
           // return redirect('/exit/' . $request->empid);    
           return redirect('/grievancelist');
        }            
    }
    public function empgrievancestore(Request $request)
    {
        $grievance = new Grievances;
        $grievance->empid = $request->employee_code;      
        $grievance->grievance_no = $request->grievance_no;       
        $grievance->employee_name = $request->employee_name;        
        $grievance->project = $request->project;        
        $grievance->designation = $request->designation;       
        $grievance->dateofgrievance = date('Y-m-d', strtotime($request->dateofgrievance));  
        $grievance->type_of_query = $request->type_of_queryies;       
        $grievance->query = $request->queryies;       
        // $grievance->tat = $request->tat;
        // $grievance->action = $request->action;
        // $grievance->grievance_address = $request->grievance_address;
        // $grievance->grievance_resolved_date = date('Y-m-d', strtotime($request->grievance_resolved_date)); 
        // $grievance->remarks = $request->remarks;
         $grievance->status = 'Open';
        if($grievance->save()){
           // return redirect('/exit/' . $request->empid);    
           return redirect('/empgrievancelist');
        }            
    }
    public function empgrievancepost(Request $request, $id)
    {
       // $grievance = new Grievances;
       
       $grievance = Grievances::where (['grievance_no'=>$id])->first();  
        $grievance->empid = $request->employee_code;      
        $grievance->grievance_no = $request->grievance_no;       
        $grievance->employee_name = $request->employee_name;        
        $grievance->project = $request->project;        
        $grievance->designation = $request->designation;       
        $grievance->dateofgrievance = date('Y-m-d', strtotime($request->dateofgrievance));     
        $grievance->type_of_query = $request->type_of_queryies;    
        $grievance->query = $request->queryies;       
        // $grievance->tat = $request->tat;
        // $grievance->action = $request->action;
        // $grievance->grievance_address = $request->grievance_address;
        // $grievance->grievance_resolved_date = date('Y-m-d', strtotime($request->grievance_resolved_date)); 
        // $grievance->remarks = $request->remarks;
        $grievance->status = 'Open';
        if($grievance->save()){
           // return redirect('/exit/' . $request->empid);    
           return redirect('/empgrievancelist');
        }            
    }
    public function grievance_editpost(Request $request,$id)
    {
      //  $emp_id = EmpDetails::findOrFail($id);
        $grievance = Grievances::where (['id'=>$id])->first();       
        $grievance->empid = $request->employee_code;      
        $grievance->grievance_no = $request->grievance_no;       
        $grievance->employee_name = $request->employee_name;        
        $grievance->project = $request->project;        
        $grievance->designation = $request->designation;       
        $grievance->dateofgrievance = date('Y-m-d', strtotime($request->dateofgrievance)); 
        $grievance->type_of_query = $request->type_of_queryies;        
        $grievance->query = $request->queryies;       
        $grievance->tat = date('Y-m-d', strtotime($request->tat));
        $grievance->action = $request->action;
        $grievance->grievance_address = $request->grievance_address;
        $grievance->grievance_resolved_date = date('Y-m-d', strtotime($request->grievance_resolved_date)); 
        $grievance->remarks = $request->remarks;
        $grievance->status = $request->status;
        if($grievance->save()){
           // return redirect('/exit_edit/' . $request->empid);    
           return redirect('/grievancelist');
        }            
    }
    public function exit(Request $request,$id)
    {
        $emp_id = EmpDetails::findOrFail($id);
        return view('empdetails.exit', ['model' => $emp_id]);
    }
    public function exit_edit(Request $request,$id)
    {
        $emp_id = EmpDetails::findOrFail($id);
        $ex = Exits::where (['empid'=>$emp_id->id])->first();
        return view('empdetails.exit_edit', ['model' => $emp_id,'ex'=>$ex]);
    }
    public function exitstore(Request $request)
    {
        $exs = new Exits;
        $exs->empid = $request->empid;      
        $exs->date_of_resignation =date('Y-m-d', strtotime($request->date_of_resignation));       
        $exs->date_of_leaving = date('Y-m-d', strtotime($request->date_of_leaving));
        $exs->reason_of_leaving = $request->reason_of_leaving;        
        $exs->f_f_signed = $request->f_f_signed;      
        $exs->exit_form = $request->exit_form;       
        $exs->handling = $request->handling;
        $exs->project_clearance = $request->project_clearance;
        $exs->f_f = $request->f_f;  
        $exs->pending = $request->pending;       
        $exs->fandfdays = $request->fandf_days; 
        $exs->salary = $request->salary; 
        $exs->bonus = $request->bonus; 
        $exs->comp_salary = $request->comp_salary; 
        $exs->dues = $request->dues; 
        $exs->security_deposit = $request->security_deposit; 
        $exs->advance = $request->advance; 
        $exs->salary_ded = $request->salary_ded; 
        $exs->tes = $request->tes; 
        $exs->epf = $request->epf; 
        $exs->esi = $request->esi; 
        $exs->admin = $request->admin; 
        $exs->pt = $request->pt; 
        $exs->loan = $request->loan; 
        $exs->pay = $request->pay; 
        if($exs->save()){
            return redirect('/empdetails');    
        }            
    }
    public function exit_editpost(Request $request,$id)
    {
        $emp_id = EmpDetails::findOrFail($id);
        $exs = Exits::where(['empid'=>$emp_id->id])->exists();    
        if($exs){
        $exs->empid = $request->empid;      
        $exs->date_of_resignation =date('Y-m-d', strtotime($request->date_of_resignation));       
        $exs->date_of_leaving = date('Y-m-d', strtotime($request->date_of_leaving));
        $exs->reason_of_leaving = $request->reason_of_leaving;        
        $exs->f_f_signed = $request->f_f_signed;      
        $exs->exit_form = $request->exit_form;       
        $exs->handling = $request->handling;
        $exs->project_clearance = $request->project_clearance;
        $exs->f_f = $request->f_f;     
        $exs->pending = $request->pending;       
        $exs->fandfdays = $request->fandf_days; 
        $exs->salary = $request->salary; 
        $exs->bonus = $request->bonus; 
        $exs->comp_salary = $request->comp_salary; 
        $exs->dues = $request->dues; 
        $exs->security_deposit = $request->security_deposit; 
        $exs->advance = $request->advance; 
        $exs->salary_ded = $request->salary_ded; 
        $exs->tes = $request->tes; 
        $exs->epf = $request->epf; 
        $exs->esi = $request->esi; 
        $exs->admin = $request->admin; 
        $exs->pt = $request->pt; 
        $exs->loan = $request->loan; 
        $exs->pay = $request->pay;    
        $exs->save();
        }else{
        $exs =new Exits(); 
        $exs->empid = $request->empid;      
        $exs->date_of_resignation =date('Y-m-d', strtotime($request->date_of_resignation));       
        $exs->date_of_leaving = date('Y-m-d', strtotime($request->date_of_leaving));
        $exs->reason_of_leaving = $request->reason_of_leaving;        
        $exs->f_f_signed = $request->f_f_signed;      
        $exs->exit_form = $request->exit_form;       
        $exs->handling = $request->handling;
        $exs->project_clearance = $request->project_clearance;
        $exs->f_f = $request->f_f;     
        $exs->pending = $request->pending;       
        $exs->fandfdays = $request->fandf_days; 
        $exs->salary = $request->salary; 
        $exs->bonus = $request->bonus; 
        $exs->comp_salary = $request->comp_salary; 
        $exs->dues = $request->dues; 
        $exs->security_deposit = $request->security_deposit; 
        $exs->advance = $request->advance; 
        $exs->salary_ded = $request->salary_ded; 
        $exs->tes = $request->tes; 
        $exs->epf = $request->epf; 
        $exs->esi = $request->esi; 
        $exs->admin = $request->admin; 
        $exs->pt = $request->pt; 
        $exs->loan = $request->loan; 
        $exs->pay = $request->pay;    
        $exs->save();
        }
        //if($exs->update()){
            return redirect('/empdetails');    
       // }            
    }
    public function pf(Request $request)
    { 
        return view('settings.pf');
    }
    public function pfstore(Request $request)
    {
        $pfd = new Providentfunddetails;
        $pfd->employee_pf = $request->employee_pf;
        $pfd->employer_pf = $request->employer_pf;
        $pfd->save();
        //return view('settings.pf');
         return redirect('/pf');
    }
    public function pfedit(Request $request,$id)
    { 
        $pfd = Providentfunddetails::findOrFail($id);
        return view('settings.pfedit',['pfd'=>$pfd]);
    }
    public function pfeditstore(Request $request,$id)
    {
        $pfd = Providentfunddetails::findOrFail($id);
        $pfd->employee_pf = $request->employee_pf;
        $pfd->employer_pf = $request->employer_pf;
        $pfd->save();
        //return view('settings.pf');
         return redirect('/pf');
    }
    public function esi(Request $request)
    { 
        return view('settings.esi');
    }
    public function esistore(Request $request)
    {
        $esi = new Esidetails;
        $esi->employee_esi = $request->employee_esi;
        $esi->employer_esi = $request->employer_esi;
        $esi->save();
        //return view('settings.pf');
         return redirect('/esi');
    }
    public function esiedit(Request $request,$id)
    { 
        $esi = Esidetails::findOrFail($id);
        return view('settings.esiedit',['esi'=>$esi]);
    }
    public function esieditstore(Request $request,$id)
    {
        $esi = Esidetails::findOrFail($id);
        $esi->employee_esi = $request->employee_esi;
        $esi->employer_esi = $request->employer_esi;
        $esi->save();
        //return view('settings.pf');
         return redirect('/esi');
    }
    public function grievancelist(Request $request)
    {
        return view('EmpDetails.grievancelist');
    } 
    public function empgrievancelist(Request $request)
    {
       // $emp = App\Models\EmpDetails::where(['id' => auth()->user()->emp_id])->first();
        return view('employee.empgrievancelist');
    }  
    public function viewdatalist(Request $request)
    {

        // $jointable =
        //     [
        //     ['table' => 'project_details AS b', 'on' => 'a.project_id=b.id', 'join' => 'JOIN'],
        //     ['table' => 'designations AS c', 'on' => 'a.designation_id=c.id', 'join' => 'JOIN'],
        //     ['table' => 'locations AS d', 'on' => 'a.location_id=d.id', 'join' => 'LEFT JOIN'],
        // ];
        $columns = [
            ['db' => 'id', 'dt' => 0, 'field' => 'id', 'as' => 'slno'],
            ['db' => 'grievance_no', 'dt' => 1, 'field' => 'grievance_no'],
            ['db' => 'empid', 'dt' => 2, 'field' => 'empid'],
            ['db' => 'employee_name', 'dt' => 3, 'field' => 'employee_name'],
            ['db' => 'project', 'dt' => 4, 'field' => 'project'],
            ['db' => 'status', 'dt' => 5, 'field' => 'status'],
            ['db' => 'id', 'dt' => 6, 'field' => 'id'],

        ];
        // $where = 'status=>Entry Completed';
        echo json_encode(
            Dtssp::simple($_GET, 'grievances', 'id', $columns, $jointable = null, $where = null)
        ); 

    }
    public function empviewdatalist(Request $request)
    {
        $test = auth()->user()->emp_id;
        $id_test = EmpDetails::where(['id' => $test])->first();  
        $columns = [
            ['db' => 'id', 'dt' => 0, 'field' => 'id', 'as' => 'slno'],
            ['db' => 'grievance_no', 'dt' => 1, 'field' => 'grievance_no'],
            ['db' => 'empid', 'dt' => 2, 'field' => 'empid'],
            ['db' => 'employee_name', 'dt' => 3, 'field' => 'employee_name'],
            ['db' => 'project', 'dt' => 4, 'field' => 'project'],
            ['db' => 'status', 'dt' => 5, 'field' => 'status'],
            ['db' => 'id', 'dt' => 6, 'field' => 'id'],

        ];
      //  $where = "contact_type ='$contact_type'";
        // $where = 'status=>Entry Completed';
        $where = "empid='$id_test->emp_code'";
        echo json_encode(
            Dtssp::simple($_GET, 'grievances', 'id', $columns, $jointable = null, $where)
        ); 

    }
    public function file_download(Request $request,$id,$code)
    {
        $doc = Documents::findorFail($id);
        $filename = $doc->document_name;
        $file= storage_path(). "/app/public/employee/$filename";
        $headers = array(
            'Content-Type: application/pdf',
        );
        return Response::download($file, $filename, $headers);
        return redirect('/empfileedit/'.$code);
    }     
    public function file_delete(Request $request,$id,$code)
    {
        $doc = Documents::findorFail($id);
        $doc->delete(); 
        return redirect('/empfileedit/'.$code);
    } 

    //Esidetails
    public function fandf(Request $request, $id)
    {
		$Emp = EmpDetails::find($id);
        $Emp->save();
		 $options = [
            'orientation' => 'portrait',
            'encoding' => 'UTF-8',	
        ];
        $pdf = PDF::loadView('empdetails.fandf', [
            'model' => $Emp,          
        ]);
		 $pdf->setOptions($options);
         return $pdf->inline($Emp->emp_name.'.pdf');   
    }
    
    public function gather_data(Request $request)
    {
        $post = $request->all();
        $gather = EmpDetails::where(['emp_code' => $post['employee_code']])->first();
        $project = ProjectDetails::where(['id' => $gather->project_id])->first();
        $desg = Designation::where(['id' => $gather->designation_id])->first();
        $empname = $gather->emp_name;
      echo json_encode(['empname' => $empname,'project'=>$project->project_name,'desg'=>$desg->designation_name]);
      //  echo $date->enquiryreceiveddate;
    }


    ############## department ##############
    public function departments(Request $request)
    {       
        return view('Department.departmentlist');
    } 
    public function departmentdata(Request $request)
    {
        $columns = [
            ['db' => 'id', 'dt' => 0],
            ['db' => 'department_name', 'dt' => 1],

        ];
        // $where = 'status=>Entry Completed';
        echo json_encode(
            Dtssp::simple($_GET, 'departments', 'id', $columns, $jointable = null, $where = null)
        );

    }
    public function departmentcreation(Request $request)
    {
        return view('Department.departmentcreation');
    }
    public function departmentstore(Request $request)
    {
        $dept = new Departments();
        $dept->department_name 	 = $request->dept_name;
        $dept->save();
        return view('Department.departmentlist');
    }
    public function departmentedit(Request $request, $id)
    {
        $dept = Departments::findOrFail($id);
        return view('Department.departmentedit', [
            'model' => $dept]);
    }
    public function departmentupdate(Request $request, $id)
    {
        $dept = Departments::find($request->id);
        $dept->department_name = $request->dept_name;
        $dept->save();

        return redirect('/Department/departmentlist');
    }
    ################### department end ###################
    ##############designation start##########
    public function designations(Request $request)
    {
        return view('Designations.designationlist');        
    }
    public function designationdata(Request $request)
    {
        $columns = [
            ['db' => 'id', 'dt' => 0],
            ['db' => 'designation_name', 'dt' => 1],

        ];
        // $where = 'status=>Entry Completed';
        echo json_encode(
            Dtssp::simple($_GET, 'designations', 'id', $columns, $jointable = null, $where = null)
        );

    }
    public function designationcreation(Request $request)
    {
        return view('Designations.designationcreation');   
    }
    public function designationstore(Request $request)
    {
        $desg = new Designation();
        $desg->designation_name = $request->desg_name;
        $desg->save();
        return redirect('/Designations/designationlist');
    }
    public function designationedit(Request $request, $id)
    {
        $desg = Designation::findOrFail($id);
        return view('Designations.designationedit', [
            'model' => $desg]);
    }
    public function designationupdate(Request $request, $id)
    {
        $desg = Designation::find($request->id);
        $desg->designation_name = $request->desg_name;
        $desg->save();
        return redirect('/Designations/designationlist');
    }
    ################## designation end#########
    ########### doc addition############
    public function doc_addition(Request $request)
    {
        $documents = Doc_type::paginate(10);
        return view('Documents.doc_additionlist',compact('documents'))
        ->with('i', (request()->input('page', 1) - 1) * 10);       
    }
    public function documentdelete(Request $request,$id)
    {
        $documents = Doc_type::where('id',$id)->first();
        $documents = $documents->delete();
        return back();
    }
    public function documentcreation(Request $request)
    {
        return view('Documents.documentcreation');   
    }
    public function documentstore(Request $request)
    {
       // $desg = new Doc_type();
        $desg = Doc_type::updateOrCreate(['doc_type_name'=>$request->doc_name]);
        // $desg-> = ;
        $desg->save();
        return redirect('/Documents/doc_addition');
    }
    public function documentedit(Request $request, $id)
    {
        $doc = Doc_type::findOrFail($id);
        return view('Documents.documentedit', [
            'model' => $doc]);
    }
    public function documentupdate(Request $request, $id)
    {
        $doc = Doc_type::find($request->id);
        $doc->doc_type_name = $request->doc_name;
        $doc->save();
        return redirect('/Documents/doc_addition');
    }
     ######## doc addition end #######
     ########## document view ######
     public function documentview(Request $request, $id)
     {
        //  $doc = Documents::find($request->id);
        //  return view('EmpDetails.document_view',['model'=>$doc]);
        $emp_id = EmpDetails::findOrFail($id);
        return view('EmpDetails.document_view', ['model' => $emp_id]);
        // return redirect('/Documents/doc_addition');
     }
     ########## document view end #######

     ######## checklist export ########
     public function checklistexport(Request $request)
     {
        $emp= EmpDetails::all();
        $doc = Doc_type::all();
        $project = ProjectDetails::all();
        return view('EmpDetails.checklistexport',['model'=>$doc,'emp'=>$emp]);
     }    
     public function checklistexports()
     {
        $emp= EmpDetails::all();
        $doc = Doc_type::all();
        $project = ProjectDetails::all();
         return Excel::download(new CheckListExport, 'checklist.xlsx');
     } 
     public function chklist(Request $request)
     {
        $emp= EmpDetails::all();
        $doc = Doc_type::all();
        $project = ProjectDetails::all();
        return view('EmpDetails.chklist',['model'=>$doc,'emp'=>$emp]);
     } 
     ######## checklist export end########
     
     ######### appraisal letter #########
     public function appraisalletter(Request $request, $id)
     {
         $date = date('Y-m-d');
         $Emp = EmpDetails::find($id);
         $headerHtml = view()->make('empdetails.header')->render();
         $footerHtml = view()->make('empdetails.footer')->render();
          $options = [
             'orientation' => 'portrait',
             'encoding' => 'UTF-8', 
             'header-html' => $headerHtml,
             'footer-html' => $footerHtml,	
         ];
         $pdf = PDF::loadView('empdetails.appraisalletter', [
             'model' => $Emp,          
         ]);     
         $pdf->setOptions($options); 
         return $pdf->inline($Emp->emp_name.'.pdf');    
        // Storage::put('public/offerletter/'.$empcode.'_'.$date.'.pdf', $pdf->output());
          
     }
     ########## appraisal letter end #######

     ###### project appraisal ########
     public function appraisal_project(Request $request)
     {         
        $emp = EmpDetails::where('project_id',Auth::user()->project_id)->latest()->paginate(10);;
        return view('ProjectAppraisal.appraisallist',['emp'=>$emp],compact('emp'))->with('i', (request()->input('page', 1) - 1) * 10);    
     }
     public function appraisal_create(Request $request,$id)
     {  
        $emp = EmpDetails::Find($id);
        $appraisal = Appraisals::where('empid',$id)->first();
        return view('ProjectAppraisal.create',['empid'=>$id,'emp'=>$emp,'appraisal'=>$appraisal]);    
     }
     public function appraisaledit(Request $request,$id)
     {  
         $emp = EmpDetails::Find($id);         
         $appraisal = Appraisals::where('empid',$id)->first();
        return view('ProjectAppraisal.edit',['emp'=>$emp,'appraisal'=>$appraisal]); 
       // return redirect('/appraisaledit/'.$emp);      
     }
     public function appraisalpost(Request $request,$id) 
     {  
        $emp = EmpDetails::Find($id);
            $appraisals = Appraisals::where(['empid'=>$id,'review_period'=>$request->review])->exists();
            if($appraisals){
                $appraisals = Appraisals::where(['empid'=>$id,'review_period'=>$request->review])->first();
                $appraisals->evaluatorname = $request->evaname;
                $appraisals->evaluatorid = $request->evacode;
                $appraisals->workefficiency = $request->workefficiency;
                $appraisals->responsibility = $request->responsibility;
                $appraisals->teamwork   = $request->teamwork;
                $appraisals->timemngt = $request->timemngt;
                $appraisals->communication = $request->communication;
                $appraisals->problemsolving  = $request->problemsolving; 
                $appraisals->integrity = $request->integrity;
                $appraisals->attendance = $request->attendance;
                $appraisals->score   = $request->score;
                $appraisals->noteworthy = $request->noteworthy;
                $appraisals->suggestion = $request->suggestion;
                $appraisals->evaluation  = $request->evaluation; 
                $appraisals->recommendation = $request->recommendation;
                $appraisals->promotion = $request->promotion;
                $appraisals->promotion_category  = $request->promotion_detail; 
                $appraisals->role = $request->role;
                $appraisals->role_description = $request->role_detail;
                $appraisals->save();
                $appraisalrequest = AppraisalRequest::updateOrCreate(['empid'=>$id],['project_id' => $emp->project_id,'status' => "Appraisal Given"]);
                return redirect('/appraisalview/'.$emp->id);   
            }else{
                $appraisal = new Appraisals;
                $appraisal->evaluatorname = $request->evaname;
                $appraisal->evaluatorid = $request->evacode;
                $appraisal->empid = $request->empid;
                $appraisal->project_id = $request->project_id;
                $appraisal->review_date = $request->date;
                $appraisal->review_period = $request->review;  
                $appraisal->workefficiency = $request->workefficiency;
                $appraisal->responsibility = $request->responsibility;
                $appraisal->teamwork   = $request->teamwork;
                $appraisal->timemngt = $request->timemngt;
                $appraisal->communication = $request->communication;
                $appraisal->problemsolving  = $request->problemsolving; 
                $appraisal->integrity = $request->integrity;
                $appraisal->attendance = $request->attendance;
                $appraisal->score   = $request->score;
                $appraisal->noteworthy = $request->noteworthy;
                $appraisal->suggestion = $request->suggestion;
                $appraisal->evaluation  = $request->evaluation; 
                $appraisal->recommendation = $request->recommendation;
                $appraisal->promotion = $request->promotion;
                $appraisal->promotion_category  = $request->promotion_detail; 
                $appraisal->role = $request->role;
                $appraisal->role_description = $request->role_detail;
                $appraisal->save();
                $appraisalrequest = AppraisalRequest::updateOrCreate(['empid'=>$id],['project_id' => $emp->project_id,'status' => "Appraisal Given"]);
                return redirect('/appraisalview/'.$emp->id);   
            }
        //  return view('ProjectAppraisal.edit',['empid'=>$id,'emp'=>$emp]);   
        return redirect('/appraisalview/'.$emp->id);   
         
     }
    
     ###### project appraisal end ########


     ########## appraisal letter ##########
     public function appraisalletterview(Request $request, $id)
     {
        $appr  = Appraisals::where(['empid'=>$id,'flag'=>1])->latest()->first();
        if($appr){

        
         $date = date('Y-m-d');
         $Emp = EmpDetails::find($id);
         $headerHtml = view()->make('empdetails.header')->render();
         $footerHtml = view()->make('empdetails.footer')->render();
          $options = [
             'orientation' => 'portrait',
             'encoding' => 'UTF-8', 
             'header-html' => $headerHtml,
             'footer-html' => $footerHtml,	
         ];
         $pdf = PDF::loadView('ProjectAppraisal.appraisalletter', [
             'model' => $Emp,          
         ]);     
         $pdf->setOptions($options); 
         return $pdf->inline($Emp->emp_name.'.pdf');    
        // Storage::put('public/offerletter/'.$empcode.'_'.$date.'.pdf', $pdf->output());
    }else{
        return redirect('/empview/'.$id)->with('info','Appraisal yet to be given.....');
    }
     }
     ########## appraisal letter end ##########
}