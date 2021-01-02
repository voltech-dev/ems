@extends('layouts.app')

@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
<div class="page-leftheader">
    <ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Dashboard</a></li>
	    <li class="breadcrumb-item"><a href="#">EmpDetails</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Create</a></li>
    </ol>
</div>
<br/>
   <!-- <div class="col">
        <span class="page-title">Applicant</span> &#187; Create
    </div>-->
</div>
@endsection
<?php
$projects = App\Models\ProjectDetails::all();
$location = App\Models\Locations::all();
$status =  App\Models\Statuses::all();
$auth =  App\Models\Authorities::all();

error_reporting(0);

?>

@section('content')



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
            <div class="container">
    <div class="card bg-light mt-3">
        <div class="card-header">
            Laravel 8 Import Export Excel to database Example - ItSolutionStuff.com
        </div>
        <div class="card-body">
            <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" class="form-control">
                <br>
                <button class="btn btn-success">Import User Data</button>
                <a class="btn btn-warning" href="{{ route('export') }}">Export User Data</a>
            </form>
        </div>
    </div>
</div>
        </div>
    </div>
</div>
</div>
@endsection
@push('scripts')
<script>
$(function() {
    $('#doj,#dol,#lad').datepicker({
        autoclose: true,
        zIndex: 2048,
        dateFormat: 'dd/mm/yy',
        changeMonth:true,
        changeYear:true,
    });
    

});
</script>
@endpush