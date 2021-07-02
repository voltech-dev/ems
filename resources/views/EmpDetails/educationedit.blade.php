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
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Education Details</a></li>
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
$education =  App\Models\Educations::where(['empid'=>$model->id])->first();
$qualification = App\Models\Qualifications::all();

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
        <li class="nav-item " style="background: #ffffff;border:1px ">
            <a style="width:100px;color:#367fa9;text-align:center" class="nav-link"
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
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:100px;color:white;text-align:center" class="nav-link"
                href="{{ url('/personaldetails_edit/' . $model->id)}}"><b>Personal</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:80px;color:white;text-align:center" class="nav-link"
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
<br>

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
            <form action="{{ url('/educationeditstore') }}" method="POST">
                {{ csrf_field() }}

                <div class="card-header" style="background-color:#BBDEFB;color: #000;font-size: 13px;">
                    <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;
                    Education Details
                </div>
                <br>
                <div class="card-body">
                    <div class="form-group row">
                        <input type="hidden" name="empid" id="empid" class="form-control" value="{{$model->id}}">
                        <label for="bankname" class="col-sm-2 form-label">Qualification</label>
                            <div class=" col-md-3">
                            <select class="form-control form-control-sm" name="qualification"
                                    id="qualification">
                                    <option></option>
                                    @foreach($qualification as $quali)
                                    <option value="{{$quali->id}}"
                                        {{ old('qualification', $education->qualification) == $quali->id ? 'selected' : '' }}>
                                        {{ucfirst($quali->qualification_name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="yop" class="col-sm-2 form-label">Year of Passing</label>
                            <div class=" col-md-3">
                                <input type="text" name="yop" id="yop" class="form-control" value="{{$education->year_of_passing}}">
                            </div>

                            
                        </div>

                        <div class="form-group row">
                            <label for="institute" class="col-sm-2 form-label">College/University</label>
                            <div class=" col-md-3">
                                <input type="text" name="institute" id="institute" class="form-control" value="{{$education->institute}}">
                            </div>

                            <label for="Board" class="col-sm-2 form-label">Additional Certificates</label>
                            <div class=" col-md-3">
                                <input type="text" name="board" id="board" class="form-control" value="{{$education->board}}">
                            </div>
                        </div>


                    <div class="form-row">

                        <div class="col-md-1"></div>
                        <div class="col-md-2">
                            <a class="btn btn-dark" href="{{ url('/bankedit/'.$model->id)  }}"><i
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