<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpDetails extends Model
{
    use HasFactory;
    protected $tabel = 'emp_details';
  //  protected $fillable = ['emp_code','emp_name','gender','designation_id','project_id','location_id','office_location','mail','email_personal','mobile','date_of_birth','age','blood_group','photo','department_id','date_of_joining','date_of_joining_lt','years_of_experience','date_of_offer','offer_accepted','date_of_leaving','last_appraisal_date','appraisal_due_date','renewal_offer_date','address_1','address_2',' 	address_3','address_4','address_5','address_6','address_7','address_8','status_id'];
  

    public function project()
    {
        return $this->belongsTo('App\Models\ProjectDetails', 'project_id');
    }
    public function department()
    {
        return $this->belongsTo('App\Models\Departments', 'department_id');
    }
    public function attend()
    {
        return $this->hasOne('App\Models\Attendance','emp_id');
    }
    public function designation()
    {
        return $this->belongsTo('App\Models\Designation', 'designation_id');
    }

    public function locations()
    {
        return $this->belongsTo('App\Models\Locations', 'location_id');
    }

    public function rem()
    {
        return $this->belongsTo('App\Models\EmpRemunerationDetails', 'id', 'empid');
    }
    public function statutory()
    {
        return $this->belongsTo('App\Models\EmpStatutorydetails', 'id', 'empid');
    }
    public function bank()
    {
        return $this->belongsTo('App\Models\EmpBankdetails', 'id', 'empid');
    }
    public function status()
    {
        return $this->belongsTo('App\Models\Statuses', 'status_id');
    }

    public function remuneration()
    {
        return $this->belongsTo('App\Models\EmpRemunerationDetails', 'id', 'empid');
    }
    public function getIndianCurrency(float $number)
    {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(0 => '', 1 => 'One', 2 => 'Two',
            3 => 'Three', 4 => 'four', 5 => 'Five', 6 => 'Six',
            7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
            13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
            19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
            40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
            70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
        $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
        while ($i < $digits_length) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str[] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
            } else {
                $str[] = null;
            }

        }
        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
        return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
    }

}
