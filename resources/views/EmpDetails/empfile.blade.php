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
        <li class="nav-item active " style="background: #ffffff;border:1px ">
            <a style="width:150px;color:#367fa9;text-align:center" class=""
                href="{{ route('empdetails.create')}}"><b>Employee </b></a>
        </li>

        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:150px;color:white;text-align:center" class="nav-link" href="#"><b>Remuneration</b></a>
        </li>

        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:150px;color:white;text-align:center" class="nav-link" href="#"><b>Statutory</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:100px;color:white;text-align:center" class="nav-link" href="#"><b>Bank</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:150px;color:white;text-align:center" class="nav-link" href="#"><b>Education</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:150px;color:white;text-align:center" class="nav-link" href="#"><b>Certificate</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:150px;color:white;text-align:center" class="nav-link" href="#"><b>Documents</b></a>
        </li>
    </ul>
</div>
<br>
<br>
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
        <?php
                $file_upload = App\Models\Documents::where('empid',$model->id)->get();
                $si=1;
                 ?>
        <div class="form-row">
            <table class="table table-striped table-hover">
                <tr>
                    <th>SI</th>
                    <th>Document Name</th>
                    <th>Document type</th>
                </tr>
                @foreach($file_upload as $file)
                <tr>
                    <td>{{$si++}}</td>
                    <td>{{$file->document_name}}</td>
                    <td>{{$file->document_type}}</td>
                    

                </tr>
                @endforeach
            </table>
        </div>
        <hr>
        <br>
        <form action="{{url('/empfilestore')}}" method="POST" role="form" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <input type="hidden" name="empid" id="empid" class="form-control" value="{{$model->id}}">
                <div class="form-group col-md-3">
                    <label for="document" class="form-label">Document Type</label>

                    <select name="document_type" id="document_type" class="form-control form-control-sm">
                        <option></option>
                        <option value="bank">Bank</option>
                        <option value="education">Education</option>
                        <option value="documents">Documents</option>
                        <option value="others">Others</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="empfile" class="form-label">File Upload</label>
                    <input id="file_upload" type="file" name="file_upload" class="form-control dropify"
                        data-height="180">
                    <!-- <input type="file" class="dropify" data-height="180" /> -->
                </div>
                <div class="form-group col-md-3">
                    <label for="empfile"></label>
                    <div class="col-md-8 offset-md-1" style="padding-top: 81px;">
                        <button type="submit" class="btn btn-primary">Upload File</button>
                    </div>
                </div>

            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <a class="btn btn-dark" href="{{ url('/certificateedit/'.$model->id) }}"><i
                            class="glyphicon glyphicon-chevron-left"></i> Back</a>
                </div>
            </div>

        </form>

    </div>




    @endsection
    @push('scripts')
    <script>
    $(function() {
        $('#doj,#dol,#lad,#dob,#appraisal_due_date').datepicker({
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