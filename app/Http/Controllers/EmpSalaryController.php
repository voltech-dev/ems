<?php
namespace App\Http\Controllers;

use App\Models\Dtssp;
use App\Models\EmpDetails;
use App\Models\EmpSalaryUploads;
use App\Models\SalaryMonths;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalTemplate;
use App\Import\SalTemplateImport;

class EmpSalaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
      return Excel::import(new SalTemplateImport($data), request()->file('file_upload'));
     
    }
}
