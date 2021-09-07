<?php
namespace App\Import;

use Illuminate\Http\Request;
use App\Models\EmpDetails;
use App\Models\Appraisals;
use App\Models\ProjectDetails;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Carbon\Carbon;

HeadingRowFormatter::default('none');

class AppraisalTemplateImport implements ToCollection, WithHeadingRow
{

   // public $month;
    public function __construct($data)
    {
       // $this->month = '01-' . $data['sal_month'];
        // $this->customer = $customer;
    }

    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {
            $Emp = EmpDetails::where('emp_code', $row['Emp Code'])->first();
            $proj = ProjectDetails::where('project_name', $row['Project Name'])->first();
            if (!isset($row['Emp Code'])) {
                return null;
            }
            $uploaded = new Appraisals();
            $uploaded->evaluatorname = $row['Evaluator Name'];
            $uploaded->evaluatorid = $row['Evaluator ID'];
            $uploaded->empid = $Emp->id;
            $uploaded->project_id = $proj->id;
            $uploaded->review_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['Review Date'])->format('Y-m-d');
            $uploaded->review_period = $row['Review Period'];
            $uploaded->workefficiency = $row['work Efficiency'];
            $uploaded->responsibility = $row['Responsibility'];
            $uploaded->teamwork = $row['Team Work'];
            $uploaded->timemngt = $row['Time Management'];
            $uploaded->communication = $row['Communication'];
            $uploaded->problemsolving = $row['Problem Solving'];
            $uploaded->integrity = $row['Integrity'];
            $uploaded->attendance = $row['Attendance'];
            $uploaded->score = $row['Overall Score'];
            $uploaded->noteworthy = $row['Noteworthy accomplishments during this review period'];
            $uploaded->suggestion = $row['Suggestions for Performance Improvements'];
            $uploaded->evaluation = $row['Overall Evaluation Feedbacks'];
            $uploaded->recommendation = $row['Recommendation for Increment in % (As per Policy)'];
            $uploaded->promotion = $row['Recommendation for Promotion in % (As per Policy)'];
            $uploaded->promotion_category = $row['If Yes, Mention Role'];
            $uploaded->role = $row['Recommendation for Change in Role/Designation'];
            $uploaded->role_description = $row['If Yes, Role/Designation'];
            $uploaded->flag = "1";
            $uploaded->save();
        }
       
    }
}
