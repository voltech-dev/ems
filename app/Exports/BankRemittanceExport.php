<?php
namespace App\Exports;

use App\Models\EmpDetails;
use App\Models\EmpSalary;
use App\Models\Designation;
use App\Models\ProjectDetails;
use App\Models\Locations;
use App\Models\Statuses;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\NamedRange;
use Maatwebsite\Excel\Events\AfterSheet;
error_reporting(0); 

class BankRemittanceExport implements FromCollection, WithMapping, WithHeadings, WithStyles, ShouldAutoSize
{

    private $project;
    private $StartDate;
    private $EndDate;

    public function __construct($project,$datefrom,$dateto,$month)
    {
        $this->project = $project;
        $this->StartDate = $datefrom;
        $this->EndDate = $dateto;
        $this->month = $month;
    }
   

    public function collection()
    {      
       $items[] = NULL;
       $project = $this->project;
       $month = $this->month;    
       $fdate = "01-".$month;
       $firstdate = date('Y-m-d',strtotime($fdate)); 
       $lastDayofMonth =    \Carbon\Carbon::parse($firstdate)->endOfMonth()->toDateString();
       $empdetails = EmpDetails::where('project_id','=',$this->project)->get();
       foreach($empdetails as $ee){
           $empsalary1 = EmpSalary::where(['empid'=>$ee->id])->whereBetween('month', [$firstdate,  $lastDayofMonth])->first();
          if($empsalary1){
              $items[] = $empsalary1->empid;
          }
       }
      // $empsalary = EmpSalary::whereIn('empid',$items)->whereBetween('month', [$firstdate,  $lastDayofMonth])->get();
      // return view('empsalary.salarystatement',['empsalary'=>$empsalary,'project'=>$project, 'month'=>$month]);  
      $empsalary = EmpSalary::whereIn('empid',$items)->whereBetween('month', [$firstdate,  $lastDayofMonth])->get();
      return $empsalary;
      $monthname = $empsalary->month;
        $month_name = date("M",strtotime($monthname));
        $yearName = date("Y",strtotime($monthname));
        $val = DateTime::createFromFormat('M', $month_name);
        $month_name2 = $val->format('M');
        echo $month_name2."'".$yearName."Salary";
    }

    public function map($empsalary): array
    {

        $fields = [
            21690400000063,
            $empsalary->employee->emp_name,
			$empsalary->employee->bank->acnumber,
            $empsalary->employee->bank->ifsc,
            $empsalary->total_earning-$empsalary->total_deduction + $empsalary->mobile_allowance +$empsalary->travel_allowance + $empsalary->laptop_allowance + $empsalary->conveyance_allowance,
            $empsalary->month,
            'NEFT',
            date('M',strtotime($empsalary->month))."'".date('Y',strtotime($empsalary->month))." Salary",
            'NEFT',
            $empsalary->employee->mobile,
            'hr.support@voltechgroup.com',
           
        ];
        return $fields;
    }

    public function headings(): array
    {
        return [
            'Debit Account No',
            'Beneficiary Name',
            'Beneficiary Account No',
            'Beneficiary Bank Swift Code / IFSC Code',
            'Payment Amount',
            'Value Date',
            'Message Type',
            'Remarks',
            'Transaction Type Code',
            'Beneficiary Mobile No',
            'Beneficiary E-mail Id',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $noRow = $sheet->getHighestRow();
        $sheet->setAutoFilter('');
        $sheet->freezePane('A2');
       $sheet->getStyle('A1:K1'.$noRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '40403F'],
                ],
            ],
 ]);
 return [
    1 => [
        'font' => ['bold' => true],],
    ];

    }

}
