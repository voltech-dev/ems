@extends('layouts.app')

@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Payroll</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">salary Upload</a></li>
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
        <form action="{{ url('/ImportEmployee') }}" method="POST" role="form" enctype="multipart/form-data">
            @csrf

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

</script>
@endpush