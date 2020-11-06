@extends('layouts.app')

@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Statutory Details</a></li>
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
$projects = App\Models\ProjectDetails::all();
$location = App\Models\Locations::all();
$status =  App\Models\Statuses::all();
$auth =  App\Models\Authorities::all();

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
            <form action="{{ url('/EmpDetails/statutorystore') }}" method="POST">
                {{ csrf_field() }}

                <h5><u>Statutory Details</u></h5>
                <div class="form-group row">
                <input type="hidden" name="empid" id="empid" class="form-control"
                            value="{{$model->id}}">
                    <label for="esino" class="col-sm-2 form-label">ESI No</label>
                    <div class=" col-md-3">
                        <input type="text" name="esino" id="esino" class="form-control" value="">
                    </div>

                    <label for="esidispensary" class="col-sm-2 form-label">ESI Dispensary</label>
                    <div class=" col-md-3">
                        <input type="text" name="esidispensary" id="esidispensary" class="form-control" value="">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="epfno" class="col-sm-2 form-label">EPF No</label>
                    <div class=" col-md-3">
                        <input type="text" name="epfno" id="epfno" class="form-control" value="">
                    </div>

                    <label for="epfuanno" class="col-sm-2 form-label">EPF UAN No</label>
                    <div class=" col-md-3">
                        <input type="text" name="epfuanno" id="epfuanno" class="form-control" value="">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="professionaltax" class="col-sm-2 form-label">Professional Tax</label>
                    <div class=" col-md-3">
                        <select class="form-control form-control-sm" name="professionaltax">
                            <option></option>
                            <option value="Yes"> Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>

                    <label for="last_name" class="col-sm-2 form-label"></label>
                    <div class=" col-md-3">

                    </div>
                </div>



                <div class="form-row">
                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-plus"></i> Next
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