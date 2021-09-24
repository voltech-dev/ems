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

class EPFRemittanceExportAll implements FromCollection, WithMapping, WithHeadings, WithStyles, ShouldAutoSize
{

    private $empsalary;
    public function __construct($empsalary)
    {
        $this->empsalary = $empsalary;
    }
  
    public function collection()
    {    
        $empsalary = EmpSalary::get();       
        return $empsalary;     
    }

    public function map($empsalary): array
    {
        $ncp = $empsalary->employee->ncpdays($empsalary->empid,$empsalary->month);
        if($ncp > 0){
            $ncp = $ncp;
        } else {
            $ncp = '0';
        }
        if($empsalary->gross > 15000){
            $EPScontribution = '1250';
        }else{
            $check = round($empsalary->gross*0.0833);
        $EPScontribution = $check;
        }
        $fields = [
            $empsalary->employee->statutory->epfuanno,
			$empsalary->employee->emp_code,
            $empsalary->employee->emp_name,
            $empsalary->employee->project->project_name,
            $empsalary->gross,
            $empsalary->gross-$empsalary->hra,
            $empsalary->gross-$empsalary->hra,
            $empsalary->gross-$empsalary->hra,
            $empsalary->pf,
            $EPScontribution,
            $empsalary->pf-$EPScontribution,
            $ncp,
            
        ];
        return $fields;
    }

    public function headings(): array
    {
        return [
            'UAN Number',
            'Employee Code',
            'Employee Name',
            'Branch',
            'Gross Pay',
            'EPF Wages',
            'EPS Wages',
            'EDLIC Wages',
            'EPF Contribution',
            'EPS Contribution',
            'Difference EPF & EPS ',
            'NCP Days ',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $noRow = $sheet->getHighestRow();
        $sheet->setAutoFilter('');
        $sheet->freezePane('A2');
        $sheet->getStyle('A1:L1'.$noRow)->applyFromArray([
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
