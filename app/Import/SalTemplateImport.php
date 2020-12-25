<?php
namespace App\Import;

use App\Models\EmpSalaryUploads;
use App\Models\EmpDetails;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class SalTemplateImport implements ToModel, WithHeadingRow
{
    
    public $month;
    function __construct($data) {
            $this->month = '01-'.$data['sal_month'];
           // $this->customer = $customer;
    }

    public function model(array $row)
    {

        $Emp = EmpDetails::where('emp_code',$row['Emp Code'])->first();

        if (!isset($row['Emp Code'])) {
            return null;
        }      

        return new EmpSalaryUploads([  
            'empid'=>$Emp->id,
            'month'=>date('Y-m-d', strtotime($this->month)),                   
            'gross' => $Emp->remuneration->gross_salary,
            'leavedays' => $row['Leave'],           
            'lop_days' => $row['LOP'],
            'over_time'=> $row['OT'],
            'arrear' => $row['Arrear'],
            'advance' => $row['Advance'],
            'conveyance' => $row['Conveyance Allowance'],
            'laptop' => $row['Laptop Allowance'],
            'travel' => $row['Travel Allowance'],
            'mobile' => $row['Mobile Allowance'],
            'loan' => $row['Loan'],
            'insurance' => $row['Insurance'],
            'rent' => $row['Rent'],
            'tds' => $row['TDS'],
            'others' => $row['Others'],
            'status' => 'Uploaded',
        ]);
    }
}
?>
