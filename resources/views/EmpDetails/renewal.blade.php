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

		// $pf_rates = 12;
        // $esi_rates = 0.75;
        // $pf_emr_rates = 13;
        // $esi_emr_rates = 3.25;
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
        Date : <?php 
if(date !=''){
	echo $date;
}else{
	echo date("d-m-Y");
}
?><br>
        Ref : VHRS / LnT / OL / 2021-2022 / {{$model->emp_code}}
    </div>
    <div style="text-align: center;font-weight: 700;font-size:25px;text-decoration:underline;padding-top:10px">FIXED
        TERM PERIOD APPOINTMENT LETTER</div>
    <div style="font-family:Century Gothic;font-size:17px">
        To,
        <p style="font-family:Century Gothic;"><strong>Dear Mr/Ms. {{$model->emp_name}},</strong>
            <?php
			if($model->address_1 !=''){
				echo $model->address_1.', ';
			} 
			if($model->address_2 !=''){
				echo $model->address_2.', <br>';
			} 
			if($model->address_3 !=''){
				echo $model->address_3.', ';
			} 
			if($model->address_4 !=''){
				echo $model->address_4.', <br>';
			} 
			if($model->address_5 !=''){
				echo $model->address_5.', <br>';
			} 
			
			if($model->address_7 !=''){
				echo $model->address_7.', ';
			} 
			if($model->address_8 !=''){
				echo $model->address_8.'.';
			} 
?> </p>
        <p style="font-family:Century Gothic;font-size:17px">This has reference to your application and the subsequent
            interview you had with us, we are pleased to offer you employment as
            <strong>“{{$model->designation->designation_name}}”</strong> on contractual basis for project
            <strong>{{ $model->project->project_name}} {{ $model->locantions->location}} </strong>for client <strong>L&T
                Constructions, Smart World And Communications</strong> for a specific period of 12 (Twelve) months from
            the
            <strong>{{ ($model->renewal_offer_date ? date('d-m-Y', strtotime($model->renewal_offer_date)) : '')}}</strong>,
            herein state the specific salary and other benefits which is indicated in Annexure – A (Enclosed). Your
            Employee Code will be <strong>{{$model->emp_code}}</strong>.
        </p>

        <strong>TERMS OF EMPLOYMENT</strong>

        <ol style=" margin-left: 20px; font-family:Century Gothic;font-size:17px">
            <li>You will be on contract for a period of 12 Months which can extend subjected to satisfactory performance
                unless otherwise required.</li>
            <li>Be it clearly understood and agreed that your appointment is being made on contractual basis for a fixed
                period as stated above. Your appointment will automatically come to an end on the expiry of the
                specified period and no notice or notice pay or retrenchment compensation will be payable t o you by the
                management.</li>
            <li>Since your appointment is being made for a specified period you will neither have any rights nor a lien
                on the job held by you. Also you will not claim regular employment even if there is such a vacancy for
                the post held by you or otherwise. Except one month’s notice or salary in lieu of one month’s notice no
                compensation or remaining wages for unexpired period of contractual and fixed period of appointment will
                be payable by the management if your services are terminated before the specified period of your
                service.</li>
            <li>After the end of one-year contract or breached earlier, you will not have continuance of benefits of
                employment like EPF, ESI, Insurance Benefits, or any compensations whatsoever is offered during your
                employment.</li>

            <li>Your appointment is subject to a satisfactory reference / background check and testimonial verification.
                The Company shall, at its discretion conduct background check either before joining the company or
                within a reasonable and practicable time frame after joining. This offer and your continued employment
                is conditional upon the result of such checks. In case the results of the same checks are negative or
                unsatisfactory for any reason, your offer / employment will be treated a s null and void. In such event,
                you may be immediately relieved from the employment without giving any notice and or notice pay in lieu
                of or any other remuneration (including incentives) for the period of engagement up to aforesaid date of
                relieving.</li>
            <!-- <div style="display:block; clear:both; page-break-after:always;"></div> -->
            <li>Your duties will include for efficient, satisfactory and economical operation in the area of
                responsibility that may be assigned to you from time to time. As an employee of the
                company/firm/Establishment you will maintain a high standard of loyalty, efficiency, integrity and
                secrecy and will liaison with employees working under your supervision or your colleagues and will be
                responsible for execution of the decision taken by colleagues and will responsible for execution of the
                decision taken by the management from time to time.</li>
            <li>The Management will be within its rights to transfer you for work or lend your services to any other
                Client/Project/Location in any part of the country, where the Company/Firm/Establishment has an oﬃce or
                branch or unit or site for work, either at present or may have at any time in future.</li>
            <li>On transfer or deputation, you will be governed by the rules and regulations of the Organization and/or
                Client Company and will adhere to the instructions given by the superiors of the Organization and/or
                Client Company</li>
            <li>You will not divulge or give out to anyone in any manner particulars or details of any trade secrets or
                research process, financial administrative and organization matters or any transaction or affairs of the
                company/Firm/Establishment of confidential nature.</li>
            <li>You will devote your whole time and attention to the interest of the company/Firm/Establishment and will
                not engage yourself in any other work either paid or in honorary capacity.</li>
            <li>Your appointment is being made on the basis of your particulars such as qualification etc., as given in
                your application for employment and in case any information as given by you is found false or incorrect
                your appointment will be deemed void and liable for termination without any notice or salary in lieu of
                notice.</li>
            <li>Your address as indicated in your application for appointment shall be deemed to be correct for sending
                any communication to you and every communication addressed to you at the given address shall be deemed
                to have been served upon you.</li>

            <li>In case there is any change in your residential address, you will intimate the same in writing to the
                personnel Department/Manager within three days from the date of such change and get such change of
                address recorded.</li>

            <li>You will be bound by the certified standing Orders, Rules, Regulations and office orders in force and
                framed by the company from time to time in relation to your service conditions, which will form part of
                your terms of employment.</li>
            <li>Your continuance in service with the company is subject to your remaining physically and mentally fit.
                You will submit yourself to medical examination as per the directions of the Management.</li>

            <li>The above offer is governed by the Contract labor (Regulation & Abolition) Act, 1970, this shall be in
                effect till your continuance of employment.</li>
            <!-- <div style="display:block; clear:both; page-break-after:always;"></div> -->
            <li>If you decide to leave the role currently held by you in organization or decide to leave the
                organization for various reasons, you must serve notice period of 30 days from date of acceptance of
                your resignation letter.</li>
            <li>If you chose not to serve the notice period of 30 days, the Company reserves the right to recover
                compensation of 01 (One) month salary in lieu of notice period from you.</li>
            <li>In the event of separation without notice or without information in written or not handing over the
                Client / Company property including the files and records under your possession, the management has
                every right to withhold your salary and other dues due to you.</li>
            <li>Your services can be terminated without notice and inquiry, under the following conditions:
                <ul>
                    <li>In case your performance is found to be unsatisfactory, or you are found violating any
                        disciplinary norms of the organization or our client.</li>
                    <li>In case the Client Project/Process/Line of business/Business Unit/Business Activity comes to an
                        end.</li>
                    <li>In the event of rejection by the client, dishonesty, disobedience, absence from duty without
                        permission or any other act considered detrimental to the interest of the organization/Client,
                        or violation of one or more terms of this appointment for fixed term period.</li>

                    <li>Any activity leading to formation of groups which the organization may feel that such groups may
                        hamper the work, peace and general client relationship.</li>
                    <li>Any activity resulting in loss of work at our organization or its client premises or purposive
                        delay of work, at an individual capacity or in conjunction with other colleagues, will be
                        treated as an in disciplinary act ad may result in termination of your service without notice or
                        inquiry, with immediate effect.</li>
                    <li>In case any information/particulars provided to our organization or its Client during and after
                        your appointment for fixed term project is false and misleading.</li>
                    <li>In case of any Criminal Record or Criminal Proceedings initiated against you.</li>

                </ul>
            </li>

            <li>The Organization / Client is authorized to remove you from the premises if the client consider it
                undesirable or being not in the interest of the organization and or its employee’s and workmen.</li>
            <li>Any damage caused by you at client’s place or organization intentionally/ unintentionally resulting in
                damage / loss of property or equipment or any tangible/ intangible items/ assets etc. will be dealt
                severally and you will be liable for damage or loss.</li>
            <li>You are expected to remain with the Client for full period of service mentioned above. By signing this
                agreement / letter, you acknowledge that breach of any one or more of the clause/ points of this
                agreement/ letter will result in the irreparable harm to client and to our organization for which
                damages would be an inadequate remedy. Therefore, in the event of such breach, and in addition to its
                right and remedies otherwise available at law, Client and our organization shall be entitled to
                equitable relief.</li>
            <!-- <div style="display:block; clear:both; page-break-after:always;"></div> -->
            <li>The candidate shall not perform any service for the organization while under the influence of alcohol or
                any un prescribed controlled substance. The possession of alcohol un prescribed controlled substance,
                drug or paraphernalia, firearms, explosives, weapons and other hazardous substance or articles are
                prohibited on the organization’s/ client’s premises. In case candidate is found in possession of any of
                the above mentioned substances, he/she will be liable to be dismissed with immediate effect, without any
                notice and legal action may be taken.</li>
            <li>Client/ Voltech for Employment: You will not claim for any form of employment with our client or us (
                Voltech HR Services) directly/ indirectly or through any legal/ illegal source after the end of your
                fixed term with our Client / Organization. You will not claim any form of employment from our Client
                during/ after the end of your fixed term </li>

            <li>On or before joining you must furnish the following:
                <ul>
                    <li>2 Passport size photographs</li>
                    <li>Copy of all your experience letters, relieving orders, service certificates, salary slips, tax
                        deduction certificates and age proof.</li>
                    <li>Attested copies of Educational certificates/ Degree/ Diploma certificates.</li>
                    <li>Medical fitness certificate from your family doctor</li>

                </ul>
            </li>
        </ol>

        <p>Please submit us the written acceptance of this offer by signing the second copy of this letter. We welcome
            you to VHRS and wish you all the very best for your new assignment.</p>
        <p>This is a Computer Generated Document.No Signature Required.</p>

        <p><b>PLEASE SIGN ON THE BELOW SECTION AND ALL THE PAGES - TAKE A XEROX & SUBMIT THE DUPLICATE TO HR
                DEPARTMENT</b></p>
        <!-- <div style="display:block; clear:both; page-break-after:always;"></div> -->
        <p><b>Please sign on each page of the second copy of this letter of Fixed Term Period Appointment, in token of
                you having understood, accepted and agreed to the same.</b></p>
        <div style="display:block; clear:both; page-break-after:always;"></div><br>
        <div style="text-align: center;font-weight: 700;text-decoration:underline;">ACKNOWLEDGEMENT</div>

        <p>I have carefully read and agreed the above “Employment Offer Letter” and I have read and understood code of
            conduct given to me from VHRS and the conditions prescribed therein. I am willingly and unconditionally
            accepting this “Employment Offer Letter” as issued from VHRS and am committed to abide with the terms and
            conditions as mentioned therein.</p>
        <p><br><br><br></p>
        <p>Candidate: Full Name/Full Signature/Date</p>
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
                <!-- <td> {{ ($model->date_of_joining ? date('d-m-Y', strtotime($model->date_of_joining)) : '')}} </td> -->
                <td>{{ ($model->renewal_offer_date ? date('d-m-Y', strtotime($model->renewal_offer_date)) : '')}}</td>
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
                <!-- <td class="font-weight-bold" align="right"> {{number_format(($remunerat->gross_salary + $provident_fund_emr + $employer_state_insurance),2)}} </td>
                                   <td class="font-weight-bold" align="right"> {{number_format((($remunerat->gross_salary + $provident_fund_emr + $employer_state_insurance)*12),2)}}</td>  -->
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
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Date: </td>
            </tr>

        </tbody>
    </table>
</div>
@endsection