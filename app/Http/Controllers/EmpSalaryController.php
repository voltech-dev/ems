<?php
namespace App\Http\Controllers;

use App\Exports\SalTemplate;
use App\Import\SalTemplateImport;
use App\Models\Dtssp;
use App\Models\EmpDetails;
use App\Models\EmpSalaryUploads;
use App\Models\SalaryMonths;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EmpSalaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        return view('empsalary.index');
    }

    public function viewdata(Request $request)
    {

        $jointable =
            [
            ['table' => 'emp_details AS b', 'on' => 'a.project_id=b.id', 'join' => 'JOIN'],
            ['table' => 'project_details AS c', 'on' => 'a.project_id=b.id', 'join' => 'JOIN'],
            ['table' => 'designations AS d', 'on' => 'a.designation_id=c.id', 'join' => 'JOIN'],
            ['table' => 'locations AS e', 'on' => 'a.location_id=d.id', 'join' => 'LEFT JOIN'],
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
        ['db' => 'a.id', 'dt' => 0, 'field' => 'id'],
        ['db' => 'b.emp_code', 'dt' => 1, 'field' => 'emp_code'],
        ['db' => 'b.emp_name', 'dt' => 2, 'field' => 'emp_name'],      
        ['db' => 'c.project_name', 'dt' => 3, 'field' => 'project_name'],       
        ['db' => 'a.id', 'dt' => 4, 'field' => 'id'],
        ['db' => 'a.leavedays', 'dt' => 5, 'field' => 'leavedays'],
        ['db' => 'a.lop_days', 'dt' => 6, 'field' => 'lop_days'],
        ['db' => 'a.conveyance', 'dt' => 7, 'field' => 'conveyance'],
        ['db' => 'a.laptop', 'dt' => 8, 'field' => 'laptop'],
        ['db' => 'a.travel', 'dt' => 9, 'field' => 'travel'],
        ['db' => 'a.mobile', 'dt' => 10, 'field' => 'mobile'],
        ['db' => 'a.tds', 'dt' => 11, 'field' => 'tds'],
    ];
    // $where = 'status=>Entry Completed';
    echo json_encode(
        Dtssp::simple($_GET, 'emp_salary_uploads AS a', 'a.id', $columns, $jointable, $where = null)
    );
    }

    public function salaryprocess(Request $request)
    {
        $postInput = json_decode(file_get_contents('php://input'), true);
        $result = "";
        foreach ($postInput as $line){
               $result .= $line['0'].',';
       };
       header('Content-Type: application/json');
       echo json_encode(['html' => $result]);
        
    }

    public function salarymonth(Request $request)
    {
        return view('salary_month');
    }

    public function addmonth(Request $request)
    {

        $month = '01-' . $request->month;
        $currentmonth = date('Y-m-d', strtotime($month));

        $salarymonth = date('Y-m', strtotime($currentmonth));
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
                    if ($empdojmonth <= $salarymonth) {
                        $modelupload = new EmpSalaryUploads();
                        $modelupload->empid = $emp->id;
                        $modelupload->month = date('Y-m', strtotime($month));
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

    }

    public function monthstore(Request $request)
    {
        $month = '01-' . $request->sal_month;
        $currentmonth = date('Y-m-d', strtotime($month));

        $salarymonth = date('Y-m', strtotime($currentmonth));

        $salmonth = SalaryMonths::where(['month' => $currentmonth])->first();
        $uploadedmonth = EmpSalaryUploads::where(['status' => 'Uploaded'])->first();
        if (!$uploadedmonth && !$salmonth) {
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
            return redirect()->back()->with(['error' => 'The Salary Month is Already Generated.']);
        }

    }
    public function salaryupload(Request $request)
    {
        return view('empsalary.salaryupload');
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
}
