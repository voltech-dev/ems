@extends('layouts.app')
<style>
li a:hover {
    background: #006d6b;
}
</style>
@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Certificate Details</a></li>
            <li class="breadcrumb-item"><a href="#">{{$model->emp_name}}</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Add</a></li>
        </ol>
    </div>
    <br />
    <!-- <div class="col">
        <span class="page-title">Applicant</span> &#187; Create
    </div>-->
</div>
@endsection
<?php
$qualification = App\Models\Qualifications::all();
$auth =  App\Models\Authorities::all();

$certificate = App\Models\Certificates::where(['empid'=>$model->id])->first();

error_reporting(0);

?>

@section('content')

<div class="row col" style="margin-left: 5px;">
    <ul class="nav">
        <li class="nav-item" style="background-color:#00a09d;border:1px solid white">
            <a style="width:80px;color:white;text-align:center" class="nav-link"
                href="{{ route('empdetails.index')}}"><b>List</b></a>
        </li>
        <li class="nav-item" style="background-color:#00a09d;border:1px solid white">
            <a style="width:150px;color:white;text-align:center" class="nav-link"
                href="{{ route('empdetails.edit',$model->id)}}"><b>Employee </b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:150px;color:white;text-align:center" class="nav-link"
                href="{{ url('/remunerationedit/' . $model->id)}}"><b>Remuneration</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:150px;color:white;text-align:center" class="nav-link"
                href="{{ url('/statutoryedit/' . $model->id)}}"><b>Statutory</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:150px;color:white;text-align:center" class="nav-link"
                href="{{ url('/bankedit/' . $model->id)}}"><b>Bank</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:150px;color:white;text-align:center" class="nav-link"
                href="{{ url('/educationedit/' . $model->id)}}"><b>Education</b></a>
        </li>
        <li class="nav-item " style="background: #ffffff;border:1px ">
            <a style="width:100px;color:#367fa9;text-align:center" class="nav-link"
                href="{{ url('/certificateedit/' . $model->id)}}"><b>Certificate</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:150px;color:white;text-align:center" class="nav-link"
                href="{{ url('/empfile/' . $model->id)}}"><b>Document</b></a>
        </li>
    </ul>
</div>
<br>
<div class="p-6">
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
                <form action="{{ url('/certificateeditstore') }}" method="POST">
                    {{ csrf_field() }}

                    <div class="card-header" style="background-color:#BBDEFB;color: #000;font-size: 13px;">
                        <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;
                        Certificate Details
                    </div>
                    <br>
                    <div class="card-body">
                        <div class="form-group row">
                        <input type="hidden" name="empid" id="empid" class="form-control" value="{{$model->id}}">
                            <label for="certificate_name" class="col-sm-2 form-label">Certificate Name</label>
                            <div class=" col-md-3">
                                <input type="text" name="certificate_name" id="certificate_name" class="form-control" value="{{$certificate->certificate_name}}">
                            </div>

                            <label for="certificate_no" class="col-sm-2 form-label">Certificate No</label>
                            <div class=" col-md-3">
                                <input type="text" name="certificate_no" id="certificate_no" class="form-control" value="{{$certificate->certificate_no}}">
                            </div>
                        </div>

                        <div class="form-group row">
                      
                            <label for="issue_authority" class="col-sm-2 form-label">Issue Authority</label>
                            <div class=" col-md-3">
                                <input type="text" name="issue_authority" id="issue_authority" class="form-control" value="{{$certificate->issue_authority}}">
                            </div>

                            <label for="certificate_no" class="col-sm-2 form-label"></label>
                            <div class=" col-md-3">
                                
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="col-md-1"></div>
                            <div class="col-md-2">
                                <a class="btn btn-dark" href="{{ url('/educationedit/'.$model->id) }}"><i
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
        </div>
    </div>


@endsection