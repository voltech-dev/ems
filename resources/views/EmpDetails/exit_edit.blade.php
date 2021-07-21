@extends('layouts.app')
<style>
li a:hover {
    background: #006d6b;
}

.imgage-box {

    height: 185px;
    border: 1px solid #c1bdd6;
}
</style>
@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">{{$model->emp_name}}</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Edit</a></li>
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

$projects1 = App\Models\ProjectDetails::where (['id'=>$model->project_id])->first();
$desg1 = App\Models\Designation::where (['id'=>$model->designation_id])->first();
?>

@section('content')
<div class="row col pb-2" style="margin-left: 5px;">
    <ul class="nav">
        <li class="nav-item" style="background-color:#00a09d;border:1px solid white">
            <a style="width:80px;color:white;text-align:center" class="nav-link"
                href="{{ route('empdetails.index')}}"><b>List</b></a>
        </li>
        <li class="nav-item" style="background-color:#00a09d;border:1px solid white">
            <a style="width:120px;color:white;text-align:center" class="nav-link"
                href="{{ route('empdetails.edit',$model->id)}}"><b>Employee </b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:150px;color:white;text-align:center" class="nav-link"
                href="{{ url('/remunerationedit/' . $model->id)}}"><b>Remuneration</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:120px;color:white;text-align:center" class="nav-link"
                href="{{ url('/statutoryedit/' . $model->id)}}"><b>Statutory</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:50px;color:white;text-align:center" class="nav-link"
                href="{{ url('/bankedit/' . $model->id)}}"><b>Bank</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:100px;color:white;text-align:center" class="nav-link"
                href="{{ url('/educationedit/' . $model->id)}}"><b>Education</b></a>
        </li>
        <!-- <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:100px;color:white;text-align:center" class="nav-link"
                href="{{ url('/certificateedit/' . $model->id)}}"><b>Certificate</b></a>
        </li> -->
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:100px;color:white;text-align:center" class="nav-link"
                href="{{ url('/empfileedit/' . $model->id)}}"><b>Document</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:100px;color:white;text-align:center" class="nav-link"
                href="{{ url('/personaldetails_edit/' . $model->id)}}"><b>Personal</b></a>
        </li>
        <!-- <li class="nav-item " style="background-color:#00a09d;border:1px solid white">-->
        <!-- <a style="width:100px;color:white;text-align:center" class="nav-link" href="{{ url('/personal')}}"><b>Personal</b></a> -->
        <!-- <a style="width:100px;color:white;text-align:center" class="nav-link" href="#"><b>Personal</b></a>
        </li> -->
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:100px;color:white;text-align:center" class="nav-link"
                href="{{ url('/bgv_edit/' . $model->id)}}"><b>BGV</b></a>
        </li>
        <!-- <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:100px;color:white;text-align:center" class="nav-link"
                href="{{ url('/grievance_edit/' . $model->id)}}"><b>Grievance</b></a>
        </li> -->
        <li class="nav-item " style="background: #ffffff;border:1px ">
            <a style="width:50px;color:#367fa9;text-align:center" class="nav-link"
                href="{{ url('/exit_edit/' . $model->id)}}"><b>Exit</b></a>
        </li>
    </ul>
</div>

<div class="ml-6 mr-6">
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
    <div class="mt-1  text-gray-600 dark:text-gray-400 text-sm">
        <form action="{{ url('/exit_editpost/'. $model->id) }}" method="POST">
            {{ csrf_field() }}

            <div class="p-2" style="background-color:#e9ecec;">
                <i class="fa fa-user" aria-hidden="true"></i>&nbsp;
                Full & Final Settlement
            </div>
            <input type="hidden" name="empid" id="empid" class="form-control" value="{{$model->id}}">

            <!-- <div class="form-group row mt-5">
                <label for="emp_code" class="col-sm-2 form-label">Emp Code <span style="color:red">*</span></label>
                <div class=" col-md-3">
                    <input type="text" name="emp_code" id="emp_code" class="form-control form-control-sm" value=""
                        required>
                </div>

                <label for="emp_name" class="col-sm-2 form-label">Emp Name <span style="color:red">*</span></label>
                <div class=" col-md-3">
                    <input type="text" name="emp_name" id="emp_name" class="form-control form-control-sm" value=""
                        required>
                </div>
            </div> -->
            <br>
            <div class="form-group row">
                <label for="grievance" class="col-sm-3 form-label">Date of Resignation</label>
                <div class=" col-md-3">
                    <input type="text" name="date_of_resignation" id="date_of_resignation" class="form-control form-control-sm"
                        value="{{$ex->date_of_resignation}}">
                </div>
                <label for="employee_code" class="col-sm-3 form-label">Date of Leaving</label>
                <div class=" col-md-3">
                    <input type="text" name="date_of_leaving" id="date_of_leaving" class="form-control form-control-sm"
                        value="{{$ex->date_of_leaving}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="grievance" class="col-sm-3 form-label">Reason of Leaving</label>
                <div class=" col-md-3">
                    <input type="text" name="reason_of_leaving" id="reason_of_leaving" class="form-control form-control-sm"
                        value="{{$ex->reason_of_leaving}}" >
                </div>
                <label for="employee_code" class="col-sm-3 form-label">F & F Signed Copy</label>
                <div class=" col-md-3">
                <select class="form-control form-control-sm " id="f_f_signed" name="f_f_signed" required>
                <option value="{{$ex->f_f_signed}}">{{$ex->f_f_signed}}</option>
                        <option></option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="grievance" class="col-sm-3 form-label">Exit Form</label>
                <div class=" col-md-3">
                <select class="form-control form-control-sm " id="exit_form" name="exit_form" required>
                <option value="{{$ex->exit_form}}">{{$ex->exit_form}}</option>
                        <option></option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                </select>
                </div>
                <label for="employee_code" class="col-sm-3 form-label">Handling over Completed</label>
                <div class=" col-md-3">
                <select class="form-control form-control-sm " id="handling" name="handling" required>
                <option value="{{$ex->handling}}">{{$ex->handling}}</option>
                        <option></option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="grievance" class="col-sm-3 form-label">Project Clearance</label>
                <div class=" col-md-3">
                <select class="form-control form-control-sm " id="project_clearance" name="project_clearance" required>
                <option value="{{$ex->project_clearance}}">{{$ex->project_clearance}}</option>
                        <option></option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                </select>
                </div>
                <label for="employee_code" class="col-sm-3 form-label">F & F Settled</label>
                <div class=" col-md-3">
                <select class="form-control form-control-sm " id="f_f" name="f_f" required>
                <option value="{{$ex->f_f}}">{{$ex->f_f}}</option>
                        <option></option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                </select>
                </div>
            </div>
           
            <div class="form-row">
                <div class="col-md-1"></div>
                <div class="col-md-2">
                    <a class="btn btn-dark" href="{{  url('/grievance_edit/' . $model->id) }}"><i
                            class="glyphicon glyphicon-chevron-left"></i> Back</a>
                </div>

                <div class="col-md-1"></div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-plus"></i> Next
                    </button>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-2">
                <a class="btn btn-light" href="{{  url('/fandf/' . $model->id) }}"><i
                            class="glyphicon glyphicon-print"></i> View</a>
                    </button>
                </div>
            </div>
            </div>
    </div>
    </form>
</div>
@endsection
@push('scripts')
<script>
$(function() {
    $('#date_of_resignation,#date_of_leaving').datepicker({
        autoclose: true,
        zIndex: 2048,
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
    });
    $("#f_f_signed,#exit_form,#handling,#project_clearance,#f_f").select2({
        //  theme: 'classic'
    });

});
</script>
@endpush