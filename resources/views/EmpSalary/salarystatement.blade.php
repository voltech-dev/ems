@extends('layouts.app')
@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Report</a></li>
            <li class="breadcrumb-item"><a href="#">Salary</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{url('/empsalarystatement')}}">Salary
                    Statement</a></li>
        </ol>
    </div>
</div>
@endsection
<?php
error_reporting(0);
$projects = App\Models\ProjectDetails::all();
//echo $project;
// if($project){
//     $hide = "";
// }else{
//     $hide = "hidden";
// }
?>
@section('content')
<div class="ml-1">
    <div class="mt-1 text-gray-600 dark:text-gray-400 text-sm ">
        @if ($message = Session::get('success'))

        <div class="alert alert-success alert-block">

            <button type="button" class="close" data-dismiss="alert">×</button>

            <strong>{{ $message }}</strong>

        </div>
        @endif
        <table border="0" cellspacing="5" cellpadding="5">
            <form action="{{ url('/salarystatementpost') }}" method="POST">
                {{ csrf_field() }}
                <tbody>
                    <tr>
                        <td>Project</td>
                        <td>
                            <select class="form-control form-control-sm" name="project_id" id="project" required>
                                <option></option>
                                @foreach($projects as $pro)
                                    @if($pro->id == $project)
                                    <option value="{{$pro->id}}" selected> {{$pro->project_name}}</option>
                                    @else 
                                    <option value="{{$pro->id}}"> {{$pro->project_name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                        <td>Month</td>
                        <td>
                            <input type="text" name="month" id="sal_month" class="form-control" value="" required>
                        </td>
                        <td>
                            <button type="submit" class="btn btn-success btn-sm" style="width:100%">Search</button>
                        </td>
                        <td>
                            <a href="{{url('/empsalarystatement')}}"><button type="button" id="clearBtn"
                                    class="btn  btn-sm">Clear</button></a>
                        </td>
                        <?php 
                        if($project == ''){
                            ?>
                            <td>
                            <button type='button'
                                onclick="location.href='{{url('/salarystatementexport')}}'"
                                class="btn btn-sm btn-danger" style="width:100%">Export</button>
                        </td>
                       <?php }else{ ?>
                        <td> 
                            <button type='button'
                                onclick="location.href='{{url('/salarystatementexport/'.$project.'/'.$month)}}'"
                                class="btn btn-sm btn-danger" style="width:100%">Export</button>
                        </td>
                       <?php
                        }
                        ?>
                        
                    </tr>
                </tbody>
            </form>
        </table>

        <table class="table table-striped datatable" id="thegrid" width="100%">
            <thead>
                <tr>
                    <th>SI.No</th>
                    <th>Emp Code</th>
                    <th>Emp Name</th>
                    <th>Designation</th>
                    <th>Project Name</th>
                    <th>Paid Days</th>
                    <th>Gross</th>
                    <th>Earning</th>
                    <th>Deduction</th>
                    <th>Net Amount</th>
                    <th>Take Home</th>
                    <th>CTC</th>
                </tr>
            </thead>
            <tbody>
                @foreach($empsalary as $empsalaries)
                <tr>
                    @php
                    $netpayment = $empsalaries->total_earning-$empsalaries->total_deduction;
                    $takehome = $netpayment + $empsalaries->mobile_allowance +$empsalaries->travel_allowance +
                    $empsalaries->laptop_allowance + $empsalaries->conveyance_allowance;
                    @endphp

                    <td>{{$loop->iteration}}</td>
                    <td>{{$empsalaries->employee->emp_code}}</td>
                    <td>{{$empsalaries->employee->emp_name}}</td>
                    <td>{{$empsalaries->employee->designation->designation_name}}</td>
                    <td>{{$empsalaries->employee->project->project_name}}</td>
                    <td>{{$empsalaries->paiddays}}</td>
                    <td>{{$empsalaries->gross}}</td>
                    <td>{{$empsalaries->total_earning}}</td>
                    <td>{{$empsalaries->total_deduction}}</td>
                    <td>{{$netpayment}}</td>
                    <td>{{$takehome}}</td>
                    <td>{{$empsalaries->earned_ctc}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div hidden>
    <table class="table table-striped datatable" id="thegrid1" width="100%">
        <thead>
            <tr>
                <th>SI.No</th>
                <th>Emp Code</th>
                <th>Emp Name</th>
                <th>Designation</th>
                <th>Project Name</th>
                <th>DOJ</th>
                <th>Gross Salary</th>
                <th>Basic</th>
                <th>HRA</th>
                <th>Conv Allowance</th>
                <th>Medical Allowance</th>
                <th>Edu Allowance</th>
                <th>Spl Allowance</th>
                <th>Gross</th>

                <th>Month Days</th>
                <th>Pay Days</th>
                <th>Basic</th>
                <th>HRA</th>
                <th>Conv Allowance</th>
                <th>Medical Allowance</th>
                <th>Edu Allowance</th>
                <th>Spl Allowance</th>
                <th>Gross</th>

                <th>EPF</th>
                <th>ESI</th>
                <th>PT</th>
                <th>TDS</th>
                <th>Arrear Deduction</th>
                <th>Total Deduction</th>
                <th>Net Salary</th>

                <th>Conveyance Allowance</th>
                <th>Laptop Allowance</th>
                <th>Travel Allowance</th>
                <th>Mobile Allowance</th>
                <th>Take Home Salary</th>

                <th>EMR EPF</th>
                <th>EPF Admin</th>
                <!-- <th>EDLI Admin</th> -->
                <th>EMR ESI</th>
                <th>Insurances (GPA+GMC+WC)</th>
                <th>Monthly CTC</th>
                <th>Service Charge</th>
                <th>Total Basic Invoice</th>
                <th>GST @ 18%</th>
                <th>Total Invoice Value</th>
            </tr>
        </thead>
        <tbody>
            @foreach($empsalary as $empsalaries)
            <tr>
                @php
                $netpayment = $empsalaries->total_earning-$empsalaries->total_deduction;
                $takehome = $netpayment + $empsalaries->mobile_allowance +$empsalaries->travel_allowance +
                $empsalaries->laptop_allowance + $empsalaries->conveyance_allowance;
                $servicecharge = $empsalaries->earned_ctc*6/100;
                $totalbasicinvoice =
                $empsalaries->earned_ctc+$empsalaries->conveyance_allowance+$empsalaries->laptop_allowance+$empsalaries->travel_allowance+$empsalaries->mobile_allowance+$servicecharge;
                $gst = $totalbasicinvoice*18/100;
                $totalinvoicevalue = $totalbasicinvoice+$gst;
                @endphp

                <td>{{$loop->iteration}}</td>
                <td>{{$empsalaries->employee->emp_code}}</td>
                <td>{{$empsalaries->employee->emp_name}}</td>
                <td>{{$empsalaries->employee->designation->designation_name}}</td>
                <td>{{$empsalaries->employee->project->project_name}}</td>
                <td>{{$empsalaries->employee->date_of_joining}}</td>
                <td>{{$empsalaries->gross}}</td>
                <td>{{$empsalaries->basic}}</td>
                <td>{{$empsalaries->hra}}</td>
                <td>{{$empsalaries->conveyance_earning}}</td>
                <td>{{$empsalaries->medical_earning}}</td>
                <td>{{$empsalaries->education_earning}}</td>
                <td>{{$empsalaries->spl_allowance}}</td>
                <td>{{$empsalaries->gross}}</td>


                <td>{{$empsalaries->paiddays}}</td>
                <td>{{$empsalaries->paiddays}}</td>
                <td>{{$empsalaries->basic}}</td>
                <td>{{$empsalaries->hra}}</td>
                <td>{{$empsalaries->conveyance_earning}}</td>
                <td>{{$empsalaries->medical_earning}}</td>
                <td>{{$empsalaries->education_earning}}</td>
                <td>{{$empsalaries->spl_allowance}}</td>
                <td>{{$empsalaries->gross}}</td>

                <td>{{$empsalaries->pf_employer_contribution}}</td>
                <td>{{$empsalaries->esi_employer_contribution}}</td>
                <td>{{$empsalaries->professional_tax}}</td>
                <td>{{$empsalaries->tds}}</td>
                <td>{{$empsalaries->arrear}}</td>
                <td>{{$empsalaries->total_deduction}}</td>
                <td>{{$netpayment}}</td>



                <td>{{$empsalaries->conveyance_allowance}}</td>
                <td>{{$empsalaries->laptop_allowance}}</td>
                <td>{{$empsalaries->travel_allowance}}</td>
                <td>{{$empsalaries->mobile_allowance}}</td>
                <td>{{$takehome}}</td>

                <td>{{$empsalaries->pf}}</td>
                <td>{{$empsalaries->pf_employer_contribution}}</td>
                <td>{{$empsalaries->esi_employer_contribution}}</td>
                <td>{{$empsalaries->insurance}}</td>
                <td>{{$empsalaries->earned_ctc}}</td>
                <td>{{round($servicecharge,2)}}</td>
                <td>{{round($totalbasicinvoice,2)}}</td>
                <td>{{round($gst,2)}}</td>
                <td>{{round($totalinvoicevalue,2)}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
$(document).ready(function() {

    $('#sal_month').datepicker({
        autoclose: true,
        zIndex: 2048,
        dateFormat: 'mm-yy',
    });


    theGrid = $('#thegrid').DataTable({});
    theGrid = $('#thegrid1').DataTable({
        "scrollX": true,
        "bPaginate": false,
        "searching": false
    });
    $("#project").select2({
        //  theme: 'classic'
    });
});
</script>
@endpush