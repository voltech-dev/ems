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
            <li class="breadcrumb-item"><a href="#">{{$model->employee_name}}</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">View</a></li>
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
<!-- <div class="row col pb-2" style="margin-left: 5px;">
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
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:100px;color:white;text-align:center" class="nav-link"
                href="{{ url('/certificateedit/' . $model->id)}}"><b>Certificate</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:100px;color:white;text-align:center" class="nav-link"
                href="{{ url('/empfileedit/' . $model->id)}}"><b>Document</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:100px;color:white;text-align:center" class="nav-link"
                href="{{ url('/personaldetails_edit/' . $model->id)}}"><b>Personal</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
        <a style="width:100px;color:white;text-align:center" class="nav-link" href="{{ url('/personal')}}"><b>Personal</b></a>
        <a style="width:100px;color:white;text-align:center" class="nav-link" href="#"><b>Personal</b></a>
        </li> 
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:100px;color:white;text-align:center" class="nav-link"
                href="{{ url('/bgv_edit/' . $model->id)}}"><b>BGV</b></a>
        </li>
        <li class="nav-item " style="background: #ffffff;border:1px ">
            <a style="width:80px;color:#367fa9;text-align:center" class="nav-link"
                href="{{ url('/grievance/' . $model->id)}}"><b>Grievance</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:80px;color:white;text-align:center" class="nav-link" href="#"><b>Exit</b></a>
        </li>
    </ul>
</div> -->

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
        <div class="p-2" style="background-color:#e9ecec;">
            <i class="fa fa-user" aria-hidden="true"></i>&nbsp;
            Grievance Redressal
        </div>
        <br>
        <div class="form-group row">
            <label for="grievance" class="col-sm-3 form-label">Grievance No</label>
            <div class=" col-md-3">
                <input type="text" name="grievance_no" id="grievance_no" class="form-control form-control-sm"
                    value="{{$model->id}}">
            </div>
            <label for="employee_code" class="col-sm-3 form-label">Employee Code</label>
            <div class=" col-md-3">
                <input type="text" name="employee_code" id="employee_code" class="form-control form-control-sm"
                    value="{{$model->empid}}">
            </div>
        </div>
        <div class="form-group row">
            <label for="grievance" class="col-sm-3 form-label">Employee Name</label>
            <div class=" col-md-3">
                <input type="text" name="employee_name" id="employee_name" class="form-control form-control-sm"
                    value="{{$model->employee_name}}">
            </div>
            <label for="employee_code" class="col-sm-3 form-label">Project</label>
            <div class=" col-md-3">
                <input type="text" name="project" id="project" class="form-control form-control-sm"
                    value="{{$model->project}}">
            </div>
        </div>
        <div class="form-group row">
            <label for="grievance" class="col-sm-3 form-label">Designation</label>
            <div class=" col-md-3">
                <input type="text" name="designation" id="designation" class="form-control form-control-sm"
                    value="{{$model->designation}}">
            </div>
            <label for="employee_code" class="col-sm-3 form-label">Date of Grievance</label>
            <div class=" col-md-3">
                <input type="text" name="dateofgrievance" id="dateofgrievance" class="form-control form-control-sm"
                    value="{{ $model->dateofgrievance ? date('d-m-Y', strtotime($model->dateofgrievance)) : ''}}">
            </div>
        </div>
        <div class="form-group row">
            <label for="grievance" class="col-sm-3 form-label">Type of Query</label>
            <div class=" col-md-3">
                <input type="text" name="" id="" class="form-control form-control-sm" value="{{$model->type_of_query}}">
                </div>
                <label for="grievance" class="col-sm-3 form-label">Query</label>
                <div class=" col-md-3">
                    <textarea class="form-control form-control-sm">{{$model->query}} </textarea>
                    <!-- <input type="text" name="queryies" id="queryies" class="form-control form-control-sm"
                    value=""> -->
                </div>
            
        </div>
        <div class="form-group row">
            <label for="employee_code" class="col-sm-3 form-label">TAT</label>
            <div class=" col-md-3">
                <input type="text" name="tat" id="tat" class="form-control form-control-sm"
                    value="{{ $model->tat ? date('d-m-Y', strtotime($model->tat)) : ''}}">
            </div>
            <label for="grievance" class="col-sm-3 form-label">Action Taken</label>
            <div class=" col-md-3">
                <input type="text" name="action" id="action" class="form-control form-control-sm"
                    value="{{$model->action}}">
            </div>
        </div>
        <div class="form-group row">
            <label for="employee_code" class="col-sm-3 form-label">Grievance Address by - JRR/RJ</label>
            <div class=" col-md-3">
                <input type="text" name="grievance_address" id="grievance_address" class="form-control form-control-sm"
                    value="{{$model->grievance_address}}">
            </div>
            <label for="grievance" class="col-sm-3 form-label">Grievance Resolved Date</label>
            <div class=" col-md-3">
                <input type="text" name="grievance_resolved_date" id="grievance_resolved_date"
                    class="form-control form-control-sm"
                    value="{{ $model->grievance_resolved_date ? date('d-m-Y', strtotime($model->grievance_resolved_date)) : ''}}">
            </div>
        </div>
        <div class="form-group row">
            <label for="employee_code" class="col-sm-3 form-label">Remarks</label>
            <div class=" col-md-3">
                <textarea class="form-control form-control-sm"> {{$model->remarks}} </textarea>
                <!-- <input type="text" name="remarks" id="remarks" class="form-control form-control-sm"
                    value=""> -->
            </div>
            <label for="institute" class="col-sm-3 form-label">Status</label>
            <div class=" col-md-3">
                <select class="form-control form-control-sm " id="status" name="status" required>
                    <option value="{{$model->status}}">{{$model->status}}</option>
                    <!-- <option value="Open">Open</option>
                        <option value="Closed">Closed</option> -->
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-1"></div>
            <div class="col-md-2">
                <a class="btn btn-dark" href="{{ url('/grievancelist') }}"><i
                        class="glyphicon glyphicon-chevron-left"></i> Back</a>
            </div>

            <div class="col-md-1"></div>
            <div class="col-md-2">
                <!-- <button type="submit" class="btn btn-success">
                        <i class="fa fa-plus"></i> Next
                    </button> -->
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
$(function() {
    $('#dateofgrievance,#grievance_resolved_date').datepicker({
        autoclose: true,
        zIndex: 2048,
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
    });
    $("#status").select2({
        //  theme: 'classic'
    });

});
</script>
@endpush