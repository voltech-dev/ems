<?php
namespace App\Imports;

use Illuminate\Http\Request;
use App\Models\EmpDetails;
use App\Models\EmpRemunerationDetails;
use App\Models\EmpStatutorydetails;
use App\Models\EmpStaffPayScales;
use App\Models\EmpBankdetails;
use App\Models\Designation;
use App\Models\ProjectDetails;
use App\Models\Locations;
use App\Models\Statuses;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class EmpImport implements ToCollection, WithHeadingRow
{
   
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
           if(EmpDetails::where('emp_code', $row['Emp Code'])->exists()){
            $uploaded = EmpDetails::where(['emp_code' =>$row['Emp Code']])->first();
           } else {
            $uploaded = new EmpDetails();
           }
        
            $uploaded->emp_code = $row['Emp Code'];
            $uploaded->emp_name = $row['Emp Name'];
            $uploaded->gender = $row['Gender'];      
            if(!empty($row['Designation'])) {
                $design =  Designation::where(['designation_name' =>$row['Designation']])->first();            
                $uploaded->designation_id = $design->id;
            }
            if(!empty($row['Project'])) {
                $project =  ProjectDetails::where(['project_name' =>$row['Project']])->first();
                $uploaded->project_id = $project->id;
            }
            if(!empty($row['Project Location'])) {
                $location =  Locations::where(['location' =>$row['Project Location']])->first();
                $uploaded->location_id = $location->id;
            }           
           
            $uploaded->office_location = $row['Office Location'];
            $uploaded->mail = $row['Mail'];
            $uploaded->mobile = $row['Mobile'];
            $uploaded->date_of_joining = date('Y-m-d', strtotime($row['Date Of Joining']));
            $uploaded->date_of_leaving = date('Y-m-d', strtotime($row['Date Of Leaving']));
            $uploaded->last_appraisal_date = date('Y-m-d', strtotime($row['Last Appraisal Date']));

            $status =  Statuses::where(['status' =>$row['Status']])->first();            
            $uploaded->status_id = $status->id;

            $uploaded->save();
            
           if($row['Salary Stucture'] == 'Market-based') {
            $remuneration = EmpRemunerationDetails::updateOrCreate(
                ['empid' =>  $uploaded->id],
                [
                    'salary_structure' =>$row['Salary Stucture'], 
                    'esi_applicability' => $row['ESI'],
                    'pf_applicablity' => $row['PF'],
                    'restrict_pf' => $row['Restrict PF'],
                    'basic' => $row['Basic'],
                    'hra' => $row['HRA'],
                    'splallowance' =>$row['Spl Allowance'],
                    'conveyance' => $row['Conveyance'],
                    'education' => $row['Education'],
                    'medical' => $row['Medical'],
                    'gross_salary' => $row['Gross Salary'] 
                ]
            );

        } else if($row['Salary Stucture'] == 'Modern'){

            $PayScale = EmpStaffPayScales::where(['salarystructure' => $row['Salary Stucture']])->first();

            $grossamount = $row['Gross Salary'];
            $basic = round($grossamount * $PayScale->basic);
            $hra = round($grossamount * $PayScale->hra);  
            $conveyance_allowance = round($PayScale->conveyance_allowance);
            $spl_allowance = round($grossamount - ($basic + $hra + $conveyance_allowance));

            $remuneration = EmpRemunerationDetails::updateOrCreate(
                ['empid' =>  $uploaded->id],
                [
                    'salary_structure' =>$row['Salary Stucture'], 
                    'esi_applicability' => $row['ESI'],
                    'pf_applicablity' => $row['PF'],
                    'restrict_pf' => $row['Restrict PF'],
                    'basic' =>  $basic,
                    'hra' =>  $hra,
                    'splallowance' =>$spl_allowance,
                    'conveyance' =>  $conveyance_allowance,                    
                    'gross_salary' => $row['Gross Salary'] 
                ]
            );
        }

            $statutory = EmpStatutorydetails::updateOrCreate(
                ['empid' =>  $uploaded->id],
                [
                    'esino' => $row['ESI No'], 
                    'esidispensary' => $row['ESI Dispensary'],
                    'epfno' => $row['EPF No'],
                    'epfuanno' => $row['EPF Uan No'],
                    'professionaltax' => $row['Professional tax'],
                    'gpa' => $row['GPA'],
                    'gmc' => $row['GMC'],
                    'gpa_agency' => $row['GPA Agency'],
                    'gmc_agency' => $row['GMC Agency'],
                ]
            );

            $flight = EmpBankdetails::updateOrCreate(
                ['empid' =>  $uploaded->id],
                [
                    'bankname' => $row['Bank Name'], 
                    'acnumber' => $row['Account Number'],
                    'branch' => $row['Branch'],
                    'ifsc' => $row['IFSC'],
                ]
            );
         

           /* date('Y-m-d', strtotime($this->month))
          
           
            `email_personal`,
            `date_of_birth`, `blood_group`, 
            `photo`, `department_id`, `date_of_joining`, 
            `date_of_offer`, `offer_accepted`, 
            `date_of_leaving`, `last_appraisal_date`, 
            `appraisal_due_date`, `address_1`, 
            `address_2`, `address_3`, `address_4`, 
            `address_5`, `address_6`, `address_7`, 
            `address_8`, `status_id`, `created_at`, 
            `updated_at`
           */
            
          
        }
        
       
    }
}
