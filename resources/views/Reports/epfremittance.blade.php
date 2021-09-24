@extends('layouts.app')
@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Report</a></li>
            <li class="breadcrumb-item"><a href="#">Salary</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{url('/epfremittance')}}">EPF
                    Remittance</a></li>
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
            <form action="{{ url('/epfremittancepost') }}" method="POST">
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
                            <a href="{{url('/epfremittance')}}"><button type="button" id="clearBtn"
                                    class="btn  btn-sm">Clear</button></a>
                        </td>
                        <?php 
                        if($project == ''){
                            ?>
                            <td>
                            <button type='button'
                                onclick="location.href='{{url('/epfremittanceexport')}}'"
                                class="btn btn-sm btn-danger" style="width:100%">Export</button>
                        </td>
                       <?php }else{ ?>
                        <td>
                            <button type='button'
                                onclick="location.href='{{url('/epfremittanceexport/'.$project.'/'.$month)}}'"
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
                    <th>SI</th>
                    <th>UAN NO</th>
                    <th>Emp Code</th>
                    <th>Emp Name</th>
                    <th>Branch</th>
                    <th>Gross Pay</th>
                    <th>EPF Wages</th>
                    <th>EPS Wages</th>
                    <th>EDLIC Wages</th>
                    <th>EPF Cont</th>
                    <th>EPS Cont</th>
                    <th>Diff EPF & EPS </th>
                    <th>NCP Days </th>
                </tr>
            </thead>
            <tbody>
                @foreach($empsalary as $salary)
                @php
                $netpayment = $salary->total_earning-$salary->total_deduction;
                $takehome = $netpayment + $salary->mobile_allowance +$salary->travel_allowance +
                $salary->laptop_allowance + $salary->conveyance_allowance;
                            if($salary->gross > 15000){
                                $EPScontribution = 1250;
                            }else{
                                $check = round($salary->gross*0.0833);
                            $EPScontribution = $check;
                            }
                @endphp
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$salary->employee->statutory->epfuanno}}</td>
                    <td>{{$salary->employee->emp_code}}</td>
                    <td>{{$salary->employee->emp_name}}</td>
                    <td>{{$salary->employee->project->project_name}}</td>
                    <td>{{$salary->gross}}</td>
                    <td>{{$salary->gross-$salary->hra}}</td>
                    <td>{{$salary->gross-$salary->hra}}</td>
                    <td>{{$salary->gross-$salary->hra}}</td>
                    <td>{{$salary->pf}}</td>
                    <td>{{$EPScontribution}}</td>
                    <td>{{$salary->pf-$EPScontribution}}</td>
                    <td>{{$salary->employee->ncpdays($salary->empid,$salary->month)}}</td>
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