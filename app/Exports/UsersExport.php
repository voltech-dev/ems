<?php

namespace App\Exports;

//use App\Models\User;
//use Maatwebsite\Excel\Concerns\FromCollection;

//use Maatwebsite\Excel\Concerns\WithHeadings;

//namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use App\Models\EmpDetails;
use App\Country;
use App\State;
use App\Batch;

class UsersExport implements WithHeadings, WithTitle, ShouldAutoSize, WithEvents
{

    public function headings(): array
    {
        return [
            [],
            ['Empname',    'Empcode']
        ];
    }

    public function title(): string
    {
        return 'Cases';
    }

    public function registerEvents(): array
    {

        return [
            AfterSheet::class    => function (AfterSheet $event) {

                $styleArray = [
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],

                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['argb' => 'FFE5E5E5'],
                    ],
                ];

                $styleArray2 = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FFFF0000'],
                        ],
                    ],
                ];

                /*$countries = Country::all();
                $country = '';
                foreach ($countries as $C) {
                    $country .= $C->country_name . ',';
                }

                $states = State::all();
                $state = '';
                foreach ($states as $S) {
                    $state .= $S->state_name . ',';
                }*/

                $cellRange = 'A1:B1';
              
               // $event = sheet->getCell('A1', 'empname');
				//$event = sheet->getCell('B1', 'empcode');
					
                
               // $sheet->setCellValue('B', 'empcode');
              // $event->sheet->setCellValue('A2','empname');
               // $event->sheet->getCellValue('B','empcode');
                /*$event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                
                $event->sheet->mergeCells("G1:N1")->setCellValue('G1', "Present Address");
               // $event->sheet->mergeCells("O1:V1")->setCellValue('O1', "Present Address");
                $event->sheet->mergeCells("O1:W1")->setCellValue('O1', "Office Details");
                $event->sheet->mergeCells("X1:AB1")->setCellValue('X1', "Checks Required");
                $event->sheet->getStyle('A1:AB2')->applyFromArray($styleArray);
                $event->sheet->getStyle('A1:AB2')->applyFromArray($styleArray2);
                for ($i = 3; $i <= 100; $i++) {
                    $objValidation1 = $event->sheet->getCell('F' . $i)->getDataValidation();
                    $objValidation1->setType(DataValidation::TYPE_LIST);
                    $objValidation1->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $objValidation1->setAllowBlank(true);
                    $objValidation1->setShowInputMessage(true);
                    $objValidation1->setShowErrorMessage(true);
                    $objValidation1->setShowDropDown(true);
                    $objValidation1->setFormula1('"Male,Female,Others"');
                }

               /* for ($i = 3; $i <= 100; $i++) {
                    $objValidation2 = $event->sheet->getCell('M' . $i)->getDataValidation();
                    $objValidation2->setType(DataValidation::TYPE_LIST);
                    $objValidation2->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $objValidation2->setAllowBlank(true);
                    $objValidation2->setShowInputMessage(true);
                    $objValidation2->setShowErrorMessage(true);
                    $objValidation2->setShowDropDown(true);
                    $objValidation2->setFormula1('"' . $country . '"');
                }

                for ($i = 3; $i <= 100; $i++) {
                    $objValidation3 = $event->sheet->getCell('L' . $i)->getDataValidation();
                    $objValidation3->setType(DataValidation::TYPE_LIST);
                    $objValidation3->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $objValidation3->setAllowBlank(true);
                    $objValidation3->setShowInputMessage(true);
                    $objValidation3->setShowErrorMessage(true);
                    $objValidation3->setShowDropDown(true);
                    $objValidation3->setFormula1('"' . $state . '"');
                }
                /*for ($i = 3; $i <= 100; $i++) {
                    $objValidation4 = $event->sheet->getCell('U' . $i)->getDataValidation();
                    $objValidation4->setType(DataValidation::TYPE_LIST);
                    $objValidation4->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $objValidation4->setAllowBlank(true);
                    $objValidation4->setShowInputMessage(true);
                    $objValidation4->setShowErrorMessage(true);
                    $objValidation4->setShowDropDown(true);
                    $objValidation4->setFormula1('"' . $state . '"');
                }
                for ($i = 3; $i <= 100; $i++) {
                    $objValidation5 = $event->sheet->getCell('V' . $i)->getDataValidation();
                    $objValidation5->setType(DataValidation::TYPE_LIST);
                    $objValidation5->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $objValidation5->setAllowBlank(true);
                    $objValidation5->setShowInputMessage(true);
                    $objValidation5->setShowErrorMessage(true);
                    $objValidation5->setShowDropDown(true);
                    $objValidation5->setFormula1('"' . $country . '"');
                }*/

                /*for ($i = 3; $i <= 100; $i++) {
                    $objValidation6 = $event->sheet->getCell('X' . $i)->getDataValidation();
                    $objValidation6->setType(DataValidation::TYPE_LIST);
                    $objValidation6->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $objValidation6->setAllowBlank(true);
                    $objValidation6->setShowInputMessage(true);
                    $objValidation6->setShowErrorMessage(true);
                    $objValidation6->setShowDropDown(true);
                    $objValidation6->setFormula1('"Yes,No"');
                }

                for ($i = 3; $i <= 100; $i++) {
                    $objValidation7 = $event->sheet->getCell('Y' . $i)->getDataValidation();
                    $objValidation7->setType(DataValidation::TYPE_LIST);
                    $objValidation7->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $objValidation7->setAllowBlank(true);
                    $objValidation7->setShowInputMessage(true);
                    $objValidation7->setShowErrorMessage(true);
                    $objValidation7->setShowDropDown(true);
                    $objValidation7->setFormula1('"Yes,No"');
                }
                for ($i = 3; $i <= 100; $i++) {
                    $objValidation8 = $event->sheet->getCell('Z' . $i)->getDataValidation();
                    $objValidation8->setType(DataValidation::TYPE_LIST);
                    $objValidation8->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $objValidation8->setAllowBlank(true);
                    $objValidation8->setShowInputMessage(true);
                    $objValidation8->setShowErrorMessage(true);
                    $objValidation8->setShowDropDown(true);
                    $objValidation8->setFormula1('"Yes,No"');
                }
                for ($i = 3; $i <= 100; $i++) {
                    $objValidation9 = $event->sheet->getCell('AA' . $i)->getDataValidation();
                    $objValidation9->setType(DataValidation::TYPE_LIST);
                    $objValidation9->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $objValidation9->setAllowBlank(true);
                    $objValidation9->setShowInputMessage(true);
                    $objValidation9->setShowErrorMessage(true);
                    $objValidation9->setShowDropDown(true);
                    $objValidation9->setFormula1('"Yes,No"');
                }
                for ($i = 3; $i <= 100; $i++) {
                    $objValidation10 = $event->sheet->getCell('AB' . $i)->getDataValidation();
                    $objValidation10->setType(DataValidation::TYPE_LIST);
                    $objValidation10->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $objValidation10->setAllowBlank(true);
                    $objValidation10->setShowInputMessage(true);
                    $objValidation10->setShowErrorMessage(true);
                    $objValidation10->setShowDropDown(true);
                    $objValidation10->setFormula1('"Yes,No"');
                }*/
            },
        ];
    }
}
