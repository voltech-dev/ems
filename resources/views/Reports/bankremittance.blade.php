@extends('layouts.app')
@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Report</a></li>
            <li class="breadcrumb-item"><a href="#">Salary</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{url('/bankremittance')}}">Bank
                    Remittance</a></li>
        </ol>
    </div>
</div>
@endsection
<?php
error_reporting(0);
$projects = App\Models\ProjectDetails::all();
//echo $project;
if($project){
    $hide = "";
}else{
    $hide = "hidden";
}
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
            <form action="{{ url('/bankremittancepost') }}" method="POST">
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
                            <a href="{{url('/bankremittance')}}"><button type="button" id="clearBtn"
                                    class="btn  btn-sm">Clear</button></a>
                        </td>
                        <td>
                            <button type='button'
                                onclick="location.href='{{url('/bankremittanceexport/'.$project.'/'.$month)}}'"
                                class="btn btn-sm btn-danger" style="width:100%" {{$hide}}>Export</button>
                        </td>
                    </tr>
                </tbody>
            </form>
        </table>

        <table class="table table-striped datatable" id="thegrid" width="100%">
            <thead>
                <tr>
                    <th>SI.No</th>
                    <th>Debit Account No</th>
                    <th>Beneficiary Name</th>
                    <th>Beneficiary Acc No</th>
                    <th>Beneficiary Bank Swift Code / IFSC Code</th>
                    <th>Payment Amount</th>
                    <th>Value Date</th>
                    <th>Message Type</th>
                    <th>Remarks</th>
                    <th>Transaction Type Code</th>
                    <th>Beneficiary Mobile No</th>
                    <th>Beneficiary E-mail Id</th>
                </tr>
            </thead>
            <tbody>
                @foreach($empsalary as $salary)
                @php
                    $netpayment = $salary->total_earning-$salary->total_deduction;
                    $takehome = $netpayment + $salary->mobile_allowance +$salary->travel_allowance +
                    $salary->laptop_allowance + $salary->conveyance_allowance;
                    @endphp
            <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>21690400000063</td>
                    <td>{{$salary->employee->emp_name}}</td>
                    <td>{{$salary->employee->bank->acnumber}}</td>
                    <td>{{$salary->employee->bank->ifsc}}</td>
                    <td>{{$takehome}}</td>
                    <td>{{$salary->month}}</td>
                    <td>NEFT</td>
                    <td> <?php 
                    $monthname = $salary->month;
                    $month_name = date("M",strtotime($monthname));
                    $yearName = date("Y",strtotime($monthname));
                    $val = DateTime::createFromFormat('M', $month_name);
                    $month_name2 = $val->format('M');
                    echo $month_name2."'".$yearName."Salary";
                    ?></td>
                    <td>NEFT</td>
                    <td>{{$salary->employee->mobile}}</td>
                    <td>hr.support@voltechgroup.com</td>
            </tr>
                @endforeach
            </tbody>
        </table>
    </div>
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


    theGrid = $('#thegrid').DataTable({
        "scrollX": true,
    });

    $("#project").select2({
        //  theme: 'classic'
    });      
      

});
</script>
@endpush