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
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Document View</a></li>
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

<div class="ml-6 mr-6">
@if ($message = Session::get('info'))

<div class="alert alert-info alert-block">

    <button type="button" class="close" data-dismiss="alert">×</button>    

    <strong>{{ $message }}</strong>

</div>

@endif
@if ($errors->any())

<div class="alert alert-danger">

    <button type="button" class="close" data-dismiss="alert">×</button>    

    Please check the Mail ID below for errors

</div>

@endif
    <div class="mt-1  text-gray-600 dark:text-gray-400 text-sm">
        <?php
                $file_upload = App\Models\Documents::where('empid',$model->id)->get();               
                 ?>
        <div class="form-row">
            <table class="table table-striped table-hover">
                <tr>
                    <th>SI</th>
                    <th>Document Name</th>
                    <th>Document type</th>
                    <th></th>
                    <th>Status</th>
                </tr>
                @foreach($file_upload as $file)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td><a href="../../storage/app/public/employee/<?php if($file->document_dummy_name==''){
                    echo $file->document_name;
                    }else{
                        echo $file->document_dummy_name;
                    }
                    ?>"
                            target="_blank">{{$file->document_name}}</a></td>
                    <td>{{$file->document_type}}</td>
                    <td>
                        <?php 
                        $filedocument = App\Models\Documents::where('empid',$model->id)->Where('document_type','like','%'."offer letter".'%')->get();               
                        ?>
                        @if($file->document_type != "Offer Letter")
                        <!-- <i class="glyphicon glyphicon-chevron-left"></i> -->
                        @else
                        <a href="{{ url('/sendmail/'.$model->id.'/'.$model->email_personal) }}"><i class="glyphicon glyphicon-envelope"></i></a>
                        @endif
                    </td>
                    <td> @if($file->document_type != "Offer Letter" && $file->status != 1)
                        <!-- <i class="glyphicon glyphicon-chevron-left"></i> -->
                        @else
                        <i>Offer Letter sent to your Registered mail Address</i>
                        @endif</td>
                    <!-- <td>
                            <span class="dropdown">
                                <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                </a>
                                <span class="dropdown-menu dropdown-menu-right">
                                    <a href="{{url('/file_download/'.$file->id.'/'.$model->id)}}"
                                        class="dropdown-item">Download</a>
                                    <a href="{{url('/file_delete/'.$file->id.'/'.$model->id)}}"
                                        class="dropdown-item">Delete</a>
                                </span>
                            </span>
                        </td> -->

                </tr>
                @endforeach
            </table>
        </div>
        <hr>
        <br>

        <div class="form-row">
            <div class="col-md-1"></div>
            <div class="col-md-2">
                <a class="btn btn-dark" href="{{ url('/empview/'.$model->id) }}"><i
                        class="glyphicon glyphicon-chevron-left"></i> Back</a>
            </div>
        </div>

    </div>
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