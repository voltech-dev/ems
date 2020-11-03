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

error_reporting(0);

?>

@section('content')


<!--<div class="max-w-6xl mx-auto sm:px-6 lg:px-8">-->
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
    <div class="p-6">
        <div class="ml-1">
            <div class="mt-1 text-gray-600 dark:text-gray-400 text-sm">
                <form action="{{ route('EmpDetails.store') }}" method="POST">
                    {{ csrf_field() }}

                    <h5><u>Basic Information</u></h5>
                    <div class="form-group row">
                        <label for="first_name" class="col-sm-2 form-label">Emp Code</label>
                        <div class=" col-md-3">
                            <input type="text" name="first_name" id="first_name" class="form-control" value="">
                        </div>
                    
                        <label for="last_name" class="col-sm-2 form-label">Emp Name</label>
                        <div class=" col-md-3">
                            <input type="text" name="last_name" id="last_name" class="form-control" value="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-sm-2 form-label">Email</label>
                        <div class=" col-md-3">
                            <input type="text" name="email" id="email" class="form-control" value="">
                        </div>
                    
                        <label for="last_name" class="col-sm-2 form-label">Email</label>
                        <div class=" col-md-3">
                            <input type="text" name="last_name" id="last_name" class="form-control" value="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="first_name" class="col-sm-2 form-label">Project</label>
                        <div class=" col-md-3">
                        <select class="form-control form-control-sm" name="project_id">
                        <option></option>
                        @foreach($projects as $pro)
                        <option value="{{$pro->id}}"
                            {{ old('project_id', $pro->project_name) == $pro->id ? 'selected' : '' }}>
                            {{ucfirst($pro->project_name)}}</option>
                        @endforeach
                    </select>
                        </div>
                    
                        <label for="last_name" class="col-sm-2 form-label">Location</label>
                        <div class=" col-md-3">
                        <select class="form-control form-control-sm" name="location_id">
                        <option></option>
                        @foreach($location as $locat)
                        <option value="{{$locat->id}}"
                            {{ old('location_id', $locat->location) == $locat->id ? 'selected' : '' }}>
                            {{ucfirst($locat->location)}}</option>
                        @endforeach
                    </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="first_name" class="col-sm-2 form-label">Designation</label>
                        <div class=" col-md-3">
                            <input type="text" name="first_name" id="first_name" class="form-control" value="">
                        </div>
                    
                        <label for="first_name" class="col-sm-2 form-label">Date Of Joining</label>
                        <div class=" col-md-3">
                            <input type="text" name="first_name" id="first_name" class="form-control" value="">
                        </div>
                    </div>

                    <div class="form-group row">
                      
                    
                        <label for="last_name" class="col-sm-2 form-label">Date Of Leaving</label>
                        <div class=" col-md-3">
                            <input type="text" name="last_name" id="last_name" class="form-control" value="">
                        </div>

                        <label for="first_name" class="col-sm-2 form-label">Last Appraisal Date</label>
                        <div class=" col-md-3">
                            <input type="text" name="first_name" id="first_name" class="form-control" value="">
                        </div>
                    </div>

                    <div class="form-group row">
                        
                    
                        <label for="last_name" class="col-sm-2 form-label">	Reporting Authority</label>
                        <div class=" col-md-3">
                            <input type="text" name="last_name" id="last_name" class="form-control" value="">
                        </div>

                        <label for="last_name" class="col-sm-2 form-label">	Status</label>
                        <div class=" col-md-3">
                        <select class="form-control form-control-sm" name="location_id">
                        <option></option>
                        @foreach($status as $sta)
                        <option value="{{$sta->id}}"
                            {{ old('location_id', $sta->status) == $sta->id ? 'selected' : '' }}>
                            {{ucfirst($sta->status)}}</option>
                        @endforeach
                    </select>
                        </div>

                    </div>
                    
                   

                    <div class="form-row">
                        <div class="col-md-1"></div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-plus"></i> Next
                            </button>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-2">
                            <a class="btn btn-dark" href="{{ url('/applicants') }}"><i
                                    class="glyphicon glyphicon-chevron-left"></i> Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection