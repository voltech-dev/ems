<?php
namespace App\Import;

use Illuminate\Http\Request;
use App\Models\EmpDetails;
use App\Models\EmpSalaryUploads;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class SalTemplateImport implements ToCollection, WithHeadingRow
{

    public $month;
    public function __construct($data)
    {
        $this->month = '01-' . $data['sal_month'];
        // $this->customer = $customer;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $Emp = EmpDetails::where('emp_code', $row['Emp Code'])->first();

            if (!isset($row['Emp Code'])) {
                return null;
            }

            $uploaded = EmpSalaryUploads::where(['empid' => $Emp->id, 'month' => date('Y-m-d', strtotime($this->month))])->first();

            $uploaded->leavedays = $row['Leave'];
            $uploaded->lop_days = $row['LOP'];
            $uploaded->over_time = $row['OT'];
            $uploaded->arrear = $row['Arrear'];
            $uploaded->advance = $row['Advance'];
            $uploaded->conveyance = $row['Conveyance Allowance'];
            $uploaded->laptop = $row['Laptop Allowance'];
            $uploaded->travel = $row['Travel Allowance'];
            $uploaded->mobile = $row['Mobile Allowance'];
            $uploaded->loan = $row['Loan'];
            $uploaded->insurance = $row['Insurance'];
            $uploaded->rent = $row['Rent'];
            $uploaded->tds = $row['TDS'];
            $uploaded->others = $row['Others'];
            $uploaded->status = 'Uploaded';
            $uploaded->save();
        }
       
    }
}
