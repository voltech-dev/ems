<?php
namespace App\Exports;

//use App\Models\Appraisals;
use App\Models\LeaveBalance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LeaveBalanceTemplate implements FromCollection, WithMapping, WithHeadings, WithStyles, ShouldAutoSize
{
   // public $month = null;
    public $project = null;

    public function __construct($data)
    {
    $this->project = $data['project'];
   // $this->month = $data['month'];
    } 

    public function collection()
    {
        return LeaveBalance::all();
    }

    public function map($row): array
    {
        $fields = [
            // $row->emp->emp_code,
            // $row->emp->emp_name,
            // $row->emp->designation->designation_name,
            '',
            '',
            '',
            '',
            '',

        ];
        return $fields;
    }

    public function headings(): array
    {
        return [
            'Employee Code',
            'Project Name',
            'Leave Balance',
            'Monthly Leave Eligibility',
            'Total Leave in a Year',                     
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $noRow = $sheet->getHighestRow();
        $sheet->setAutoFilter('A1:E1');
        $sheet->freezePane('A2');
        $sheet->getStyle('A2:E' . $noRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FFFF0000'],
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
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],

                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => ['argb' => 'FFFF0000'],
                    ],

                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FFFF0000'],
                    ],
                ],

            ],
        ];
    }

}
