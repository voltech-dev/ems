<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Dtssp;
use App\Models\EmpDetails;
use App\Models\ProjectDetails;
use App\Models\Locations;
use App\Models\Statuses;
use App\Models\Authorities;
use App\Models\EmpStaffPayScales; 
use App\Models\EmpRemunerationDetails;
use App\Models\EmpStatutorydetails;
use App\Models\EmpBankdetails;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\SalaryMonths;
use App\Models\EmpSalaryUploads;

use Carbon\Carbon;



class EmpSalaryController extends Controller
{
    public function __construct()
  {
    $this->middleware('auth');
  }

  public function index(Request $request)
  {
    return view('EmpDetails.index');
  }

  public function create(Request $request)
  {
    return view('EmpDetails.add', [
      []
    ]);
  }

  public function edit(Request $request, $id)
  {
    $emp = EmpDetails::findOrFail($id);
    return view('EmpDetails.edit', [
      'model' => $emp]);
  }

  public function show(Request $request, $id)
  {
    $emp = EmpDetails::findOrFail($id);
    return view('EmpDetails.show', [
      'model' => $emp]);
  }

  public function viewdata(Request $request)
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
    // $where = 'status=>Entry Completed';
    echo json_encode(
        Dtssp::simple($_GET, 'emp_details', 'id', $columns, $jointable = null, $where=null)
    );

  }


  public function update(Request $request,$id) {
   
  $emp_update = EmpDetails::find($request->empid);     
    
    $emp_update->emp_code = $request->emp_code;
    $emp_update->emp_name = $request->emp_name;
    $emp_update->designation_id = $request->designation;
    $emp_update->project_id = $request->project_id;
    $emp_update->location_id = $request->location_id;
    $emp_update->mail = $request->email;
    $emp_update->mobile = $request->mobile;           
    $emp_update->date_of_joining = date('Y-m-d', strtotime($request->doj));     
    $emp_update->date_of_leaving = date('Y-m-d', strtotime($request->dol));                                                     
    $emp_update->last_appraisal_date = date('Y-m-d', strtotime($request->lad));
    $emp_update->reporting_authority_id = $request->authority_id;
    $emp_update->status_id = $request->status_id;
   
 if ($emp_update->save()){
  return redirect('/EmpDetails/remunerationedit/'. $emp_update->id);

 }
}

public function store(Request $request)
{
  $Empdet = new EmpDetails;
  
    
    $this->validate($request, [
    'emp_code' => 'required',
    'emp_name' => 'required',
    'project_id' => 'required',
    'location_id' => 'required',
    'email' => 'required|email',
  ]);

      
    $Empdet->emp_code = $request->emp_code;
    $Empdet->emp_name = $request->emp_name;
    $Empdet->designation_id = $request->designation;
    $Empdet->project_id = $request->project_id;
    $Empdet->location_id = $request->location_id;
    $Empdet->mail = $request->email;
    $Empdet->mobile = $request->mobile;
    $Empdet->date_of_joining =  date('Y-m-d', strtotime($request->doj));      
    $Empdet->date_of_leaving = date('Y-m-d', strtotime($request->dol));
    $Empdet->last_appraisal_date = date('Y-m-d', strtotime($request->lad));
    $Empdet->reporting_authority_id = $request->authority_id;
    $Empdet->status_id = $request->status_id;
   
 if ($Empdet->save()){
   $empid = EmpDetails::where('id',$Empdet->id)->first();
  return redirect('/EmpDetails/remuneration/'. $empid->id);

 }
     


}

public function destroy(Request $request, $id) {

  $batch = Batch::findOrFail($id);

  $batch->delete();
  return "OK";

}

public function salarymonth(Request $request) {
    return view('EmpSalary/salary_month');
  }

  public function addmonth(Request $request) {
   
    //$data = Yii::$app->request->post();
      $month = '01-' . $request->month;
      $currentmonth =  date('Y-m-d', strtotime($month)); 
     
	  $salarymonth =  date('Y-m', strtotime($currentmonth)); 
      $salmonth = SalaryMonths::where(['month' => $currentmonth])->first();
      if ($salmonth) {
         $jsonData['error'] = 'Already Generated';
      } else {
         $uploadedmonth = EmpSalaryUploads::where(['status' => 'Uploaded'])->first();
         if ($uploadedmonth) {
            $jsonData['error'] = 'uploaded error';
         } else {
            $ModelEmp = EmpDetails::where(['status' => ['Paid and Relieved', 'Active', 'Notice Period', '']])
                            ->orWhere(['status' => null])->get();
            foreach ($ModelEmp as $emp) {
       $empdojmonth = date('Y-m', strtotime($emp->doj));
			if($empdojmonth <= $salarymonth){
               $modelupload = new EmpSalaryUploads();
               $modelupload->empid = $emp->id;
               $modelupload->month =  date('Y-m', strtotime($month));
               $modelupload->status = 'Uploaded';
               $modelupload->save(false);
			}
            }
            $modelmonth = new SalaryMonths();
            $modelmonth->month = $currentmonth;
            $modelmonth->save(false);
            $jsonData['success'] = 'generated';
         }
      }
      //echo json_encode($jsonData);
   } 

   public function monthstore(Request $request) {
   
    //$data = Yii::$app->request->post();
      $month = '01-' . $request->sal_month;
      $currentmonth =  date('Y-m-d', strtotime($month));
     
    $salarymonth =  date('Y-m', strtotime($currentmonth)); 
                 
      $salmonth = SalaryMonths::where(['month' => $currentmonth])->first();
         $uploadedmonth = EmpSalaryUploads::where(['status' => 'Uploaded'])->first();
         if (!$uploadedmonth && !$salmonth) {
            $ModelEmp = EmpDetails::where(['status_id' =>'1'])->get();
            foreach ($ModelEmp as $emp) {
       $empdojmonth = date('Y-m', strtotime($emp->doj));
			if($empdojmonth <= $salarymonth){
               $modelupload = new EmpSalaryUploads;
               $modelupload->empid = $emp->id;
               $modelupload->month =  date('Y-m-d', strtotime($month));
               $modelupload->status = 'Uploaded';
               $modelupload->save();
			}
            }
            $salmonth = new SalaryMonths;
            $salmonth->month = $currentmonth;
            $salmonth->save();
            //$jsonData['success'] = 'generated';
            return redirect()->back()->with(['status' => 'The Salary Month is Generated.']);
         }else{
          return redirect()->back()->with(['error' => 'The Salary Month is Already Generated.']);
         }
         
   } 


}
