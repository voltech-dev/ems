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
$doc =  App\Models\Doc_type::all();

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
        <li class="nav-item " style="background: #ffffff;border:1px ">
            <a style="width:100px;color:#367fa9;text-align:center" class="nav-link"
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
                    <th>Action</th>
                </tr>
                @foreach($file_upload as $file)
                <tr>
                    <td>{{$si++}}</td>
                    <td><a href="../../storage/app/public/employee/{{$file->document_name}}"
                            target="_blank">{{$file->document_name}}</a></td>
                    <td>{{$file->document_type}}</td>
                    <td>
                    <span class="dropdown">
                                                <a href="#" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </a>
                                                <span class="dropdown-menu dropdown-menu-right">
                                                <a href="{{url('/file_download/'.$file->id.'/'.$model->id)}}"
                                                        class="dropdown-item">Download</a>
                                                    <a href="{{url('/file_delete/'.$file->id.'/'.$model->id)}}"
                                                        class="dropdown-item">Delete</a>
                                                </span>
                                            </span>
                    </td>

                </tr>
                @endforeach
            </table>
        </div>
        <hr>
        <br>
        <form action="{{url('/empfileeditstore')}}" method="POST" role="form" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <input type="hidden" name="empid" id="empid" class="form-control" value="{{$model->id}}">
                <div class="form-group col-md-3">
                    <label for="document" class="form-label">Document Type</label>

                    <select name="document_type" id="document_type" class="form-control form-control-sm">
                       <option></option>
                          @foreach($doc as $doc)
                                    <option value="{{$doc->doc_type_name}}"
                                        {{ old('salary_structure', $doc->doc_type_name) == $doc->doc_type_name ? 'selected' : '' }}>
                                        {{ucfirst($doc->doc_type_name)}}</option>
                                    @endforeach  
                        <!--<option value="bank">Bank</option>
                        <option value="education">Education</option>
                        <option value="documents">Documents</option>
                        <option value="others">Others</option> -->
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