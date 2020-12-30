@extends('layouts.app')

@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Set New Salary Month</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Create</a></li>
        </ol>
    </div>
    <br />
    <!-- <div class="col">
        <span class="page-title">Applicant</span> &#187; Create
    </div>-->
</div>
@endsection
<?php
error_reporting(0);
$salarymonth = App\Models\SalaryMonths::orderByDesc('month')->get();
?>

@section('content')


<div class="ml-1">
    <div class="mt-1 text-gray-600 dark:text-gray-400 text-sm">
        <div class="row">
            <div class="col"> 
             <h5><u> Salary Month List</u></h5>
             <table class="table table-bordered" width="100%">
             <tr><th>sl</th><th>Month</th><th>Action</th></tr>
             @foreach($salarymonth as $month)
<tr><td>{{$loop->iteration}}</td><td>{{date('F Y', strtotime($month->month))}}</td><td></td></tr>
             @endforeach
             </table>
              </div>
            <div class="col">
            <h5><u>Set New Salary Month</u></h5>
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
                @endif
                <form action="{{ url('/monthstore') }}" method="POST">
                    {{ csrf_field() }}

                   
                    <div class="form-group row">
                        <label for="sal_month" class="col-sm-2 form-label">Month</label>
                        <div class=" col-md-6">
                            <input type="text" name="sal_month" id="sal_month" class="form-control" value="">
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col-md-3"></div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-danger" id="setnewmonth">
                                Submit
                            </button>
                        </div>                       
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
$('#sal_month').datepicker({
    autoclose: true,
    zIndex: 2048,
    dateFormat: 'mm-yy',
});
</script>
@endpush