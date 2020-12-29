<?php
namespace App\Exports;

use App\Models\EmpDetails;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
error_reporting(0);

class EmpExport implements FromCollection, WithMapping, WithHeadings, WithStyles, ShouldAutoSize
{

    public function collection()
    {
        return EmpDetails::all();
    }

    public function map($row): array
    {
        $fields = [
            $row->emp_code,
            $row->emp_name,
            $row->designation->designation_name,
            $row->project->project_name,
            $row->location->location,
            $row->mail,
            $row->mobile,
            $row->date_of_joining,
            $row->date_of_leaving,
            $row->last_appraisal_date,
            $row->status->status,
            $row->rem->salary_structure,
            $row->rem->esi_applicability,
            $row->rem->pf_applicablity,
            $row->rem->restrict_pf,
            $row->rem->basic,
            $row->rem->hra,
            $row->rem->conveyance,
            $row->rem->medical,
            $row->rem->education,
            $row->rem->splallowance,
            $row->rem->gross_salary,
            $row->statutory->esino,
            $row->statutory->esidispensary,
            $row->statutory->epfno,
            $row->statutory->epfuanno,
            $row->statutory->professionaltax,
            $row->statutory->gpa,
            $row->statutory->gmc,
            $row->bank->bankname,
            $row->bank->acnumber,
            $row->bank->branch,
            $row->bank->ifsc,	
        ];
        return $fields;
    }

    public function headings(): array
    {
        return [
            'Emp Code',
            'Emp Name',
            'Designation',
            'Project',
            'Location',
            'Mail',
            'Mobile',
            'Date Of Joining',
            'Date Of Leaving',
            'Last Appraisal Date',
            'Status',
            'Salary Stucture',
            'ESI',
            'PF',
            'Restrict PF',
            'Basic',
            'Hra',
            'Conveyance',
            'Medical',
            'Education',
            'Spl Allowance',
            'Gross Salary',
            'Esi No',
            'Esi Dispensary',
            'Epf No',
            'Epf Uan No',
            'Professional tax',
            'Gpa',
            'Gmc',
            'Bank Name',
            'Account Number',
            'Branch',
            'IFSC',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $noRow = $sheet->getHighestRow();
        $sheet->setAutoFilter('A1:AG1');
        $sheet->freezePane('A2');
       $sheet->getStyle('A2:AG'.$noRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '40403F'],
                ],
            ],
 ]);
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'FFE5E5E5'],
                ],
                'alignment' => [
                    'horizontal' =>\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],

                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => ['argb' => '40403F'],
                    ],
               
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '40403F'],
                    ],
                ],
                
            ],
        ];
    }

}
