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
        <!-- <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:180px;color:white;text-align:center" class="nav-link"
            href="{{ url('/certificateedit/' . $model->id)}}"><b>Cerificate</b></a>
        </li> -->
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
        <form action="{{ url('/grievance_editpost/'.$model->id) }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="p-2" style="background-color:#e9ecec;">
                <i class="fa fa-user" aria-hidden="true"></i>&nbsp;
                Grievance Redressal
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
                <label for="grievance" class="col-sm-3 form-label">Grievance No</label>
                <div class=" col-md-3">
                    <input type="text" name="grievance_no" id="grievance_no" class="form-control form-control-sm"
                        value="{{$gr->grievance_no}}">
                </div>
                <label for="employee_code" class="col-sm-3 form-label">Employee Code</label>
                <div class=" col-md-3">
                    <input type="text" name="employee_code" id="employee_code" class="form-control form-control-sm"
                        value="{{$model->emp_code}}" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="grievance" class="col-sm-3 form-label">Employee Name</label>
                <div class=" col-md-3">
                    <input type="text" name="employee_name" id="employee_name" class="form-control form-control-sm"
                        value="{{$model->emp_name}}" readonly>
                </div>
                <label for="employee_code" class="col-sm-3 form-label">Project</label>
                <div class=" col-md-3">
                    <input type="text" name="project" id="project" class="form-control form-control-sm"
                        value="{{$projects1->project_name}}" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="grievance" class="col-sm-3 form-label">Designation</label>
                <div class=" col-md-3">
                    <input type="text" name="designation" id="designation" class="form-control form-control-sm"
                        value="{{$desg1->designation_name}}" readonly>
                </div>
                <label for="employee_code" class="col-sm-3 form-label">Date of Grievance</label>
                <div class=" col-md-3">
                    <input type="text" name="dateofgrievance" id="dateofgrievance" class="form-control form-control-sm"
                        value="{{$gr->dateofgrievance}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="grievance" class="col-sm-3 form-label">Query</label>
                <div class=" col-md-3">
                    <input type="text" name="queryies" id="queryies" class="form-control form-control-sm" value="{{$gr->query}}">
                </div>
                <label for="employee_code" class="col-sm-3 form-label">TAT</label>
                <div class=" col-md-3">
                    <input type="text" name="tat" id="tat" class="form-control form-control-sm" value="{{$gr->tat}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="grievance" class="col-sm-3 form-label">Action Taken</label>
                <div class=" col-md-3">
                    <input type="text" name="action" id="action" class="form-control form-control-sm" value="{{$gr->action}}">
                </div>
                <label for="employee_code" class="col-sm-3 form-label">Grievance Address by - JRR/RJ</label>
                <div class=" col-md-3">
                    <input type="text" name="grievance_address" id="grievance_address"
                        class="form-control form-control-sm" value="{{$gr->grievance_address}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="grievance" class="col-sm-3 form-label">Grievance Resolved Date</label>
                <div class=" col-md-3">
                    <input type="text" name="grievance_resolved_date" id="grievance_resolved_date"
                        class="form-control form-control-sm" value="{{$gr->grievance_resolved_date}}">
                </div>
                <label for="employee_code" class="col-sm-3 form-label">Remarks</label>
                <div class=" col-md-3">
                    <input type="text" name="remarks" id="remarks" class="form-control form-control-sm" value="{{$gr->remarks}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="institute" class="col-sm-3 form-label">Status</label>
                <div class=" col-md-3">
                    <select class="form-control form-control-sm " id="status" name="status" required>
                    <option value="{{$gr->status}}">{{$gr->status}}</option>
                        <option></option>
                        <option value="Open">Open</option>
                        <option value="Closed">Closed</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-1"></div>
                <div class="col-md-2">
                    <a class="btn btn-dark" href="{{ url('/bgv_edit/' . $model->id) }}"><i
                            class="glyphicon glyphicon-chevron-left"></i> Back</a>
                </div>

                <div class="col-md-1"></div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-plus"></i> Next
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
    $("#status").select2({
        //  theme: 'classic'
    });

});
</script>
@endpush