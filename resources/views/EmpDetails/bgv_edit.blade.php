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
        <li class="nav-item "  style="background: #ffffff;border:1px ">
            <a style="width:80px;color:#367fa9;text-align:center" class="nav-link"
                href="{{ url('/bgv_edit/' . $model->id)}}"><b>BGV</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:100px;color:white;text-align:center" class="nav-link"
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
        <form action="{{ url('/bgv_editpost/'.$model->id) }}" method="POST">
            {{ csrf_field() }}

            <div class="p-2" style="background-color:#e9ecec;">
                <i class="fa fa-user" aria-hidden="true"></i>&nbsp;
                Background Verification Details
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
                <label for="institute" class="col-sm-3 form-label">BGV Document</label>
                <div class=" col-md-3">
                    <input type="text" name="document_sent" id="document_sent" class="form-control form-control-sm"
                        value="{{$bk->document_sent}}">
                </div>
                <label for="Educational_check" class="col-sm-3 form-label">Education Check</label>
                <div class=" col-md-3">
                    <select class="form-control form-control-sm" id="educational_check" name="educational_check" required>
                    <option value="{{$bk->educational_check}}">{{$bk->educational_check}}</option>
                        <option></option>
                        <option value="Positive">Positive</option>
                        <option value="Negative">Negative</option>
                        <option value="Amber">Amber</option>
                        <option value="Insufficient">Insufficient</option>
                        <option value="Interim">Interim</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="institute" class="col-sm-3 form-label">Employment Check</label>
                <div class=" col-md-3">
                <select class="form-control form-control-sm " id="employment_check" name="employment_check" required>
                <option value="{{$bk->employment_check}}">{{$bk->employment_check}}</option>
                        <option></option>
                        <option value="Positive">Positive</option>
                        <option value="Negative">Negative</option>
                        <option value="Amber">Amber</option>
                        <option value="Insufficient">Insufficient</option>
                        <option value="Interim">Interim</option>
                    </select>
                </div>
                <label for="Educational_check" class="col-sm-3 form-label">Address Check</label>
                <div class=" col-md-3">
                    <select class="form-control form-control-sm " id="address_check" name="address_check" required>
                    <option value="{{$bk->address_check}}">{{$bk->educational_check}}</option>
                        <option></option>
                        <option value="Positive">Positive</option>
                        <option value="Negative">Negative</option>
                        <option value="Amber">Amber</option>
                        <option value="Insufficient">Insufficient</option>
                        <option value="Interim">Interim</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="institute" class="col-sm-3 form-label">Overall Status</label>
                <div class=" col-md-3">
                    <select class="form-control form-control-sm" id="overall_status" name="overall_status" required>
                    <option value="{{$bk->overall_check}}">{{$bk->overall_check}}</option>
                        <option></option>
                        <option value="Positive">Positive</option>
                        <option value="Negative">Negative</option>
                        <option value="Amber">Amber</option>
                        <option value="Insufficient">Insufficient</option>
                        <option value="Interim">Interim</option>
                    </select>
                </div>
                <label for="Report_received" class="col-sm-3 form-label">Report Received</label>
                <div class=" col-md-3">
                    <input type="text" name="report" id="report" class="form-control form-control-sm"
                        value="{{$bk->report}}">
                </div>             
                
            </div>
            

            <div class="form-row">
                <div class="col-md-1"></div>
                <div class="col-md-2">
                    <a class="btn btn-dark" href="{{ url('/personaldetails_edit/' . $model->id)}}"><i
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
    $('#document_sent,#report').datepicker({
        autoclose: true,
        zIndex: 2048,
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
    });
    $("#educational_check,#employment_check,#address_check, #overall_status").select2({
        //  theme: 'classic'
    });

});
</script>
@endpush