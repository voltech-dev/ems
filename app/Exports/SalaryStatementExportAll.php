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

class SalaryStatementExportAll implements FromCollection, WithMapping, WithHeadings, WithStyles, ShouldAutoSize
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

        $fields = [
            $empsalary->employee->emp_code,
            $empsalary->employee->emp_name,
			$empsalary->employee->designation->designation_name,
            $empsalary->employee->project->project_name,
            $empsalary->employee->date_of_joining,
            $empsalary->gross,
            $empsalary->basic,
            $empsalary->hra,
            $empsalary->conveyance_earning,
            $empsalary->medical_earning,
            $empsalary->education_earning,
            $empsalary->spl_allowance,
            $empsalary->gross,
            $empsalary->paiddays,
            $empsalary->paiddays,
            $empsalary->basic,
            $empsalary->hra,
            $empsalary->conveyance_earning,
            $empsalary->medical_earning,
            $empsalary->education_earning,
            $empsalary->spl_allowance,
            $empsalary->gross,
            $empsalary->pf_employer_contribution,
            $empsalary->esi_employer_contribution,
            $empsalary->professional_tax,
            $empsalary->tds,
            $empsalary->arrear,
            $empsalary->total_deduction,
            $empsalary->total_earning-$empsalary->total_deduction,
            $empsalary->conveyance_allowance,
            $empsalary->laptop_allowance,
            $empsalary->travel_allowance,
            $empsalary->mobile_allowance,
            $empsalary->total_earning-$empsalary->total_deduction + $empsalary->mobile_allowance +$empsalary->travel_allowance +$empsalary->laptop_allowance + $empsalary->conveyance_allowance,
            $empsalary->pf,
            $empsalary->pf_employer_contribution,
            $empsalary->esi_employer_contribution,
            $empsalary->insurance,
            $empsalary->earned_ctc,
            $empsalary->earned_ctc*6/100,
            $empsalary->earned_ctc+$empsalary->conveyance_allowance+$empsalary->laptop_allowance+$empsalary->travel_allowance+$empsalary->mobile_allowance+$empsalary->earned_ctc*6/100,
            round(($empsalary->earned_ctc+$empsalary->conveyance_allowance+$empsalary->laptop_allowance+$empsalary->travel_allowance+$empsalary->mobile_allowance+$empsalary->earned_ctc*6/100)*18/100,2),
            round(($empsalary->earned_ctc+$empsalary->conveyance_allowance+$empsalary->laptop_allowance+$empsalary->travel_allowance+$empsalary->mobile_allowance+$empsalary->earned_ctc*6/100)+(($empsalary->earned_ctc+$empsalary->conveyance_allowance+$empsalary->laptop_allowance+$empsalary->travel_allowance+$empsalary->mobile_allowance+$empsalary->earned_ctc*6/100)*18/100),2),
           
        ];
        return $fields;
    }

    public function headings(): array
    {
        return [
            'Emp Code',
            'Candidate Name',
            'Designation',
            'Project',
            'DOJ',
            'Gross Salary',
            'Basic',
            'HRA',
            'Conv Allowance',
            'Medical Allowance',
            'Education Allowance',
            'Spl Allowance',
            'Gross',
            'Month Days',
			'Pay Days',
            'Basic',
            'HRA',
            'Conv Allowance',
            'Medical Allowance',
            'Education Allowance',
            'Spl Allowance',
            'Gross',
            'EPF',
            'ESI',
            'PT',
            'TDS',
            'Arrear Deduction',
            'Total Deduction',
            'Net Salary',
            'Conveyance Allowance',
            'Laptop Allowance',
            'Travel Allowance',
            'Mobile Allowance',
            'Take Home Salary',
            'EMR EPF',
            'EPF Admin',
            'EMR ESI',
            'Insurances (GPA + GMC + WC)',
            'Monthly CTC',
            'Service Charge',
            'Total Basic Invoice',
            'GST @ 18%',
            'Total Invoice Value',          
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $noRow = $sheet->getHighestRow();
        $sheet->setAutoFilter('');
        $sheet->freezePane('A2');
       $sheet->getStyle('A2:AQ'.$noRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '40403F'],
                ],
            ],
 ]);

    }

}
