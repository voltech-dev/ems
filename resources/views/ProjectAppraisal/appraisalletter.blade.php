@extends('layouts.blain')
@section('content')
<style>
p,
ol {
    font-family: Century Gothic;
    font-size: 19px;
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
$appraisal = App\Models\Appraisals::where(['empid'=>$model->id,'flag'=>1])->latest()->first();

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
                        $provident_fund_emr = round($pf_wages * ($pf_emr_rates / 100));
                    }
                } else {
                    $provident_fund = round($pf_wages * ($pf_rates / 100));
                    $provident_fund_emr = round($pf_wages * ($pf_emr_rates / 100));
                }
            }
			
		$esi_wages =$remunerat->gross_salary;
            if ($remunerat->esi_applicability == 'Yes') {
                if ($remunerat->gross_salary <= 21000) {
                    // $employee_state_insurance = ceil(number_format(($esi_wages * ($esi_rates / 100)), 2, '.', ''));
                    // $employer_state_insurance = ceil(number_format(($esi_wages * ($esi_emr_rates / 100)), 2, '.', ''));
                    $employee_state_insurance = round(number_format(($esi_wages * ($esi_rates / 100)), 2, '.', ''));
                    $employer_state_insurance = round(number_format(($esi_wages * ($esi_emr_rates / 100)), 2, '.', ''));
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
			
			$net = $remunerat->professional_tax + $employee_state_insurance + $provident_fund;
			$net1 =  $remunerat->gross_salary;
	 $net2 = $net1 - $net;
?>
<div style="padding:5px; line-height: 1.6;">
    <div style="text-align: right;font-weight: 600;">
        Date : <?php echo date("d-m-Y");?><br>
        Ref : VHRS / LnT / AL / {{$model->emp_code}}
    </div>
    <!-- <div style="text-align: center;font-weight: 700;font-size:25px;text-decoration:underline;padding-top:10px">FIXED
        TERM PERIOD APPOINTMENT LETTER</div> -->
    <div style="font-family:Century Gothic;font-size:19px">
        To,<br>
        <p style="font-family:Century Gothic;">Mr/Ms. {{$model->emp_name}},
        <p style="font-family:Century Gothic; margin-top: -20px;">{{$model->emp_code}},
        <p style="font-family:Century Gothic; margin-top: -20px;">{{$model->designation->designation_name}}.</p><br />
        <p style="font-family:Century Gothic;"><strong>Dear {{$model->emp_name}},</strong></p>
        <p style="font-family:Century Gothic;">Congratulation!!</p>
        <p>After substantial review of your performance for the recent year, you have been rated as
            <strong>“{{$appraisal->score}}”</strong>,
            management is happy to inform you that your monthly remuneration (Gross) has been revised as
            <strong>Rs {{$remunerat->gross_salary ? number_format($remunerat->gross_salary,2):'0.00'}}/-</strong> which
            will take effect on <strong>{{$appraisal->review_date}}</strong>. This letter is meant as your appraisal this year. A copy of
            this letter will be forwarded to payroll for processing.
        </p>

        <p>We are truly honoured in having you as one of our employee and recognise all the contributions you have made
            this year. We are hoping for your dedication and hard work in the upcoming years for the success of the
            company.</p>
        <p style="font-family:Century Gothic;">Please sign a copy of this letter and share us back.</p>
        <p style="font-family:Century Gothic;">For Voltech HR Services Pvt Ltd</p>
        <p style="font-family:Century Gothic;">This is a Computer Generated Document No Signature Required.</p>

    </div>
    <div style="display:block; clear:both; page-break-after:always;"></div>
    <table class="table" border="1" width="100%" style="border-spacing: 0 15px">
        <thead class="">
            <tr>
                <th colspan=4>Annexure-A</th>
            </tr>
            <tr>
                <th colspan=4>REMUNERATION AND DEDUCTIONS BREAK-UP</th>
            </tr>
            <tr>
                <th colspan=4 align="left">EMPLOYMENT DETAILS</th>
            </tr>

        </thead>
        <tbody>
            <tr>
                <td class="font-weight-bold">Name : </td>
                <td width="30%"> {{$model->emp_name}} </td>
                <td class="font-weight-bold"> Employee Code : </td>
                <td> {{$model->emp_code}} </td>
            </tr>

            <tr>
                <td class="font-weight-bold">Designation : </td>
                <td> {{$model->designation->designation_name}} </td>
                <td class="font-weight-bold"> Date of joining : </td>
                <td> {{ ($model->date_of_joining ? date('d-m-Y', strtotime($model->date_of_joining)) : '')}} </td>
            </tr>
            <tr>
                <th colspan=4>BASIC AND OTHER ALLOWANCES</th>
            </tr>
            <tr>
                <td class="font-weight-bold">Title </td>
                <td> Per Month </td>
                <td class="font-weight-bold"> Per Annum </td>
                <td> Frequency of payment </td>
            </tr>

            <tr>
                <td class="font-weight-bold">Basic</td>
                <td align="right"> {{$remunerat->basic ? number_format($remunerat->basic,2):'0.00'}} </td>
                <td align="right"> {{$remunerat->basic ? number_format($remunerat->basic * 12,2):'0.00'}} </td>
                <td rowspan="7" align="center"> MONTHLY </td>
            </tr>
            <tr>
                <td class="font-weight-bold">House Rent Allowance(HRA)</td>
                <td align="right"> {{$remunerat->hra ? number_format($remunerat->hra,2):'0.00'}} </td>
                <td align="right"> {{$remunerat->hra ? number_format($remunerat->hra*12,2):'0.00'}} </td>
            </tr>
            <tr>
                <td class="font-weight-bold">Conveyance Allowance </td>
                <td align="right"> {{$remunerat->conveyance ? number_format($remunerat->conveyance,2):'0.00'}} </td>
                <td align="right"> {{$remunerat->conveyance ? number_format($remunerat->conveyance*12,2):'0.00'}} </td>
            </tr>
            <tr>
                <td class="font-weight-bold">Education Allowance </td>
                <td align="right"> {{$remunerat->education ? number_format($remunerat->education,2):'0.00' }} </td>
                <td align="right"> {{$remunerat->education ? number_format($remunerat->education * 12,2):'0.00'}} </td>
            </tr>

            <tr>
                <td class="font-weight-bold"> Medical Allowance </td>
                <td align="right"> {{$remunerat->medical ? number_format($remunerat->medical,2):'0.00'}} </td>
                <td align="right"> {{$remunerat->medical ? number_format($remunerat->medical *12,2):'0.00'}} </td>
            </tr>

            <tr>
                <td class="font-weight-bold">Spl.Allowance </td>
                <td align="right"> {{$remunerat->splallowance ? number_format($remunerat->splallowance,2):'0.00'}} </td>
                <td align="right"> {{$remunerat->splallowance ? number_format($remunerat->splallowance *12,2):'0.00'}}
                </td>
            </tr>

            <tr>
                <td class="font-weight-bold">Gross Salary (A)</td>
                <td class="font-weight-bold" align="right">
                    {{$remunerat->gross_salary ? number_format($remunerat->gross_salary,2):'0.00'}} </td>
                <td class="font-weight-bold" align="right">
                    {{$remunerat->gross_salary ? number_format($remunerat->gross_salary * 12,2):'0.00' }}</td>
            </tr>
            <tr>
                <th colspan=4> STANDARD DEDUCTIONS </th>
            </tr>

            <tr>
                <td class="font-weight-bold">EPF Contribution (Employee)</td>
                <td class="font-weight-bold" align="right">
                    {{$provident_fund ? number_format($provident_fund,2):'0.00'}} </td>
                <td class="font-weight-bold" align="right">
                    {{$provident_fund ? number_format($provident_fund * 12,2):'0.00' }}</td>
                <td rowspan="5" align="center"> MONTHLY </td>
            </tr>
            <tr>
                <td class="font-weight-bold">ESI Contribution (Employee)</td>
                <td class="font-weight-bold" align="right">
                    {{$employee_state_insurance ? number_format($employee_state_insurance,2):'0.00'}} </td>
                <td class="font-weight-bold" align="right">
                    {{$employee_state_insurance ? number_format($employee_state_insurance * 12,2):'0.00' }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Professional Tax</td>
                <td class="font-weight-bold" align="right">
                    {{$remunerat->professional_tax ? number_format($remunerat->professional_tax,2):'0.00'}} </td>
                <td class="font-weight-bold" align="right">
                    {{$remunerat->professional_tax ? number_format($remunerat->professional_tax * 12,2):'0.00' }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Deduction(B)</td>
                <td class="font-weight-bold" align="right">
                    {{number_format($remunerat->professional_tax + $employee_state_insurance + $provident_fund,2)}}
                </td>
                <td class="font-weight-bold" align="right">
                    {{number_format((($remunerat->professional_tax + $employee_state_insurance + $provident_fund) * 12 ),2) }}
                </td>
            </tr>
            <tr>
                <td class="font-weight-bold">Net Salary(A-B)</td>
                <td class="font-weight-bold" align="right">
                    {{number_format($net2,2)}}</td>
                <td class="font-weight-bold" align="right">
                    {{$net2 ? number_format($net2 * 12,2):'0.00' }}</td>
            </tr>
            <tr>
                <th colspan=4> OTHER COMPENSATION </th>
            </tr>
            <tr>
                <td class="font-weight-bold">EPF Contribution (Employer)</td>
                <td class="font-weight-bold" align="right">
                    {{$provident_fund_emr ? number_format($provident_fund_emr,2):'0.00'}} </td>
                <td class="font-weight-bold" align="right">
                    {{$provident_fund_emr ? number_format($provident_fund_emr * 12,2):'0.00' }}</td>
                <td rowspan="3" align="center"> MONTHLY </td>
            </tr>
            <tr>
                <td class="font-weight-bold">ESI Contribution (Employer)</td>
                <td class="font-weight-bold" align="right">
                    {{$employer_state_insurance ? number_format($employer_state_insurance,2):'0.00'}} </td>
                <td class="font-weight-bold" align="right">
                    {{$employer_state_insurance ? number_format($employer_state_insurance * 12,2):'0.00' }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Insurances - GPA, GMC, WC</td>
                <td class="font-weight-bold" align="right">
                    {{$remunerat->insurance ? number_format($remunerat->insurance,2):'0.00'}} </td>
                <td class="font-weight-bold" align="right">
                    {{$remunerat->insurance ? number_format($remunerat->insurance * 12,2):'0.00' }}</td>
            </tr>
            <tr>
                <th colspan=4 align="left"> LOCAL CONVEYANCE REIMBURSEMENT WILL BE AT ACTUALS </th>
            </tr>
            <tr>
                <th colspan=4> COST TO COMPANY (CTC) </th>
            </tr>
            <tr>
                <td class="font-weight-bold">CTC</td>
                <td class="font-weight-bold" align="right"> {{number_format($remunerat->ctc,2)}} </td>
                <td class="font-weight-bold" align="right"> {{number_format($remunerat->ctc*12,2)}}</td>
                <td align="right"></td>
            </tr>
            <tr>
                <td colspan=4 style="border-bottom:0px;"> For VOLTECH HR SERVICES PVT LTD
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Acceptance
                    by Employee </td>
            </tr>
            <tr>
                <td colspan=4 style="border-top:0px;"> This is a Computer Generated Document.No Signature Required.
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date: </td>
            </tr>

        </tbody>
    </table>
</div>
@endsection