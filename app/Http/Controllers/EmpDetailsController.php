<?php
namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Models\Authorities;
use App\Models\Dtssp;
use App\Models\EmpBankdetails;
use App\Models\EmpDetails;
use App\Models\EmpRemunerationDetails;
use App\Models\EmpStaffPayScales;
use App\Models\EmpStatutorydetails;
use App\Models\Locations;
use App\Models\ProjectDetails;
use App\Models\Statuses;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EmpDetailsController extends Controller
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
            [],
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

        $jointable =
            [
            ['table' => 'project_details AS b', 'on' => 'a.project_id=b.id', 'join' => 'JOIN'],
            ['table' => 'designations AS c', 'on' => 'a.designation_id=c.id', 'join' => 'JOIN'],
           // ['table' => 'locations AS d', 'on' => 'a.location_id=d.id', 'join' => 'LEFT JOIN'],
        ];
        $columns = [
            ['db' => 'a.id', 'dt' => 0, 'field' => 'id', 'as' => 'slno'],
            ['db' => 'a.emp_code', 'dt' => 1, 'field' => 'emp_code', 'as' => 'emp_code'],
            ['db' => 'a.emp_name', 'dt' => 2, 'field' => 'emp_name', 'as' => 'emp_name'],
            ['db' => 'a.mail', 'dt' => 3, 'field' => 'mail', 'as' => 'mail'],
            ['db' => 'c.designation_name', 'dt' => 4, 'field' => 'designation_name', 'as' => 'designation_name'],
            ['db' => 'b.project_name', 'dt' => 5, 'field' => 'project_name', 'as' => 'project'],
         //   ['db' => 'd.location', 'dt' => 6, 'field' => 'location', 'as' => 'location'],

            ['db' => 'a.id', 'dt' => 6, 'field' => 'id', 'as' => 'id'],

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

        if ($emp_update->save()) {
            return redirect('/EmpDetails/remunerationedit/' . $emp_update->id);

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
        $Empdet->designation_id = $request->designation;
        $Empdet->project_id = $request->project_id;
        $Empdet->location_id = $request->location_id;
        $Empdet->mail = $request->email;
        $Empdet->mobile = $request->mobile;
        $Empdet->date_of_joining = date('Y-m-d', strtotime($request->doj));
        $Empdet->date_of_leaving = date('Y-m-d', strtotime($request->dol));
        $Empdet->last_appraisal_date = date('Y-m-d', strtotime($request->lad));
        $Empdet->reporting_authority_id = $request->authority_id;
        $Empdet->status_id = $request->status_id;

        if ($Empdet->save()) {
            $empid = EmpDetails::where('id', $Empdet->id)->first();
            return redirect('/EmpDetails/remuneration/' . $empid->id);

        }

    }

    public function destroy(Request $request, $id)
    {

        $batch = Batch::findOrFail($id);

        $batch->delete();
        return "OK";

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
        return view('EmpDetails.remuneration', ['model' => $emp_id]);
    }

    public function remunerationedit(Request $request, $id)
    {
        $emp_id = EmpDetails::findOrFail($id);
        if(EmpRemunerationDetails::where(['empid'=>$id])->exists()){           
            return view('EmpDetails.remunerationedit', ['model' => $emp_id]);
        } else {
            return view('EmpDetails.remuneration', ['model' => $emp_id]);
        }       
    }

    public function salarystructure(Request $request)
    {
        $post = $request->all();

        if ($post['empmtype'] == 'Staff') {
            $PayScale = EmpStaffPayScales::where(['salarystructure' => $post['sla_structure']])->first();

            $grossamount = $post['amount'];
            $basic = round($grossamount * $PayScale->basic);
            $hra = round($grossamount * $PayScale->hra);
            $dearness_allowance = round($grossamount * $PayScale->dearness_allowance);
            $spl_allowance = round($grossamount * $PayScale->spl_allowance);
            $conveyance_allowance = round($PayScale->conveyance_allowance);
            // $pli_earning = round($basic * $PayScale->pli);
            $lta_earning = round($basic * $PayScale->lta);
            $medical_earning = round($basic * $PayScale->medical);
            $other_allowance = round($grossamount - ($basic + $hra + $dearness_allowance + $conveyance_allowance + $lta_earning + $medical_earning + $spl_allowance));

            /* if ($PayScale->salarystructure == 'Modern') {
            $spl_allowance = round($grossamount - ($basic + $hra + $dearness_allowance + $spl_allowance + $conveyance_allowance + $lta_earning + $medical_earning));
            $other_allowance = 0;
            } else {
            $spl_allowance = round($grossamount * $PayScale->spl_allowance);
            $other_allowance = round($grossamount - ($basic + $hra + $dearness_allowance + $spl_allowance + $conveyance_allowance + $lta_earning + $medical_earning));
            } */

            if ($other_allowance > 0) {
                $other_allowance = $other_allowance;
            } else {
                $other_allowance = 0;
            }
            echo json_encode(['basic' => $basic, 'hra' => $hra, 'da' => $dearness_allowance, 'ca' => $conveyance_allowance, 'lta' => $lta_earning, 'medical' => $medical_earning, 'other' => $other_allowance, 'spl' => $spl_allowance]);
        } /*else if ($post['empmtype'] == 'Engineer') {
    $Salstructure = EmpSalarystructure::find()
    ->where(['salarystructure' => $post['sla_structure'], 'worklevel' => $post['worklevel'], 'grade' => $post['grade']])
    ->one();
    echo Json::encode(['basic' => $Salstructure->basic, 'hra' => $Salstructure->hra, 'other_allowance' => $Salstructure->other_allowance, 'dapermonth' => $Salstructure->dapermonth, 'gross' => $Salstructure->netsalary]);
    }*/
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
        $remuneration->dearness_allowance = $request->dearness_allowance;
        $remuneration->conveyance = $request->conveyance;
        $remuneration->lta = $request->lta;
        $remuneration->medical = $request->medical;
        $remuneration->other_allowance = $request->other_allowance;
        $remuneration->gross_salary = $request->gross_salary;

        if ($remuneration->save()) {

            return redirect('/EmpDetails/statutory/' . $request->empid);
        }
    }

    public function remunerationeditstore(Request $request)
    {
        $remuneration_edit = EmpRemunerationDetails::where(['empid' => $request->empid])->first();

        $this->validate($request, [
            'salary_structure' => 'required',
            'gross_salary' => 'required',

        ]);

//$remuneration_edit->empid = $request->empid;
        $remuneration_edit->salary_structure = $request->salary_structure;
        $remuneration_edit->esi_applicability = $request->esi_applicability;
        $remuneration_edit->pf_applicablity = $request->pf_applicablity;
        $remuneration_edit->restrict_pf = $request->restrict_pf;
        $remuneration_edit->basic = $request->basic;
        $remuneration_edit->hra = $request->hra;
        $remuneration_edit->splallowance = $request->splallowance;
        $remuneration_edit->dearness_allowance = $request->dearness_allowance;
        $remuneration_edit->conveyance = $request->conveyance;
        $remuneration_edit->lta = $request->lta;
        $remuneration_edit->medical = $request->medical;
        $remuneration_edit->other_allowance = $request->other_allowance;
        $remuneration_edit->gross_salary = $request->gross_salary;

        if ($remuneration_edit->save()) {

            return redirect('/EmpDetails/statutoryedit/' . $request->empid);
        }
    }

############### Statutory Details ##############
    public function statutory(Request $request, $id)
    {
        $emp_id = EmpDetails::findOrFail($id);
        return view('EmpDetails.statutory_details', ['model' => $emp_id]);
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
        if ($statutory->save()) {
            return redirect('/EmpDetails/bank/' . $request->empid);
        }

    }

    public function statutoryedit(Request $request, $id)
    {
        $emp_id = EmpDetails::findOrFail($id);
        if(EmpStatutorydetails::where(['empid'=>$id])->exists()){ 
            return view('EmpDetails.statutory_edit', ['model' => $emp_id]);  
        }else {
            return view('EmpDetails.statutory_details', ['model' => $emp_id]);
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
        if ($statutory_edit->save()) {
            return redirect('/EmpDetails/bankedit/' . $request->empid);
        }

    }

    ############### Bank Details ##############

    public function bank(Request $request, $id)
    {
        $emp_id = EmpDetails::findOrFail($id);
        return view('EmpDetails.bankdetails', ['model' => $emp_id]);
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

            return redirect('EmpDetails');
        }

    }
    public function bankedit(Request $request, $id)
    {
        $emp_id = EmpDetails::findOrFail($id);
        if(EmpBankdetails::where(['empid'=>$id])->exists()){ 
            return view('EmpDetails.bankdetails_edit', ['model' => $emp_id]);
        } else {
            return view('EmpDetails.bankdetails', ['model' => $emp_id]);
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

            return view('EmpDetails.index');
        }

    }

    public function empview(Request $request, $id)
    {
        $emp_id = EmpDetails::findOrFail($id);
        return view('EmpDetails.emp_detailsview', ['model' => $emp_id]);
    }

    public function importExportView()
    {
        return view('EmpDetails.import');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

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

}
