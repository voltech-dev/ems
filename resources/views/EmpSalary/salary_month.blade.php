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

?>

@section('content')



<div class="p-6">
    <div class="ml-1">
        @if ($errors->any())
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="mt-1 text-gray-600 dark:text-gray-400 text-sm">
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
            <form action="{{ url('/EmpSalary/monthstore') }}" method="POST">
                {{ csrf_field() }}

                <h5><u>Set New Salary Month</u></h5>
                <div class="form-group row">
                    <label for="sal_month" class="col-sm-2 form-label">Month</label>
                    <div class=" col-md-3">
                        <input type="text" name="sal_month" id="sal_month" class="form-control" value="">
                    </div>

                    <label for="acnumber" class="col-sm-2 form-label"></label>
                    <div class=" col-md-3">
                      
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success" id="setnewmonth">
                            <i class="fa fa-plus"></i> Submit
                        </button>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                        <a class="btn btn-dark" href="{{ url('/applicants') }}"><i
                                class="glyphicon glyphicon-chevron-left"></i> Back</a>
                    </div>
                </div>
            </form>
        </div>
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
