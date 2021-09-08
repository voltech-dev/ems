<?php
namespace App\Import;

use Illuminate\Http\Request;
use App\Models\EmpDetails;
use App\Models\Appraisals;
use App\Models\LeaveBalance;
use App\Models\ProjectDetails;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class LeaveBalanceTemplateImport implements ToCollection, WithHeadingRow
{

   // public $month;
    public function __construct($data)
    {
       // $this->month = '01-' . $data['sal_month'];
        // $this->customer = $customer;
    }

    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {
            $Emp = EmpDetails::where('emp_code', $row['Employee Code'])->first();
            $proj = ProjectDetails::where('project_name', $row['Project Name'])->first();
           // print_r($proj);
            if (!isset($row['Employee Code'])) {
                return null;
            }
            $leave = new LeaveBalance();
            $leave->emp_id = $Emp->id;        
            $leave->project_id = $proj->id;            
            $leave->leavebalance = $row['Leave Balance'];
            $leave->monthlyleavepermit = $row['Monthly Leave Eligibility'];
            $leave->totalyearlyleave = $row['Total Leave in a Year'];    
            $leave->save();
        }
       
    }
}
