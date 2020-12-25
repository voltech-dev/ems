@extends('layouts.app')

@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">EmpDetails</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Create</a></li>
        </ol>
    </div>
</div>
@endsection
<?php
$projects = App\Models\ProjectDetails::all();
$location = App\Models\Locations::all();
$status =  App\Models\Statuses::all();
$auth =  App\Models\Authorities::all();
$designation = App\Models\Designation::all();

error_reporting(0);

?>

@section('content')

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
        <form action="{{ route('empdetails.store') }}" method="POST">
            {{ csrf_field() }}

            <h5><u>Emp Details</u></h5>
            <div class="form-group row">
                <label for="emp_code" class="col-sm-2 form-label">Emp Code</label>
                <div class=" col-md-3">
                    <input type="text" name="emp_code" id="emp_code" class="form-control" value="">
                </div>

                <label for="emp_name" class="col-sm-2 form-label">Emp Name</label>
                <div class=" col-md-3">
                    <input type="text" name="emp_name" id="emp_name" class="form-control" value="">
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-sm-2 form-label">Email</label>
                <div class=" col-md-3">
                    <input type="text" name="email" id="email" class="form-control" value="">
                </div>

                <label for="last_name" class="col-sm-2 form-label">Mobile No</label>
                <div class=" col-md-3">
                    <input type="text" name="mobile" id="mobile" class="form-control" value="">
                </div>
            </div>

            <div class="form-group row">
                <label for="first_name" class="col-sm-2 form-label">Project</label>
                <div class=" col-md-3">
                    <select class="form-control form-control-sm" name="project_id" id="project">
                        <option></option>
                        @foreach($projects as $pro)
                        <option value="{{$pro->id}}"
                            {{ old('project_id', $pro->project_name) == $pro->id ? 'selected' : '' }}>
                            {{ucfirst($pro->project_name)}}</option>
                        @endforeach
                    </select>
                </div>

                <label for="last_name" class="col-sm-2 form-label">Location</label>
                <div class=" col-md-3">
                    <select class="form-control form-control-sm" name="location_id" id="location">
                        <option></option>
                        @foreach($location as $locat)
                        <option value="{{$locat->id}}"
                            {{ old('location_id', $locat->location) == $locat->id ? 'selected' : '' }}>
                            {{ucfirst($locat->location)}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="designation" class="col-sm-2 form-label">Designation</label>
                <div class=" col-md-3">

                    <select class="form-control form-control-sm" name="designation" id="designation">
                        <option></option>
                        @foreach($designation as $desig)
                        <option value="{{$desig->id}}"
                            {{ old('designation', $desig->designation_id) == $desig->id ? 'selected' : '' }}>
                            {{ucfirst($desig->designation_name)}}</option>
                        @endforeach
                    </select>

                </div>

                <label for="doj" class="col-sm-2 form-label">Date Of Joining</label>
                <div class=" col-md-3">
                    <input type="text" name="doj" id="doj" class="form-control" value="">
                </div>
            </div>

            <div class="form-group row">


                <label for="dol" class="col-sm-2 form-label">Date Of Leaving</label>
                <div class=" col-md-3">
                    <input type="text" name="dol" id="dol" class="form-control" value="">
                </div>

                <label for="lad" class="col-sm-2 form-label">Last Appraisal Date</label>
                <div class=" col-md-3">
                    <input type="text" name="lad" id="lad" class="form-control" value="">
                </div>
            </div>

            <div class="form-group row">


                <!-- <label for="authority_id" class="col-sm-2 form-label"> Reporting Authority</label>
                <div class=" col-md-3">
                    <select class="form-control form-control-sm" name="authority_id">
                        <option></option>
                        @foreach($auth as $authority)
                        <option value="{{$locat->id}}"
                            {{ old('authority_id', $authority->authority_name) == $authority->id ? 'selected' : '' }}>
                            {{ucfirst($authority->authority_name)}}</option>
                        @endforeach
                    </select>
                </div>-->

                <label for="status_id" class="col-sm-2 form-label"> Status</label>
                <div class=" col-md-3">
                    <select class="form-control form-control-sm" name="status_id">
                        <option></option>
                        @foreach($status as $sta)
                        <option value="{{$sta->id}}"
                            {{ old('location_id', $sta->status) == $sta->id ? 'selected' : '' }}>
                            {{ucfirst($sta->status)}}</option>
                        @endforeach
                    </select>
                </div>

            </div>



            <div class="form-row">               
                <div class="col-md-1"></div>
                <div class="col-md-2">
                    <a class="btn btn-dark" href="{{ url('/EmpDetails') }}"><i
                            class="glyphicon glyphicon-chevron-left"></i> Back</a>
                </div>

                <div class="col-md-1"></div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-plus"></i> Next
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


@endsection
@push('scripts')
<script>
$(function() {
    $('#doj,#dol,#lad').datepicker({
        autoclose: true,
        zIndex: 2048,
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true,
    });
    $("#designation,#location,#project").select2();

});
</script>
@endpush