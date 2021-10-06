<?php
namespace App\Exports;

use App\Models\EmpDetails;
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

class EmpExport implements FromCollection, WithMapping, WithHeadings, WithStyles, ShouldAutoSize
{

    public function collection()
    {
        return EmpDetails::find(3);
    }

    public function map($row): array
    {
        $fields = [
            $row->emp_code,
            $row->emp_name,
			$row->gender,
            $row->designation->designation_name,
            $row->department->department_name,
            $row->project->project_name,
            $row->location->location,
			$row->office_location,
            $row->mail,
            $row->mobile,
            $row->address_1.$row->address_2.$row->address_3.$row->address_4.$row->address_5.$row->address_6.$row->address_7.$row->address_8,
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
			$row->statutory->gpa_agency,
            $row->statutory->gmc,
			$row->statutory->gmc_agency,
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
			'Gender',
            'Designation',
            'Department',
            'Project',
            'Project Location',
			'Office Location',
            'Mail',
            'Mobile',
            'Address',
            'Date Of Joining',
            'Date Of Leaving',
            'Last Appraisal Date',
            'Status',
            'Salary Stucture',
            'ESI',
            'PF',
            'Restrict PF',
            'Basic',
            'HRA',
            'Conveyance',
            'Medical',
            'Education',
            'Spl Allowance',
            'Gross Salary',
            'ESI No',
            'ESI Dispensary',
            'EPF No',
            'EPF Uan No',
            'Professional tax',
            'GPA',
			'GPA Agency',
            'GMC',
			'GMC Agency',
            'Bank Name',
            'Account Number',
            'Branch',
            'IFSC',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $noRow = $sheet->getHighestRow();
        $sheet->setAutoFilter('A1:AK1');
        $sheet->freezePane('A2');
       $sheet->getStyle('A2:AK'.$noRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '40403F'],
                ],
            ],
 ]);
 
 
 // Designation row BA
$designation = Designation::all();
$drow = 2;
foreach ($designation as $design) {
   $designationArray = array(
       $design->designation_name,
   );
   $sheet->fromArray($designationArray, NULL, 'BA' . $drow++);
   $sheet->getColumnDimension('BA')->setVisible(false);
}
$drow--;
$designationcounter = $drow; 


 // Project row BB
$Projects = ProjectDetails::all();
$prow = 2;
foreach ($Projects as $Project) {
   $ProjectArray = array(
       $Project->project_name,
   );
   $sheet->fromArray($ProjectArray, NULL, 'BB' . $prow++);
   $sheet->getColumnDimension('BB')->setVisible(false);
}
$prow--;
$projectcounter = $prow; 


 // LOcation row BB
$locations = Locations::all();
$lrow = 2;
foreach ($locations as $location) {
   $locationArray = array(
       $location->location,
   );
   $sheet->fromArray($locationArray, NULL, 'BC' . $lrow++);
   $sheet->getColumnDimension('BC')->setVisible(false);
}
$lrow--;
$locationcounter = $lrow; 


 // STATUS row BC
$statuses = Statuses::all();
$srow = 2;
foreach ($statuses as $status) {
   $statusArray = array(
       $status->status,
   );
   $sheet->fromArray($statusArray, NULL, 'BD' . $srow++);
   $sheet->getColumnDimension('BD')->setVisible(false);
}
$srow--;
$statuscounter = $srow; 
 
 $model = EmpDetails::all();
 $i=2;

 foreach($model as $emp)
	{	   
	    $objValidation = $sheet->getCell('D'.$i)->getDataValidation();
        $objValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );		
        $objValidation->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
        $objValidation->setAllowBlank(false);
        $objValidation->setShowInputMessage(true);
        $objValidation->setShowErrorMessage(true);
        $objValidation->setShowDropDown(true);      
        $objValidation->setFormula1('=$BA$2:$BA$' . $designationcounter);	
		
		$objValidation1 = $sheet->getCell('C' . $i)->getDataValidation();
		$objValidation1->setType(DataValidation::TYPE_LIST);
		$objValidation1->setErrorStyle(DataValidation::STYLE_INFORMATION);
		$objValidation1->setAllowBlank(true);
		$objValidation1->setShowInputMessage(true);
		$objValidation1->setShowErrorMessage(true);
		$objValidation1->setShowDropDown(true);
		$objValidation1->setFormula1('"Male,Female,Other"');
		
		$objValidation2 = $sheet->getCell('O' . $i)->getDataValidation();
		$objValidation2->setType(DataValidation::TYPE_LIST);
		$objValidation2->setErrorStyle(DataValidation::STYLE_INFORMATION);
		$objValidation2->setAllowBlank(true);
		$objValidation2->setShowInputMessage(true);
		$objValidation2->setShowErrorMessage(true);
		$objValidation2->setShowDropDown(true);
		$objValidation2->setFormula1('"Yes,No"');
		
		$objValidation2 = $sheet->getCell('O' . $i)->getDataValidation();
		$objValidation2->setType(DataValidation::TYPE_LIST);
		$objValidation2->setErrorStyle(DataValidation::STYLE_INFORMATION);
		$objValidation2->setAllowBlank(true);
		$objValidation2->setShowInputMessage(true);
		$objValidation2->setShowErrorMessage(true);
		$objValidation2->setShowDropDown(true);
		$objValidation2->setFormula1('"Yes,No"');
		
		$objValidation3 = $sheet->getCell('P' . $i)->getDataValidation();
		$objValidation3->setType(DataValidation::TYPE_LIST);
		$objValidation3->setErrorStyle(DataValidation::STYLE_INFORMATION);
		$objValidation3->setAllowBlank(true);
		$objValidation3->setShowInputMessage(true);
		$objValidation3->setShowErrorMessage(true);
		$objValidation3->setShowDropDown(true);
		$objValidation3->setFormula1('"Yes,No"');
		
		$objValidation4 = $sheet->getCell('Q' . $i)->getDataValidation();
		$objValidation4->setType(DataValidation::TYPE_LIST);
		$objValidation4->setErrorStyle(DataValidation::STYLE_INFORMATION);
		$objValidation4->setAllowBlank(true);
		$objValidation4->setShowInputMessage(true);
		$objValidation4->setShowErrorMessage(true);
		$objValidation4->setShowDropDown(true);
		$objValidation4->setFormula1('"Yes,No"');
		
		$objValidation5 = $sheet->getCell('AC' . $i)->getDataValidation();
		$objValidation5->setType(DataValidation::TYPE_LIST);
		$objValidation5->setErrorStyle(DataValidation::STYLE_INFORMATION);
		$objValidation5->setAllowBlank(true);
		$objValidation5->setShowInputMessage(true);
		$objValidation5->setShowErrorMessage(true);
		$objValidation5->setShowDropDown(true);
		$objValidation5->setFormula1('"Yes,No"');
		
		$objValidation6 = $sheet->getCell('E'.$i)->getDataValidation();
        $objValidation6->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );		
        $objValidation6->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
        $objValidation6->setAllowBlank(false);
        $objValidation6->setShowInputMessage(true);
        $objValidation6->setShowErrorMessage(true);
        $objValidation6->setShowDropDown(true);      
        $objValidation6->setFormula1('=$BB$2:$BB$' . $projectcounter);	
		
		$objValidation7 = $sheet->getCell('F'.$i)->getDataValidation();
        $objValidation7->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );		
        $objValidation7->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
        $objValidation7->setAllowBlank(false);
        $objValidation7->setShowInputMessage(true);
        $objValidation7->setShowErrorMessage(true);
        $objValidation7->setShowDropDown(true);      
        $objValidation7->setFormula1('=$BC$2:$BC$' . $locationcounter);	
		
		$objValidation8 = $sheet->getCell('M'.$i)->getDataValidation();
        $objValidation8->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );		
        $objValidation8->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
        $objValidation8->setAllowBlank(false);
        $objValidation8->setShowInputMessage(true);
        $objValidation8->setShowErrorMessage(true);
        $objValidation8->setShowDropDown(true);      
        $objValidation8->setFormula1('=$BD$2:$BD$' . $statuscounter);	
		
		$objValidation9 = $sheet->getCell('N' . $i)->getDataValidation();
		$objValidation9->setType(DataValidation::TYPE_LIST);
		$objValidation9->setErrorStyle(DataValidation::STYLE_INFORMATION);
		$objValidation9->setAllowBlank(true);
		$objValidation9->setShowInputMessage(true);
		$objValidation9->setShowErrorMessage(true);
		$objValidation9->setShowDropDown(true);
		$objValidation9->setFormula1('"Market-based,Modern"');
   
		$i++;		
	 }
   
 
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
