@extends('layouts.blain')
@section('content')
<?php
error_reporting(0);
?>
<div style="padding:10px 0 5px 0">
<div style="float: left; width: 50%; margin-bottom: 0pt; ">
<div class="title"></div> 
</div>
<div style="float: right; width: 50%; margin-bottom: 0pt;  ">
<div class="Heading" >Voltech Engineers Private Limited</div>
			<div class="value">Voltech Eco Tower,</div>
			<div class="value">#2/429,Mount Poonamallee Road</div>
			<div class="value">Ayyappanthangal, Chennai-600056</div>
			<div class="value">Ph.:+91-44-43978000, Fax:044-42867746</div>
			<div class="value">Web:www.voltechgroup.com</div>
</div>
</div>
	
	</br>
	
<div  style="text-align: center;border-top: 1px solid #ccc; border-bottom: 1px solid #ccc; padding: 7px 0 4px 0; display: flex;justify-content: space-around; ">
Payslip for the month of:</div>

<div style="padding:10px 0 5px 0">
<div style="float: left; width: 40%; margin-bottom: 0pt; border-right:1px solid #ccc;">
<div style="text-align:left;border-bottom: 1px solid #ccc;font-weight: 700;">Employee Details</div>	
<table>
<tr><td width="30%">Emp Name</td><td width="70%" align="right">{{$model->employee->emp_name}}</td></tr>
<tr><td width="30%">Emp ID</td><td width="70%" align="right">{{ $model->employee->emp_code}}</td></tr>
<tr><td >Designation</td><td  align="right">{{ $model->employee->designation->designation_name}}</td></tr>
<tr><td >PF No.</td><td  align="right">{{ $model->employee->statutory->epfno}}</td></tr>
<tr><td >ESI No.</td><td  align="right">{{$model->employee->statutory->esino}}</td></tr>
<tr><td >UAN</td><td  align="right">{{ $model->employee->statutory->epfuanno}}</td></tr>
<tr><td >DOJ</td><td  align="right">{{  date('d/m/Y', strtotime($model->date_of_joining)))}}</td></tr>
<tr><td >Paid days</td><td  align="right">{{ $model->paiddays}}</td></tr>
<tr><td colspan="2" style="text-align:left;border-bottom: 1px solid #ccc;font-weight: 700;"> <br>Employer Contribution</td>

<tr><td colspan="2" > <br></td>
<tr><td width="30%">CTC</td><td  width="70%" align="right">{{$model->earned_ctc}}</td></tr>
</table>
</div>
	<div style="float: right; width: 55%; margin-bottom: 0pt;padding-left:5px; ">
<table>
<tr ><td width="60%" style="border-bottom: 1px solid #ccc;font-weight: 700;">Components</td><td width="30%" align="right" style="border-bottom: 1px solid #ccc;font-weight: 700;">Actual</td><td width="30%" align="right" style="border-bottom: 1px solid #ccc;font-weight: 700;">Earnings</td></tr>
<tr><td>Base Pay</td><td align="right">{{$actual->basic}}</td><td align="right">{{$model->basic}}</td></tr>
<tr><td colspan="3" > <br></td>
<tr><td>Gross Earnings</td><td align="right">{{$actual->gross}}</td><td align="right">{{$model->total_earning}}</td></tr>	
<tr><td colspan="3" style="text-align:right;border-bottom: 1px solid #ccc;font-weight: 700;"> <br>Deductions</td>'.$deductions.'
<tr><td colspan="3" > <br></td>
<tr><td>Total Deduction</td><td align="right"></td><td align="right">{{$model->total_deduction}}</td></tr>	
<tr><td colspan="3" > <br></td>
<tr><td>NET PAY:</td><td align="right"></td><td align="right">{{$model->net_amount}}</td></tr>	
</table>
</div>
</div>
<div  style="text-align: center;border-top: 1px solid #ccc; border-bottom: 1px solid #ccc; padding: 7px 0 4px 0; display: flex;justify-content: space-around; ">
This is a system generated payslip. Hence signature not required.</div>';
@endsection