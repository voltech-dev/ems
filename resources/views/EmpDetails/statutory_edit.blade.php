@extends('layouts.app')

@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Statutory Details</a></li>
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
$statu =  App\Models\EmpStatutorydetails::where(['empid'=>$model->id])->first();

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
            <a style="width:180px;color:white;text-align:center" class="nav-link"
                href="{{ route('empdetails.edit',$model->id)}}"><b>Employee </b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:180px;color:white;text-align:center" class="nav-link"
                href="{{ url('/remunerationedit/' . $model->id)}}"><b>Remuneration</b></a>
        </li>
        <li class="nav-item " style="background: #ffffff;border:1px ">
            <a style="width:180px;color:#367fa9;text-align:center" class="nav-link"
                href="{{ url('/statutoryedit/' . $model->id)}}"><b>Statutory</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:100px;color:white;text-align:center" class="nav-link"
                href="{{ url('/bankedit/' . $model->id)}}"><b>Bank</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:180px;color:white;text-align:center" class="nav-link"
                href="#"><b>Education</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:180px;color:white;text-align:center" class="nav-link"
                href="#"><b>Cerificate</b></a>
        </li>
    </ul>
</div>
<br>
<div class="card">
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
                <form action="{{ url('/statutoryeditstore') }}" method="POST">
                    {{ csrf_field() }}


                    <div class="card-header" style="background-color:#BBDEFB;color: #000;font-size: 13px;">
                        <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;
                        Statutory Details
                    </div>
                    <br>
                    <div class="card-body">
                        <div class="form-group row">
                            <input type="hidden" name="empid" id="empid" class="form-control" value="{{$model->id}}">
                            <label for="esino" class="col-sm-2 form-label">ESI No</label>
                            <div class=" col-md-3">
                                <input type="text" name="esino" id="esino" class="form-control"
                                    value="{{$statu->esino}}">
                            </div>

                            <label for="esidispensary" class="col-sm-2 form-label">ESI Dispensary</label>
                            <div class=" col-md-3">
                                <input type="text" name="esidispensary" id="esidispensary" class="form-control"
                                    value="{{$statu->esidispensary}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="epfno" class="col-sm-2 form-label">EPF No</label>
                            <div class=" col-md-3">
                                <input type="text" name="epfno" id="epfno" class="form-control"
                                    value="{{$statu->epfno}}">
                            </div>

                            <label for="epfuanno" class="col-sm-2 form-label">EPF UAN No</label>
                            <div class=" col-md-3">
                                <input type="text" name="epfuanno" id="epfuanno" class="form-control"
                                    value="{{$statu->epfuanno}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="professionaltax" class="col-sm-2 form-label">Professional Tax</label>
                            <div class=" col-md-3">
                                <select class="form-control form-control-sm" name="professionaltax">
                                    <option></option>
                                    <option value="Yes" {{$statu->professionaltax== Yes ?'selected':''}}> Yes</option>
                                    <option value="No" {{$statu->professionaltax== No ?'selected':''}}> No</option>
                                </select>
                            </div>
                            <label for="gpano" class="col-sm-2 form-label">GPA</label>
                            <div class=" col-md-3">
                                <input type="text" name="gpano" id="gpano" class="form-control" value="{{$statu->gpa}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="professionaltax" class="col-sm-2 form-label">GMC No</label>
                            <div class=" col-md-3">
                                <input type="text" name="gmcno" id="gmcno" class="form-control" value="{{$statu->gmc}}">
                            </div>

                            <label for="gmcno" class="col-sm-2 form-label"></label>
                            <div class=" col-md-3">

                            </div>
                        </div>



                        <div class="form-row">

                            <div class="col-md-1"></div>
                            <div class="col-md-2">
                                <a class="btn btn-dark" href="{{ url('/empdetails/remunerationedit/'.$model->id) }}"><i
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