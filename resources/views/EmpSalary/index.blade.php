@extends('layouts.app')

@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Payroll</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Salary Index</a></li>
        </ol>
    </div>
</div>
@endsection
<?php
error_reporting(0);
$projects = App\Models\ProjectDetails::all();
?>
@section('content')
<div class="ml-1">
    <div class="mt-1 text-gray-600 dark:text-gray-400 text-sm ">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
       
        @endif
        <form action="{{ url('/importtemplate') }}" method="POST" role="form" enctype="multipart/form-data">
            @csrf
            <div class="form-row p-2">
                <label for="sal_month" class="col-sm-3 form-label">Month</label>
                <div class=" col-md-4">
                    <input type="text" name="sal_month" id="sal_month" class="form-control" value="">
                </div>
            </div>

            <div class="form-row p-2">
                <label for="sal_month" class="col-sm-3 form-label">Project</label>
                <div class="col-md-4">
                    <select class="form-control" name="project" id="project">
                        <option value="All">All</option>
                        @foreach($projects->all() as $pro)
                        <option value="{{$pro->id}}"> {{$pro->project_name}} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 offset-md-1">
                    <button type="button" class="btn btn-danger" id="download">
                        Template download
                    </button>
                </div>
            </div>

            <div class="form-row p-2">
                <label for="profile_image" class="form-label col-md-3">File Upload</label>
                <div class="form-group col-md-4">
                    <input id="file_upload" type="file" name="file_upload" class="form-control dropify"
                        data-height="100">
                </div>
                <div class="col-md-2 offset-md-1">
                    <button type="submit" class="btn btn-info">Upload File</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
@push('scripts')
<script>
$('#sal_month').datepicker({
    autoclose: true,
    zIndex: 2048,
    dateFormat: 'mm-yy',
});
$('#project').select2();

$('#download').click(function() {
    var mon = $('#sal_month').val();
    var pro = $('#project').val();
    window.open("downloadtemplate?project=" + pro + "&month=" + mon);
});
</script>
@endpush