@extends('layouts.blain')
@section('content')
<style>
	p,ol{font-family:Century Gothic;font-size:19px;text-align: justify;}
	li{ margin: 10px 0;}
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

		$pf_rates = 12;
        $esi_rates = 0.75;
        $pf_emr_rates = 13;
        $esi_emr_rates = 3.25;
		
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
	
?>
<div style="padding:5px; line-height: 1.6;">
<div style="text-align: right;font-weight: 600;">
Date : {{ ($model->date_of_offer ? date('d-m-Y', strtotime($model->date_of_offer)) : '')}}<br>
Ref : SN / Lnt / 2021-2022 / {{$model->emp_code}}
</div>
<div style="text-align: center;font-weight: 700;font-size:25px;text-decoration:underline;padding-top:10px">EMPLOYMENT OFFER LETTER</div>
<div style="font-family:Century Gothic;font-size:19px">
To,<br>
<p style="font-family:Century Gothic;"><strong>Dear Mr/Ms. {{$model->emp_name}},</strong></p>
<p>This has reference to your application and the subsequent interview you had with us, we are pleased to offer you employment as <strong>“{{$model->designation->designation_name}}”</strong> on contractual basis for project <strong>{{ $model->project->project_name}} {{ $model->locantions->location}} </strong>for client <strong>L&T Constructions, Smart World And Communications</strong> for a specific period of 12 (Twelve) months from the <strong>{{ ($model->date_of_joining ? date('d-m-Y', strtotime($model->date_of_joining)) : '')}}</strong>, herein state the specific salary and other benefits which is indicated in Annexure – A (Enclosed). Your Employee Code will be <strong>{{$model->emp_code}}</strong>.</p>

<strong>TERMS OF EMPLOYMENT</strong>

<ol style=" margin-left: 20px;">
<li>You will be on contract for a period of 12 Months which can extend subjected to satisfactory performance unless otherwise required.</li>
<li>Be it clearly understood and agreed that your appointment is being made on contractual basis for a fixed period as stated above. Your appointment will automatically come to an end on the expiry of the specified period and no notice or notice pay or retrenchment compensation will be payable t o you by the management.</li>
<li>Since your appointment is being made for a specified period you will neither have any rights nor a lien on the job held by you. Also you will not claim regular employment even if there is such a vacancy for the post held by you or otherwise. Except one month’s notice or salary in lieu of one month’s notice no compensation or remaining wages for unexpired period of contractual and fixed period of appointment will be payable by the management if your services are terminated before the specified period of your service.</li>
<li>After the end of one-year contract or breached earlier, you will not have continuance of benefits of employment like EPF, ESI, Insurance Benefits, or any compensations whatsoever is offered during your employment.</li>
<div style="display:block; clear:both; page-break-after:always;"></div>
<li>Your appointment is subject to a satisfactory reference / background check and testimonial verification. The Company shall, at its discretion conduct background check either before joining the company or within a reasonable and practicable time frame after joining. This offer and your continued employment is conditional upon the result of such checks. In case the results of the same checks are negative or unsatisfactory for any reason, your offer / employment will be treated a s null and void. In such event, you may be immediately relieved from the employment without giving any notice and or notice pay in lieu of or any other remuneration (including incentives) for the period of engagement up to aforesaid date of relieving.</li> 
<li>Your duties will include for efficient, satisfactory and economical operation in the area of responsibility that may be assigned to you from time to time. As an employee of the company/firm/Establishment you will maintain a high standard of loyalty, efficiency, integrity and secrecy and will liaison with employees working under your supervision or your colleagues and will be responsible for execution of the decision taken by colleagues and will responsible for execution of the decision taken by the management from time to time.</li>
<li>The Management will be within its rights to transfer you for work or loan your services to any other unit/Division/Department or its parent and associated companies in any part of the country, where the Company/Firm/Establishment has an office or branch or unit or site for work, either at present or may have at any time in future.</li>
<li>On transfer or deputation, you will be governed by the rules and regulations of the contracting company and will adhere to the instructions given by the superiors of the contracting company.</li>
<li>You will not divulge or give out to anyone in any manner particulars or details of any trade secrets or research process, financial administrative and organization matters or any transaction or affairs of the company/Firm/Establishment of confidential nature.</li>
<li>You will devote your whole time and attention to the interest of the company/Firm/Establishment and will not engage yourself in any other work either paid or in honorary capacity.</li>
<li>Your appointment is being made on the basis of your particulars such as qualification etc., as given in your application for employment and in case any information as given by you is found false or incorrect your appointment will be deemed void and liable for termination without any notice or salary in lieu of notice.</li>
<div style="display:block; clear:both; page-break-after:always;"></div>
<li>Your address as indicated in your application for appointment shall be deemed to be correct for sending any communication to you and every communication addressed to you at the given address shall be deemed to have been served upon you.</li>
<li>In case there is any change in your residential address, you will intimate the same in writing to the personnel Department/Manager within three days from the date of such change and get such change of address recorded.</li>
<li>You will be bound by the certified standing Orders, Rules, Regulations and office orders in force and framed by the company from time to time in relation to your service conditions, which will form part of your terms of employment.</li>
<li>Your continuance in service with the company is subject to your remaining physically and mentally fit. You will submit yourself to medical examination as per the directions of the Management.</li>
<li>The above offer is governed by the Contract labor (Regulation & Abolition) Act, 1970, this shall be in effect till your continuance of employment.</li>
<li>If you decide to leave the role currently held by you in organization or decide to leave the organization for various reasons, you must serve notice period of 30 days from date of acceptance of your resignation letter.</li>
<li>If you chose not to serve the notice period of 30 days, the Company reserves the right to recover compensation of 01 (One) month salary in lieu of notice period from you.</li>
<li>In the event of separation without notice or without information in written or not handing over the Client / Company property including the files and records under your possession, the management has every right to withhold your salary and other dues due to you.</li>
</ol>
<p>Please submit us the written acceptance of this offer by signing the second copy of this letter. We welcome you to VHRS and wish you all the very best for your new assignment.</p>
<p>This is a Computer Generated Document.No Signature Required.</p>
<p>PLEASE SIGN ON THE BELOW SECTION AND ALL THE PAGES - TAKE A XEROX & SUBMIT THE DUPLICATE TO HR DEPARTMENT</p>
<div style="display:block; clear:both; page-break-after:always;"></div><br>
<div style="text-align: center;font-weight: 700;text-decoration:underline;">ACKNOWLEDGEMENT</div>

<p>I have carefully read and agreed the above “Employment Offer Letter” and I have read and understood code of conduct given to me from VHRS and the conditions prescribed therein. I am willingly and unconditionally accepting this “Employment Offer Letter” as issued from VHRS and am committed to abide with the terms and conditions as mentioned therein.</p>
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
									  <td align="right"> {{$remunerat->hra ? number_format($remunerat->hra,2):'0.00'}} </td>  
                                </tr>
								 <tr>
                                    <td class="font-weight-bold">Conveyance Allowance </td>
                                    <td align="right"> {{$remunerat->conveyance ? number_format($remunerat->conveyance,2):'0.00'}} </td>
									 <td align="right"> {{$remunerat->conveyance ? number_format($remunerat->conveyance,2):'0.00'}} </td>
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
									 <td align="right"> {{$remunerat->splallowance ? number_format($remunerat->splallowance *12,2):'0.00'}}  </td>
								</tr>
                               
                                <tr>
                                    <td class="font-weight-bold">Gross Salary (A)</td>
                                    <td class="font-weight-bold" align="right"> {{$remunerat->gross_salary ? number_format($remunerat->gross_salary,2):'0.00'}} </td>
                                    <td class="font-weight-bold" align="right"> {{$remunerat->gross_salary ? number_format($remunerat->gross_salary * 12,2):'0.00' }}</td> 
                                </tr>
								<tr>
                                    <th colspan=4> STANDARD DEDUCTIONS </th>
								</tr>
								  
								  <tr><td class="font-weight-bold">EPF Contribution (Employee)</td> 
								  <td class="font-weight-bold" align="right"> {{$provident_fund ? number_format($provident_fund,2):'0.00'}} </td>
                                    <td class="font-weight-bold" align="right"> {{$provident_fund ? number_format($provident_fund * 12,2):'0.00' }}</td> 
									  <td rowspan="5" align="center"> MONTHLY </td> 
									</tr>
								  <tr><td class="font-weight-bold">ESI Contribution (Employee)</td> 
								  <td class="font-weight-bold" align="right"> {{$employee_state_insurance ? number_format($employee_state_insurance,2):'0.00'}} </td>
                                    <td class="font-weight-bold" align="right"> {{$employee_state_insurance ? number_format($employee_state_insurance * 12,2):'0.00' }}</td> 
									</tr>
								  <tr><td class="font-weight-bold">Professional Tax</td> 
								  <td class="font-weight-bold" align="right"> {{$professional_tax ? number_format($professional_tax,2):'0.00'}} </td>
                                    <td class="font-weight-bold" align="right"> {{$professional_tax ? number_format($professional_tax * 12,2):'0.00' }}</td> 
									</tr>
								  <tr><td class="font-weight-bold">Deduction(B)</td>  
								  <td class="font-weight-bold" align="right"> {{number_format($professional_tax + $employee_state_insurance + $provident_fund,2)}} </td>
                                    <td class="font-weight-bold" align="right"> {{number_format((($professional_tax + $employee_state_insurance + $provident_fund) * 12 ),2) }}</td> 
									</tr>
								  <tr><td class="font-weight-bold">Net Salary(A-B)</td>
								  <td class="font-weight-bold" align="right"> {{$remunerat->gross_salary ? number_format($remunerat->gross_salary,2):'0.00'}} </td>
                                    <td class="font-weight-bold" align="right"> {{$remunerat->gross_salary ? number_format($remunerat->gross_salary * 12,2):'0.00' }}</td> 
									</tr>
								 <tr>
                                    <th colspan=4> OTHER COMPENSATION </th>
								</tr>
								 <tr><td class="font-weight-bold">EPF Contribution (Employer)</td> 
								  <td class="font-weight-bold" align="right"> {{$provident_fund_emr ? number_format($provident_fund_emr,2):'0.00'}} </td>
                                    <td class="font-weight-bold" align="right"> {{$provident_fund_emr ? number_format($provident_fund_emr * 12,2):'0.00' }}</td> 
									  <td rowspan="3" align="center"> MONTHLY </td> 
									</tr>
									 <tr><td class="font-weight-bold">EPF Contribution (Employer)</td> 
									 <td class="font-weight-bold" align="right"> {{$employer_state_insurance ? number_format($employer_state_insurance,2):'0.00'}} </td>
                                    <td class="font-weight-bold" align="right"> {{$employer_state_insurance ? number_format($employer_state_insurance * 12,2):'0.00' }}</td> 
									</tr>
									 <tr><td class="font-weight-bold">Insurances - GPA, GMC, WC</td> 
									 <td class="font-weight-bold" align="right">  </td>
                                    <td class="font-weight-bold" align="right"> </td> 
									</tr>								
								 <tr>
                                    <th colspan=4 align="left"> LOCAL CONVEYANCE REIMBURSEMENT WILL BE AT ACTUALS </th>
								</tr>
								 <tr>
                                    <th colspan=4> COST TO COMPANY (CTC) </th>
								</tr>
								 <tr><td class="font-weight-bold">CTC</td> 
								   <td class="font-weight-bold" align="right"> {{number_format(($remunerat->gross_salary + $provident_fund_emr + $employer_state_insurance),2)}} </td>
                                   <td class="font-weight-bold" align="right"> {{number_format((($remunerat->gross_salary + $provident_fund_emr + $employer_state_insurance)*12),2)}}</td> 
									<td align="right"></td>
									</tr>	
									<tr><td colspan=4 style="border-bottom:0px;"> For VOLTECH HR SERVICES PVT LTD &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Acceptance by Employee </td></tr>
									 <tr><td colspan=4 style="border-top:0px;"> This is a Computer Generated Document.No Signature Required. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date: </td></tr>

                            </tbody>
							</table>
</div>
@endsection