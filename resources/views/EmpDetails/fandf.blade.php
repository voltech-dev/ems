@extends('layouts.blain')
@section('content')
<style>
p,
table {
    font-family: Century Gothic;
    font-size: 12px;
    text-align: justify;
}

li {
    margin: 10px 0;
}
</style>
<?php
error_reporting(0);
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
    <div style="text-align: center;font-weight: 700;font-size:25px;text-decoration:underline;padding-top:10px">VOLTECH
        HR SERVICES PRIVATE LIMITED</div>
    <div style="text-align: center;font-weight: 500;font-size:25px;text-decoration:underline;padding-top:10px">Full &
        Final Settlement</div>
    <div style="text-align: right;font-weight: 600;">
        Date : {{ ($model->date_of_offer ? date('d-m-Y', strtotime($model->date_of_offer)) : '')}}<br>
        Ref : SN / Lnt / <?php
if (date('m') > 6) {
    $year = date('Y')."-".(date('Y') +1);
}
else {
    $year = (date('Y')-1)."-".date('Y');
}
echo $year; // 2015-2016
?> / {{$model->emp_code}}
    </div>
    <!-- <div style="display:block; clear:both; page-break-after:always;"></div> -->
    <table class="table" border="1" width="100%" style="border-spacing: 0 15px">
        <thead class="">
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
                <td> </td>
                <!-- <td class="font-weight-bold"> Date of joining : </td>
                <td> {{ ($model->date_of_joining ? date('d-m-Y', strtotime($model->date_of_joining)) : '')}} </td> -->
            </tr>
            <tr>
                <td class="font-weight-bold">Date of Appointment : </td>
                <td> </td>
                <td class="font-weight-bold">Confirmation : </td>
                <td> </td>
            </tr>
            <tr>
                <td class="font-weight-bold">Date of Resignation : </td>
                <td> </td>
                <td class="font-weight-bold">Last Day : </td>
                <td> </td>
            </tr>
            <tr>
                <td class="font-weight-bold">Notice Period Pending : </td>
                <td> </td>
                <td class="font-weight-bold">F & F Days : </td>
                <td> </td>
            </tr>
            <tr>
                <td class="font-weight-bold">Last Gross Salary : </td>
                <td> </td>
                <td class="font-weight-bold">Basic Salary : </td>
                <td> </td>
            </tr>
            <tr>
                <th colspan=4>No Due Certificate</th>
            </tr>
            <tr>
                <th colspan=4>The above candidate has NO Dues pending with VHRS and can be relived - if any due please
                    note in the remark section</th>
            </tr>
            <tr>
                <td class="font-weight-bold" style="padding:77px"></td>
                <td colspan="2"> </td>
                <td class="font-weight-bold"></td>
                <!-- <td> </td>                 -->
            </tr>
            <tr>
                <th colspan=4>Payable</th>
            </tr>
            <tr>
                <td class="font-weight-bold" align="center">SI </td>
                <td class="font-weight-bold" align="center"> Particulars </td>
                <td class="font-weight-bold" align="center"> Amount </td>
                <td class="font-weight-bold" align="center"> Total </td>
            </tr>
            <tr>
                <td class="font-weight-bold">1</td>
                <td align="left"> Salary for the Period </td>
                <td align="left"> NA </td>
                <td rowspan="5" align="center"> 0 </td>
            </tr>
            <tr>
                <td class="font-weight-bold">2</td>
                <td align="left"> Bonus </td>
                <td align="left"> NA </td>
            </tr>
            <tr>
                <td class="font-weight-bold">3</td>
                <td align="left"> Compensation Salary </td>
                <td align="left"> NA </td>
            </tr>
            <tr>
                <td class="font-weight-bold">4</td>
                <td align="left"> Dues any other, if..... </td>
                <td align="left"> NA </td>
            </tr>
            <tr>
                <td class="font-weight-bold">5</td>
                <td align="left"> Security Deposit </td>
                <td align="left"> NA </td>
            </tr>
            <tr>
                <th colspan=4> Deducted </th>
            </tr>
            <tr>
                <td class="font-weight-bold" align="center">SI </td>
                <td class="font-weight-bold" align="center"> Particulars </td>
                <td class="font-weight-bold" align="center"> Amount </td>
                <td class="font-weight-bold" align="center"> Total </td>
            </tr>
            <tr>
                <td class="font-weight-bold">1</td>
                <td align="left"> Advance </td>
                <td align="left"> NA </td>
                <td rowspan="8" align="center"> 0 </td>
            </tr>
            <tr>
                <td class="font-weight-bold">2</td>
                <td align="left"> Salary </td>
                <td align="left"> NA </td>
            </tr>
            <tr>
                <td class="font-weight-bold">3</td>
                <td align="left"> TES Balance </td>
                <td align="left"> NA </td>
            </tr>
            <tr>
                <td class="font-weight-bold">4</td>
                <td align="left"> EPF Deduction </td>
                <td align="left"> NA </td>
            </tr>
            <tr>
                <td class="font-weight-bold">5</td>
                <td align="left"> ESI Deduction </td>
                <td align="left"> NA </td>
            </tr>
            <tr>
                <td class="font-weight-bold">6</td>
                <td align="left"> Admin Loss & Damage - ID Card and VC </td>
                <td align="left"> NA </td>
            </tr>
            <tr>
                <td class="font-weight-bold">7</td>
                <td align="left"> Professional Tax </td>
                <td align="left"> NA </td>
            </tr>
            <tr>
                <td class="font-weight-bold">8</td>
                <td align="left"> Advance/Loan </td>
                <td align="left"> NA </td>
            </tr>
            <tr>
                <th colspan=4> </th>
            </tr>
            <tr>
                <th colspan=4> Final Settlement Value Payable by Employer </th>
            </tr>
            <tr>
                <td class="font-weight-bold" style="padding:40px"></td>
                <td colspan="2"> </td>
                <td class="font-weight-bold"></td>
            </tr>
            <tr>
                <td class="font-weight-bold" align="center"> Prepared By</td>
                <td colspan="2" align="center">Verified BY </td>
                <td class="font-weight-bold" align="center">Approved By</td>
            </tr>
            <tr>
                <td class="font-weight-bold" style="padding:40px"></td>
                <td colspan="2"> </td>
                <td class="font-weight-bold"></td>
            </tr>
            <tr>
                <td class="font-weight-bold" align="center"> J. Rapheal Jerald</td>
                <td colspan="2" align="center"> J.R. Rishi Keshav</td>
                <td class="font-weight-bold" align="center"> G. Selvaraj</td>
            </tr>
            <tr>
                <td class="font-weight-bold" align="center">Sr. Officer - HR</td>
                <td colspan="2" align="center">Manager</td>
                <td class="font-weight-bold" align="center">Vice - President</td>
            </tr>
            <tr>
                <th colspan=4> Declaration of Employee </th>
            </tr>
            <tr>
                <td rowspan="2" align="left"> I {{$model->emp_name}}, here by confirms and accepts this statement of
                    settlement, and don't have any further Dues/Claims including that of my reinstatement with Voltech
                    HR Services Pvt. Ltd. This is signed with full consent without any compulsion of any external.</td>
                <td colspan="2" style="padding:40px"></td>
                <td style="padding:40px"></td>
            </tr>
            <tr>
                <td colspan="2" align="center">Thumb Impression</td>
                <td align="center">Name - Signature - Date</td>
            </tr>

        </tbody>
    </table>
</div>
@endsection