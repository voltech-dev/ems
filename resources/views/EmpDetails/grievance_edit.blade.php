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
            <li class="breadcrumb-item"><a href="#">Grievance</a></li>
            <li class="breadcrumb-item"><a href="#">{{$model->employee_name}}</a></li>
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
        <a style="width:120px;color:white;text-align:center" class="nav-link"
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
                href="{{ url('/empfileedit/' . $model->id)}}"><b>Document</b></a>
        </li>
        <li class="nav-item active" style="background-color:#00a09d;border:1px solid white">
            <a style="width:80px;color:white;text-align:center" class="nav-link"
                href="{{  url('/personaldetails_edit/' . $model->id)}}"><b>Personal</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:80px;color:white;text-align:center" class="nav-link"
                href="{{ url('/bgv_edit/' . $model->id)}}"><b>BGV</b></a>
        </li>
        <li class="nav-item " style="background:#fff;border:1px ">
            <a style="width:100px;color:#367fa9;text-align:center" class=""
                href="{{ url('/grievance_edit/' . $model->id)}}"><b>Grievance</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:80px;color:white;text-align:center" class="nav-link"
                href="{{ url('/exit_edit/' . $model->id)}}"><b>Exit</b></a>
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
        <form action="{{ url('/grievance_editpost/'.$model->id) }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="p-2" style="background-color:#e9ecec;">
                <i class="fa fa-user" aria-hidden="true"></i>&nbsp;
                Grievance Redressal
            </div>
            <input type="hidden" name="empid" id="empid" class="form-control" value="{{$model->id}}">

            <br>
            <div class="form-group row">
                <label for="grievance" class="col-sm-3 form-label">Grievance No</label>
                <div class=" col-md-3">
                    <input type="text" name="grievance_no" id="grievance_no" class="form-control form-control-sm"
                        value="{{$model->grievance_no}}" readonly>
                </div>
                <label for="employee_code" class="col-sm-3 form-label">Employee Code</label>
                <div class=" col-md-3">
                    <input type="text" name="employee_code" id="employee_code" class="form-control form-control-sm"
                        value="{{$model->empid}}" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="grievance" class="col-sm-3 form-label">Employee Name</label>
                <div class=" col-md-3">
                    <input type="text" name="employee_name" id="employee_name" class="form-control form-control-sm"
                        value="{{$model->employee_name}}" readonly>
                </div>
                <label for="employee_code" class="col-sm-3 form-label">Project</label>
                <div class=" col-md-3">
                    <!-- <input type="text" name="project" id="project" class="form-control form-control-sm"
                        value="{{$model->project}}" readonly> -->
                    <select class="form-control form-control-sm " id="project" name="project" required>
                        <option value="{{$model->project}}">{{$model->project}}</option>
                        @foreach($projects as $project)
                        <option value="{{$project->project_name}}">{{$project->project_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="grievance" class="col-sm-3 form-label">Designation</label>
                <div class=" col-md-3">
                    <!-- <input type="text" name="designation" id="designation" class="form-control form-control-sm"
                        value="{{$model->designation}}" readonly> -->
                    <select class="form-control form-control-sm " id="designation" name="designation" required>
                        <option value="{{$model->designation}}">{{$model->designation}}</option>
                        @foreach($designation as $desg)
                        <option value="{{$desg->designation_name}}">{{$desg->designation_name}}</option>
                        @endforeach
                    </select>
                </div>
                <label for="employee_code" class="col-sm-3 form-label">Date of Grievance</label>
                <div class=" col-md-3">
                    <input type="text" name="dateofgrievance" id="dateofgrievance" class="form-control form-control-sm"
                        value="{{ $model->dateofgrievance ? date('d-m-Y', strtotime($model->dateofgrievance)) : ''}}">

                </div>
            </div>
            <div class="form-group row">
                <label for="grievance" class="col-sm-3 form-label"> Type of Query</label>
                <div class=" col-md-3">
                    <select class="form-control form-control-sm " id="type_of_queryies" name="type_of_queryies"
                        required>
                        <option value="{{$model->type_of_query}}" selected>{{$model->type_of_query}}</option>
                        <option value=""></option>
                        <option value="PF">PF</option>
                        <option value="ESI">ESI</option>
                        <option value="Insurance">Insurance</option>
                        <option value="Salary">Salary</option>
                        <option value="Salary Slip">Salary Slip</option>
                        <option value="Form-16">Form-16</option>
                        <option value="Attendance">Attendance</option>
                        <option value="E-Mail">E-Mail</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <label for="grievance" class="col-sm-3 form-label">Query</label>
                <div class=" col-md-3">
                    <textarea name="queryies" id="queryies"
                        class="form-control form-control-sm">{{$model->query}}</textarea>

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
                <label for="employee_code" class="col-sm-3 form-label">Grievance Address</label>
                <div class=" col-md-3">
                    <!-- <input type="text" name="grievance_address" id="grievance_address"
                        class="form-control form-control-sm" value="{{$model->grievance_address}}"> -->
                        <select class="form-control form-control-sm " id="grievance_address" name="grievance_address">
                        <option value="{{$model->grievance_address}}" selected>{{$model->grievance_address}}</option>
                        <option value="Redressal officer 1">Redressal officer 1</option>
                        <option value="Redressal officer 2">Redressal officer 2</option>
                        <option value="Redressal officer 3">Redressal officer 3</option>
                    </select>
                </div>
                <label for="grievance" class="col-sm-3 form-label">Grievance Resolved Date</label>
                <div class=" col-md-3">
                    <input type="text" name="grievance_resolved_date" id="grievance_resolved_date"
                        class="form-control form-control-sm" value="{{ $model->grievance_resolved_date ? date('d-m-Y', strtotime($model->grievance_resolved_date)) : ''}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="employee_code" class="col-sm-3 form-label">Remarks</label>
                <div class=" col-md-3">
                    <textarea name="remarks" id="remarks"
                        class="form-control form-control-sm">{{$model->remarks}}</textarea>
                </div>
                <label for="institute" class="col-sm-3 form-label">Status</label>
                <div class=" col-md-3">
                    <select class="form-control form-control-sm " id="status" name="status" required>
                        <option value="{{$model->status}}">{{$model->status}}</option>
                        <option></option>
                        <option value="Open">Open</option>
                        <option value="Closed">Closed</option>
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
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-check"></i> Save
                    </button>
                </div>
            </div>
    </div>
    </form>
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
    $('#status,#project,#designation,#type_of_queryies,#grievance_address').select2({
        //  theme: 'classic'
    });

});
</script>
@endpush