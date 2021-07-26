@extends('layouts.blain')
@section('content')
<style>
table,
th,
td {
    border: 1px solid black;
    border-collapse: collapse;
    padding: 1px;
    font-family: "Times New Roman", Times, serif;
}

p,
ol {
    font-family: "Times New Roman", Times, serif;
    font-size: 10px;
    text-align: justify;
}

li {
    margin: 10px 0;
}
</style>
<?php
error_reporting(0);

$detail = App\Models\Exits::where(['empid'=>$model->id])->first();
// {{ ($detail->salary ? $detail->salary : 'NA')+($detail->bonus ? $detail->bonus : 'NA')+($detail->comp_salary ? $detail->comp_salary : 'NA')+($detail->dues ? $detail->dues : 'NA')+($detail->security_deposit ? $detail->security_deposit : 'NA')}}
$var = $detail->salary + $detail->bonus +$detail->comp_salary+$detail->dues+$detail->security_deposit;
$var1 = $detail->advance +$detail->salary_ded +$detail->tes +$detail->epf +$detail->esi +$detail->admin +$detail->pt +$detail->loan;
$rem = App\Models\EmpRemunerationDetails::where(['empid'=>$model->id])->first();

$m = date("m", strtotime($model->month));
$y = date("Y", strtotime($model->month));
$maxDays = cal_days_in_month(CAL_GREGORIAN, $m, $y);
$remunerat = App\Models\EmpRemunerationDetails::where(['empid'=>$model->id])->first();

	if ($model->statutory->professionaltax == 'Yes') {
		if ($remunerat->gross_salary > 12500) {
				$professional_tax = 209;
			} else if ($remunerat->gross_salary <= 12500 && $remunerat->gross_salary > 10000) {
				$professional_tax = 171;
			} else if ($remunerat->gross_salary <= 10000 && $remunerat->gross_salary > 7500) {
				$professional_tax = 115;
			} else if ($remunerat->gross_salary <= 7500 && $remunerat->gross_salary > 5000) {
				$professional_tax = 53;
			} else if ($remunerat->gross_salary <= 5000 && $remunerat->gross_salary > 3500) {
				$professional_tax = 23;
			} else {
				$professional_tax = 0;
			}
	}
		$pfpf =  App\Models\Providentfunddetails::first();
		$esiesi =  App\Models\Esidetails::first();
	
			$pf_rates = $pfpf->employee_pf;
			$esi_rates = $esiesi->employee_esi;
			$pf_emr_rates = $pfpf->employer_pf;
			$esi_emr_rates = $esiesi->employer_esi;
		
	  $pf_wages = $remunerat->gross_salary  - $remunerat->hra;
            if ($remunerat->pf_applicablity == 'Yes') {
                if ($remunerat->restrict_pf == 'Yes') {
                    if ($pf_wages > 15000) {
                        $provident_fund = round(15000 * ($pf_rates / 100));
                        $provident_fund_emr = round(15000 * ($pf_emr_rates / 100));
                    } else {
                        $provident_fund = round($pf_wages * ($pf_rates / 100));
                        $provident_fund_emr = round(15000 * ($pf_emr_rates / 100));
                    }
                } else {
                    $provident_fund = round($pf_wages * ($pf_rates / 100));
                    $provident_fund_emr = round(15000 * ($pf_emr_rates / 100));
                }
            }
		$esi_wages =$remunerat->gross_salary;
            if ($remunerat->esi_applicability == 'Yes') {
                if ($remunerat->gross_salary <= 21000) {
                    $employee_state_insurance = ceil(number_format(($esi_wages * ($esi_rates / 100)), 2, '.', ''));
                    $employer_state_insurance = ceil(number_format(($esi_wages * ($esi_emr_rates / 100)), 2, '.', ''));
                }
            }
			$add1=Null;
			$add2=Null;
			$add3=Null;
			$add4=Null;
			$add5=Null;
			$add6=Null;
			$add7=Null;
			$add8=Null;	
?>

<div style="padding:5px; line-height: 1.6;">
    <div style="text-align: center;font-weight: 700;font-size:20px;text-decoration:underline;padding-top:05px">VOLTECH
        HR SERVICES PRIVATE LIMITED</div>
    <div style="text-align: center;font-weight: 100;font-size:20px;text-decoration:underline;padding-top:05px">Full &
        Final Settlement</div>
    <div style="text-align: right;font-weight: 600;">
        <!-- Date : {{ ($model->date_of_offer ? date('d-m-Y', strtotime($model->date_of_offer)) : '')}}<br> -->
        Date: <?php echo date("d-m-Y");?><br>
        Ref : SN / Lnt / <?php
if (date('m') > 6) {
    $year = date('Y')."-".(date('Y') +1);
}
else {
    $year = (date('Y')-1)."-".date('Y');
}
echo $year; // 2015-2016


/*     number into words       */
$number = $detail->pay;
   $no = floor($number);
   $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'one', '2' => 'two',
    '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
    '7' => 'seven', '8' => 'eight', '9' => 'nine',
    '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
    '13' => 'thirteen', '14' => 'fourteen',
    '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
    '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
    '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
    '60' => 'sixty', '70' => 'seventy',
    '80' => 'eighty', '90' => 'ninety');
   $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  $points = ($point) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] : '';
 // echo $result . "Rupees  " . $points . " Paise";
 if($result){
    $words = $result . "Rupees  " . $points . " Paise";
 }else{
    $words = 'NA';
 }
 
/*         */
?> / {{$model->emp_code}}
    </div>
    <table style="width:100%">
        <thead>
            <tr>
                <th colspan=4>Employee Details</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="font-weight-bold" width="25%"> Employee Code : </td>
                <td width="25%"> {{$model->emp_code}} </td>
                <td class="font-weight-bold" width="25%">Name : </td>
                <td width="25%"> {{$model->emp_name}} </td>
            </tr>
            <tr>
                <td class="font-weight-bold">Designation : </td>
                <td> {{$model->designation->designation_name}} </td>
                <td class="font-weight-bold">Department : </td>
                <td>{{$model->department->department_name}} </td>
                <!-- <td class="font-weight-bold"> Date of joining : </td>
                <td> {{ ($model->date_of_joining ? date('d-m-Y', strtotime($model->date_of_joining)) : '')}} </td> -->
            </tr>
            <tr>
                <td class="font-weight-bold">Date of Appointment : </td>
                <td>{{ ($model->date_of_joining ? date('d-m-Y', strtotime($model->date_of_joining)) : '')}}</td>
                <td class="font-weight-bold">Confirmation : </td>
                <td>{{ ($model->date_of_offer ? date('d-m-Y', strtotime($model->date_of_offer)) : '')}}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Date of Resignation : </td>
                <td>{{ ($detail->date_of_resignation ? date('d-m-Y', strtotime($detail->date_of_resignation)) : '')}}</td>
                <td class="font-weight-bold">Last Day : </td>
                <td>{{ ($detail->date_of_leaving ? date('d-m-Y', strtotime($detail->date_of_leaving)) : '')}}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Notice Period Pending : </td>
                <td> {{$detail->pending}}</td>
                <td class="font-weight-bold">F & F Days : </td>
                <td> {{$detail->fandfdays}}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Last Gross Salary : </td>
                <td>{{ ($rem->gross_salary ? number_format($rem->gross_salary,2) : 'NA')}}</td>
                <td class="font-weight-bold">Basic Salary : </td>
                <td>{{ ($rem->basic ? number_format($rem->basic,2) : 'NA')}}</td>
            </tr>
        </tbody>
    </table>
    <table width="100%">
        <thead>
            <tr>
                <th colspan=3>No Due Certificate</th>
            </tr>
            <tr>
                <th colspan=3>The above candidate has NO Dues pending with VHRS and can be relived - if any due please
                    note in the remark section</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="font-weight-bold" style="padding:30px" width="60%"></td>
                <td> </td>
                <td> </td>
            </tr>
        </tbody>
    </table>
    <table width="100%">
        <thead>
            <tr>
                <th colspan=4>Payable</th>
            </tr>
            <tr>
                <th width="10%">SI</th>
                <th width="35%">Particulars</th>
                <th width="35%">Amount</th>
                <th width="20%">Total</th>
            </tr>
        </thead>
        <tbody align="center">
            <tr>
                <td>1</td>
                <td>Salary for thePeriod</td>
                <td>{{ ($detail->salary ? number_format($detail->salary,2) : 'NA')}}</td>
                <td rowspan="5"> {{($var ? number_format($var,2):'NA')}} </td>
            </tr>
            <tr>
                <td>2</td>
                <td >Bonus</td>
                <td>{{ ($detail->bonus ? number_format($detail->bonus,2) : 'NA')}}</td>
            </tr>
            <tr>
                <td>3</td>
                <td>CompensationSalary</td>
                <td>{{ ($detail->comp_salary ? number_format($detail->comp_salary,2) : 'NA')}}</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Dues any other,if....</td>
                <td>{{ ($detail->dues ? number_format($detail->dues,2) : 'NA')}}</td>
            </tr>
            <tr>
                <td>5</td>
                <td>Security Deposit</td>
                <td>{{ ($detail->security_deposit ? number_format($detail->security_deposit,2) : 'NA')}}</td>
            </tr>
        </tbody>
    </table>
    <table width="100%">
        <thead>
            <tr>
                <th colspan=4>Deducted</th>
            </tr>
            <tr>
                <th width="10%">SI</th>
                <th width="35%">Particulars</th>
                <th width="35%">Amount</th>
                <th width="20%">Total</th>
            </tr>
        </thead>
        <tbody align="center">
            <tr>
                <td>1</td>
                <td>Advance</td>
                <td>{{ ($detail->advance ? number_format($detail->advance,2) : 'NA')}}</td>
                <td rowspan="8">{{($var1 ? number_format($var1,2):'NA')}} </td>
            </tr>
            <tr>
                <td>2</td>
                <td>Salary</td>
                <td>{{ ($detail->salary_ded ? number_format($detail->salary_ded,2) : 'NA')}}</td>
            </tr>
            <tr>
                <td>3</td>
                <td>TES Balance</td>
                <td>{{ ($detail->tes ? number_format($detail->tes,2) : 'NA')}}</td>
            </tr>
            <tr>
                <td>4</td>
                <td>EPF Deduction</td>
                <td>{{ ($detail->epf ? number_format($detail->epf,2) : 'NA')}}</td>
            </tr>
            <tr>
                <td>5</td>
                <td>ESI Deduction</td>
                <td>{{ ($detail->esi ? number_format($detail->esi,2) : 'NA')}}</td>
            </tr>
            <tr>
                <td>6</td>
                <td>Admin Loss &Damage - IDCard and VC</td>
                <td>{{ ($detail->admin ? number_format($detail->admin,2) : 'NA')}}</td>
            </tr>
            <tr>
                <td>7</td>
                <td>Professional Tax</td>
                <td>{{ ($detail->pt ? number_format($detail->pt,2) : 'NA')}}</td>
            </tr>
            <tr>
                <td>8</td>
                <td>Advance/Loan</td>
                <td>{{ ($detail->loan ? number_format($detail->loan,2) : 'NA')}}</td>
            </tr>
        </tbody>
    </table>
    <table width="100%">
        <thead>
            <tr>
                <th colspan=3>Final Settlement Value Payable by Employer</th>
            </tr>
        </thead>
        <tbody align="center">
            <tr>
                <td style="padding: 05px; text-align:left" width="60%"> Payable by: Employer <br> <b>{{$words}}</b></td>
                <td style="text-align:left" width="20%">Rupees:<br>{{ ($detail->pay ? number_format($detail->pay,2) : 'NA')}}</td>
                <td>{{ ($detail->pay ? number_format($detail->pay,2) : 'NA')}}</td>
            </tr>
        </tbody>
    </table>
    <table width="100%">
        <thead>
            <tr>
                <th>Prepared By</th>
                <th>Verified By</th>
                <th>Approved By</th>
            </tr>
        </thead>
        <tbody align="center">
            <tr>
                <td style="padding: 20px"> </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>J.Rapheal jerald </td>
                <td>J.R.Rishi keshav</td>
                <td>G.Selvaraj</td>
            </tr>
            <tr>
                <td>Sr.Officer - HR</td>
                <td>Manager</td>
                <td>Vice-President</td>
            </tr>
        </tbody>
    </table>
    <table width="100%">
        <tbody>
            <tr>
                <th colspan=4> Declaration of Employee </th>
            </tr>
            <tr>
                <td rowspan="2" align="left" width="60%"> I <b>{{$model->emp_name}}</b>, here by confirms and accepts this statement of
                    settlement, and don't have any further Dues/Claims including that of my reinstatement with Voltech
                    HR Services Pvt. Ltd. This is signed with full consent without any compulsion of any external.</td>
                <td colspan="2" style="padding:30px"></td>
                <td style="padding:30px"></td>
            </tr>
            <tr>
                <td colspan="2" align="center">Thumb Impression</td>
                <td align="center">Name - Signature - Date</td>
            </tr>

        </tbody>
    </table>
</div>
@endsection