@extends('layouts.blain')
@section('content')
<?php
error_reporting(0);
$m = date("m", strtotime($model->month));
$y = date("Y", strtotime($model->month));
$maxDays = cal_days_in_month(CAL_GREGORIAN, $m, $y);
?>
<div style="padding:5px">
<div style="padding:10px 0 90px 0">
	<div style="float: left; width: 50%; margin-bottom: 0pt; ">
		<div class="title"><img src="{{ asset('images') }}/logo.png"></div>
	</div>

	<div style="float: right; width: 50%; margin-bottom: 0pt;  ">
		<div >Voltech HR Services Private Limited</div>
		<div ><i class="fa fa-envelope" aria-hidden="true"></i> hr.support@voltechgroup.com</div>
		<div ><i class="fa fa-mobile" aria-hidden="true"></i> 9500006902</div>           
	</div>
</div>


 <table width="100%">
  
	 <tr>
                <td style="text-align: center;border-top: 1px solid #ccc; border-bottom: 1px solid #ccc;display: flex;justify-content: space-around;">Payslip for the month of {{ date('F , Y', strtotime($model->month))}}</td>
                
            </tr> 
</table>
 <table width="100%">
 <tr><td width="43%" valign="top" style="border-right: 1px solid #ccc;">
    
      
        <table width="100%">
		
            <tr>                <td style="border-bottom: 1px solid #ccc;font-weight: 700;" colspan="2">Employee Details</td>
               
            </tr>
            <tr>
                <td width="30%">Emp Name</td>
                <td width="70%" align="right">{{$model->employee->emp_name}}</td>
            </tr>
            <tr>
                <td width="30%">Emp ID</td>
                <td width="70%" align="right">{{ $model->employee->emp_code}}</td>
            </tr>
            <tr>
                <td>Designation</td>
                <td align="right">{{ $model->employee->designation->designation_name}}</td>
            </tr>
			 <tr>
                <td>Project</td>
                <td align="right">{{ $model->employee->project->project_name}}</td>
            </tr>
			 <tr>
                <td>Location</td>
                <td align="right">{{ $model->employee->locantions->location}}</td>
            </tr>
			 <tr>
                <td>Bank A/C No</td>
                <td align="right">{{ $model->employee->bank->acnumber}}</td>
            </tr>
			 <tr>
                <td>Bank Name</td>
                <td align="right">{{ $model->employee->bank->bankname}}</td>
            </tr>
            <tr>
                <td>PF No.</td>
                <td align="right">{{ $model->employee->statutory->epfno}}</td>
            </tr>
            <tr>
                <td>ESI No.</td>
                <td align="right">{{$model->employee->statutory->esino}}</td>
            </tr>
            <tr>
                <td>UAN</td>
                <td align="right">{{ $model->employee->statutory->epfuanno}}</td>
            </tr>
            <tr>
                <td>DOJ</td>
                <td align="right">{{ ($model->date_of_joining ? date('d/m/Y', strtotime($model->date_of_joining)) : '')}}</td>
            </tr>
            <tr>
                <td>Month days</td>
                <td align="right">{{ $maxDays}}</td>
            </tr>
			<tr>
                <td>Paid days</td>
                <td align="right">{{ $model->paiddays}}</td>
            </tr>
            <!--<tr>
                <td colspan="2" style="text-align:left;border-bottom: 1px solid #ccc;font-weight: 700;"> <br>Employer
                    Contribution</td>

            <tr>
                <td colspan="2"> <br></td>
            <tr>
                <td style="font-weight: 700;" width="30%">CTC</td>
                <td style="font-weight: 700;" width="70%" align="right">{{$model->earned_ctc}}</td>
            </tr>
			 <tr>
                <td colspan="2"></td>
            <tr>-->
        </table>
     </td>
	<td>
    
        <table width="100%" >
            <tr>
                <td width="50%" style="border-bottom: 1px solid #ccc;font-weight: 700;">Components</td>
                <td width="30%" align="right" style="border-bottom: 1px solid #ccc;font-weight: 700;">Actual</td>
                <td width="40%" align="right" style="border-bottom: 1px solid #ccc;font-weight: 700;">Earnings</td>
            </tr>
            <tr>
                <td>Base Pay</td>
                <td align="right">{{$actual->basic}}</td>
                <td align="right">{{$model->basic}}</td>
            </tr>
			@if($model->hra) 
			<tr><td >HRA</td><td align="right">{{$actual->hra}}</td><td align="right">{{$model->hra}}</td></tr>
			@endif
			@if($model->conveyance_earning)  
			<tr><td>Conveyance</td><td align="right">{{$actual->conveyance}}</td><td align="right">{{$model->conveyance_earning}}</td></tr>
			@endif
			@if($model->medical_earning)  
			<tr><td>Spl. Allowance</td><td align="right">{{$actual->medical}}</td><td align="right">{{$model->medical_earning}}</td></tr>
			@endif
			@if($model->education_earning) 
			<tr><td>Spl. Allowance</td><td align="right">{{$actual->education}}</td><td align="right">{{$model->education_earning}}</td></tr>
			@endif
			@if($model->spl_allowance)  
			<tr><td>Spl. Allowance</td><td align="right">{{$actual->splallowance}}</td><td align="right">{{$model->spl_allowance}}</td></tr>
			@endif
			@if($model->over_time) 
			<tr><td>Over Time</td><td></td><td align="right">{{$model->over_time}}</td></tr>
			@endif
			@if($model->arrear) 
			<tr><td>Arrear</td><td></td><td align="right">{{$model->arrear}}</td></tr>
			@endif
            <tr>
                <td colspan="3"> </td>
            </tr>
                <td style="font-weight: 700;">Gross Earnings</td>
                <td style="font-weight: 700;" align="right">{{$actual->gross}}</td>
                <td style="font-weight: 700;" align="right">{{$model->total_earning}}</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align:right;border-bottom: 1px solid #ccc;font-weight: 700;"> <br>Deductions
                </td>
		
				@if($model->pf) 
				<tr><td>PF</td><td align="right"></td><td align="right">{{$model->pf}}</td></tr>
				@endif
				@if($model->insurance) 
				<tr><td>Insurance</td><td align="right"></td><td align="right">{{$model->insurance}}</td></tr>
				@endif
				@if($model->professional_tax)
				<tr><td>Professional tax</td><td align="right"></td><td align="right">{{$model->professional_tax}}</td></tr>
				@endif
				@if($model->esi) 
				<tr><td>ESI</td><td align="right"></td><td align="right">{{$model->esi}}</td></tr>
				@endif
				@if($model->advance) 
				<tr><td>Advance</td><td align="right"></td><td align="right">{{$model->advance}}</td></tr>
				@endif
				@if($model->tds) 
				<tr><td>TDS</td><td align="right"></td><td align="right">{{$model->tds}}</td></tr>
				@endif	
								
            <tr>
                <td colspan="3"></td>
            </tr>
			<tr>
                <td style="font-weight: 700;">Total Deduction</td>
                <td style="font-weight: 700;" align="right"></td>
                <td style="font-weight: 700;" align="right">{{$model->total_deduction}}</td>
            </tr>
            <tr>
                <td colspan="3"> </td>
            </tr>
			</tr>
				<tr>
                <td style="font-weight: 700;">NET PAY:</td>
                <td style="font-weight: 700;" align="right"></td>
                <td style="font-weight: 700;" align="right">{{$model->net_amount}}</td>
            </tr>
			<tr>
                <td colspan="3" style="text-align:right;border-bottom: 1px solid #ccc;font-weight: 700;"> Variable Allowance
                </td>
				</tr>
				@if($model->conveyance_allowance) 
				<tr><td>Conveyance Allowance</td><td align="right"></td><td align="right">{{$model->conveyance_allowance}}</td></tr>
				@endif	
				
				@if($model->laptop_allowance) 
				<tr><td>Laptop Allowance</td><td align="right"></td><td align="right">{{$model->laptop_allowance}}</td></tr>
				@endif
				
				@if($model->travel_allowance) 
				<tr><td>Travel Allowance</td><td align="right"></td><td align="right">{{$model->travel_allowance}}</td></tr>
				@endif
				
				@if($model->mobile_allowance) 
				<tr><td>Mobile Allowance</td><td align="right"></td><td align="right">{{$model->mobile_allowance}}</td></tr>
				@endif
			 <tr>
                <td colspan="3"></td>
            </tr>
			 @php
                    $takehome = $model->net_amount + $model->mobile_allowance +$model->travel_allowance +
                    $model->laptop_allowance + $model->conveyance_allowance;
                    @endphp
					
					<tr>
                <td style="font-weight: 700;">Takehome Salary : </td>
                <td style="font-weight: 700;" align="right"></td>
                <td style="font-weight: 700;" align="right">{{$takehome}}</td>
            </tr>
			<tr><td colspan="3"><b>In Words: </b> {{$model->employee->getIndianCurrency($takehome)}} Only</td></tr>	
        </table>
   </td></tr>
   </table>
    <table width="100%">
  
	 <tr>
                <td style="text-align: center;border-top: 1px solid #ccc; border-bottom: 1px solid #ccc;display: flex;justify-content: space-around;">This is a system generated payslip. Hence signature not required.</td>
                
            </tr> 
</table>
</div>
@endsection