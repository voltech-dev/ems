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

class ESIRemittanceExport implements FromCollection, WithMapping, WithHeadings, WithStyles, ShouldAutoSize
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
      $empsalary = EmpSalary::whereIn('empid',$items)->whereBetween('month', [$firstdate,  $lastDayofMonth])->get();
      return $empsalary;    
    }

    public function map($empsalary): array
    {
        $ncp = $empsalary->employee->ncpdayspresent($empsalary->empid,$empsalary->month);
        if($ncp > 0){
            $ncp = $ncp;
        } else {
            $ncp = '0';
        }
        $fields = [
            $empsalary->employee->statutory->esino,
			$empsalary->employee->emp_code,
            $empsalary->employee->emp_name,
            $empsalary->employee->project->project_name,
            $empsalary->gross,
            round($empsalary->gross*0.75/100),
            round($empsalary->gross*3.25/100),
            $ncp,
        ];
        return $fields;
    }

    public function headings(): array
    {
        return [
            'ESI No',
            'Employee Code',
            'Employee Name',
            'Branch',
            'Gross Pay',
            'ESI Amount 0.75%',
            'ESI Amount 3.25%',
            'NCP Days ',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $noRow = $sheet->getHighestRow();
        $sheet->setAutoFilter('');
        $sheet->freezePane('A2');
       $sheet->getStyle('A1:H1'.$noRow)->applyFromArray([
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
