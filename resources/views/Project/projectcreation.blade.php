@extends('layouts.app')

@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
<div class="page-leftheader">
    <ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Dashboard</a></li>
	    <li class="breadcrumb-item"><a href="#">Project</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Create</a></li>
    </ol>
</div>
<br/>
   <!-- <div class="col">
        <span class="page-title">Applicant</span> &#187; Create
    </div>-->
</div>
@endsection

@section('content')

<!--<div class="max-w-6xl mx-auto sm:px-6 lg:px-8">-->
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
    <div class="p-6">
        <div class="ml-1">
            <div class="mt-1 text-gray-600 dark:text-gray-400 text-sm">
                <form action="{{ url('/Project/projectstore') }}" method="POST">
                    {{ csrf_field() }}

                    <h5><u>Project Creation</u></h5>
                    <div class="form-group row">
                        <label for="first_name" class="col-sm-2 form-label">Project Name</label>
                        <div class=" col-md-3">
                            <input type="text" name="project_name" id="project_name" class="form-control" value="">
                        </div>
                    
                        <label for="last_name" class="col-sm-2 form-label"></label>
                        <div class=" col-md-3">
                            
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
                            <a class="btn btn-dark" href="{{ url('/Project/projectcreation') }}"><i
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