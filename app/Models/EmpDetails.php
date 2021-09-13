<?php

namespace App\Models;
use App\Models\Attendance;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\carbon;
// use DB;

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
    public function in_time($id)
    {
        $date = date('Y-m-d');
        $intime = Attendance::where(['emp_id'=>$id,'date'=>$date])->first();
        return $intime->in_time;
    }
    public function out_time($id)
    {
        $date = date('Y-m-d');
        $outtime = Attendance::where(['emp_id'=>$id,'date'=>$date])->first();
        return $outtime->out_time;
    }
    public function att_status($id)
    {
        $date = date('Y-m-d');
        $att_status = Attendance::where(['emp_id'=>$id,'date'=>$date])->first();
        return $att_status->status;
    }
    public function designation()
    {
        return $this->belongsTo('App\Models\Designation', 'designation_id');
    }
    public function rating($id)
    {
        $score = Appraisals::where(['empid'=>$id])->first();
        return $score->score;
    }

    public function locations()
    {
        return $this->belongsTo('App\Models\Locations', 'location_id');
    }
    public function present($id,$day,$y){ 
                // $firstdates = $y."-".$day."-01";
                // $lastdate = $y."-".$day."-31";
                
                $firstdate = date('Y-m-d',strtotime($y."-".$day."-01")); 
                $lastdate =  date('Y-m-d',strtotime($y."-".$day."-31")); 

        $present = Attendance::where('emp_id',$id)->whereBetween('date', [$firstdate,  $lastdate])->whereIn('status', ['Present'])->count();
        $present1 = Attendance::where('emp_id',$id)->whereBetween('date', [$firstdate,  $lastdate])->whereIn('status', ['Half-Day'])->count();
        $val=$present1/2;
        $value = $present+ $val;
        return $value;
    }
    public function absent($id,$day,$y){  
        $firstdate = date('Y-m-d',strtotime($y."-".$day."-01")); 
        $lastdate =  date('Y-m-d',strtotime($y."-".$day."-31")); 
        $absent = Attendance::where('emp_id',$id)->whereBetween('date', [$firstdate,  $lastdate])->whereIn('status', ['Absent'])->count();       
        return $absent;
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
    public function paidleave($id,$day,$y)
    {
        $firstdate = date('Y-m-d',strtotime($y."-".$day."-01")); 
        $lastdate =  date('Y-m-d',strtotime($y."-".$day."-31")); 
        $paidleave = Leave::where('emp_id',$id)->where('action','Approved')->whereBetween('date_from', [$firstdate,  $lastdate])->whereIn('leave_type', ['pl'])->count(); 
        return $paidleave;
    }
    public function compoff($id,$day,$y)
    {
        $firstdate = date('Y-m-d',strtotime($y."-".$day."-01")); 
        $lastdate =  date('Y-m-d',strtotime($y."-".$day."-31")); 
        $compoff = Leave::where('emp_id',$id)->where('action','Approved')->whereBetween('date_from', [$firstdate,  $lastdate])->whereIn('leave_type', ['col'])->count(); 
        return $compoff;
    }
    public function weakoff($id,$day,$y)
    {
        $firstdate = date('Y-m-d',strtotime($y."-".$day."-01")); 
        $lastdate =  date('Y-m-d',strtotime($y."-".$day."-31")); 
        $weakoff = Attendance::where('emp_id',$id)->whereBetween('date', [$firstdate,  $lastdate])->whereIn('status', ['W.O'])->count();
        return $weakoff;
    }
    public function weakoffleave($id,$day,$y)
    {
        $firstdates = date('Y-m-d',strtotime($y."-".$day."-01")); 
        $lastdates =  date('Y-m-d',strtotime($y."-".$day."-31")); 
        $weakoffs = Attendance::where('emp_id',$id)->whereBetween('date', [$firstdates,  $lastdates])->whereIn('status', ['W.O'])->get();  
        foreach($weakoffs as $off){
            $counter = 1;
             $previousdate = date('Y-m-d', strtotime('-1 day', strtotime($off->date)));
             $nextdate = date('Y-m-d', strtotime('+1 day', strtotime($off->date)));
            $preday = Attendance::where('emp_id',8)->where('date', $previousdate)->first();            
            $nexday = Attendance::where('emp_id',8)->where('date', $nextdate)->first();  
            if($preday->status && $nexday->status == 'Absent'){               
              $conval =  $counter++;
            }else{
                $conval = 0;
            }
        }
        echo $counter*3;
    }
    public function holidays($projectid,$day,$y)
    {
        $firstdate = date('Y-m-d',strtotime($y."-".$day."-01")); 
        $lastdate =  date('Y-m-d',strtotime($y."-".$day."-31")); 
        $holiday = Holiday::where('project_id',$projectid)->whereBetween('holiday', [$firstdate,  $lastdate])->count(); 
        return $holiday;
    }
    public function unpaidleave($id,$day,$y)
    {
        $firstdate = date('Y-m-d',strtotime($y."-".$day."-01")); 
        $lastdate =  date('Y-m-d',strtotime($y."-".$day."-31")); 
        $paidleave = Leave::where('emp_id',$id)->where('action','Approved')->whereBetween('date_from', [$firstdate,  $lastdate])->whereIn('leave_type', ['upl'])->count(); 
        return $paidleave;
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