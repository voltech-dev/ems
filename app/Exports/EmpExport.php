<?php
namespace App\Exports;

use App\Models\EmpDetails;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

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
        ];
        return $fields;
    }

    public function headings(): array
    {
        return [
            'Emp Code',
            'Emp Name',
            'Designation',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $noRow = $sheet->getHighestRow();
        $sheet->setAutoFilter('A1:C1');
        $sheet->freezePane('A2');
       $sheet->getStyle('A2:C'.$noRow)->applyFromArray([
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
                    'horizontal' =>\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
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
