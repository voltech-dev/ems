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
        <li class="nav-item active" style="background:#fff;border:1px ">
            <a style="width:100px;color:#367fa9;text-align:center" class=""
                href="{{  url('/personaldetails_edit/' . $model->id)}}"><b>Personal</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:80px;color:white;text-align:center" class="nav-link"
                href="{{ url('/bgv_edit/' . $model->id)}}"><b>BGV</b></a>
        </li>
        <!-- <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:100px;color:white;text-align:center" class="nav-link"
                href="{{ url('/grievance_edit/' . $model->id)}}"><b>Grievance</b></a>
        </li> -->
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
        <form action="{{ url('/personaldetails_editstore/'.$model->id) }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="empid" id="empid" class="form-control" value="{{$model->id}}">
            <div class="p-2" style="background-color:#e9ecec;">
                <i class="fa fa-user" aria-hidden="true"></i>&nbsp;
                Employee Personal Details
            </div>

            <div class="form-group">
                <table class="table table-bordered text-nowrap" id="example1">
                    <thead>
                        <tr>
                            <th class="wd-15p border-bottom-0">S.No</th>
                            <th class="wd-15p border-bottom-0">Name</th>
                            <th class="wd-20p border-bottom-0">Relationship</th>
                            <th class="wd-15p border-bottom-0">Date of Birth</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td> <input type="text" name="name1" id="name" class="form-control form-control-sm" value="{{$personal->name_1}}"></td>
                            <td>
                                <select class="form-control form-control-sm " name="relation1" required>
                                <option value="{{$personal->relationship_1}}" selected>{{$personal->relationship_1}}</option>
                                    <option disabled>select any one</option>
                                    <option value="Spouse"> Spouse</option>
                                    <option value="Son">Son</option>
                                    <option value="Daughter">Daughter </option>
                                </select>
                            </td>
                            <td><input type="text" name="dob1" id="dob1" class="form-control form-control-sm" value="{{$personal->dob_1}}"></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td> <input type="text" name="name2" id="name" class="form-control form-control-sm" value="{{$personal->name_2}}"></td>
                            <td>
                                <select class="form-control form-control-sm " name="relation2" required>
                                <option value="{{$personal->relationship_2}}" selected>{{$personal->relationship_2}}</option>
                                <option disabled>select any one</option>
                                    <option value="Spouse"> Spouse</option>
                                    <option value="Son">Son</option>
                                    <option value="Daughter">Daughter </option>
                                </select>
                            </td>
                            <td><input type="text" name="dob2" id="dob2" class="form-control form-control-sm" value="{{$personal->dob_2}}"></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td> <input type="text" name="name3" id="name" class="form-control form-control-sm" value="{{$personal->name_3}}"></td>
                            <td>
                                <select class="form-control form-control-sm " name="relation3" required>
                                <option value="{{$personal->relationship_3}}" selected>{{$personal->relationship_3}}</option>
                                <option disabled>select any one</option>
                                    <option value="Spouse"> Spouse</option>
                                    <option value="Son">Son</option>
                                    <option value="Daughter">Daughter </option>
                                </select>
                            </td>
                            <td><input type="text" name="dob3" id="dob3" class="form-control form-control-sm" value="{{$personal->dob_3}}"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="form-row">
                <div class="col-md-1"></div>
                <div class="col-md-2">
                    <a class="btn btn-dark" href="{{ url('/empfileedit/'.$model->id) }}"><i
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
    $('#doj,#dol,#lad,#dob1,#dob2,#dob3,#appraisal_due_date,#date_of_offer,#offer_accepted').datepicker({
        autoclose: true,
        zIndex: 2048,
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
    });
    $("#designation,#location,#project").select2({
        //  theme: 'classic'
    });

});
</script>
@endpush