@extends('layouts.app')

@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Bank Details</a></li>           
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
        <div class="mt-1 text-gray-600 dark:text-gray-400 text-sm">
            <form action="{{ url('/bankstore') }}" method="POST">
                {{ csrf_field() }}

                <h5><u>Bank Details</u></h5>
                <div class="form-group row">
                <input type="hidden" name="empid" id="empid" class="form-control"
                            value="{{$model->id}}">
                    <label for="bankname" class="col-sm-2 form-label">Bank Name</label>
                    <div class=" col-md-3">
                        <input type="text" name="bankname" id="bankname" class="form-control" value="">
                    </div>

                    <label for="acnumber" class="col-sm-2 form-label">AC Number</label>
                    <div class=" col-md-3">
                        <input type="text" name="acnumber" id="acnumber" class="form-control" value="">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="branch" class="col-sm-2 form-label">Branch</label>
                    <div class=" col-md-3">
                        <input type="text" name="branch" id="branch" class="form-control" value="">
                    </div>

                    <label for="ifsc" class="col-sm-2 form-label">IFSC</label>
                    <div class=" col-md-3">
                        <input type="text" name="ifsc" id="	ifsc" class="form-control" value="">
                    </div>
                </div>

               
                <div class="form-row">
                <div class="col-md-1"></div>
                    <div class="col-md-2">
                        <a class="btn btn-dark" href="{{ url('/statutoryedit/'.$model->id) }}"><i
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
    </div>
</div>
</div>
</div>
@endsection