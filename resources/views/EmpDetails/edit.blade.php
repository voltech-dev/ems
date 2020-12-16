@extends('layouts.app')

@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">EmpDetails</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Edit</a></li>
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
$empdet = App\Models\EmpDetails::where(['id'=>$model->id])->first();

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
            <form action="{{ route('EmpDetails.update',$model->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <h5><u>Emp Details</u></h5>
                <div class="form-group row">
                <input type="hidden" name="empid" id="empid" class="form-control"
                            value="{{$model->id}}">
                    <label for="emp_code" class="col-sm-2 form-label">Emp Code</label>
                    <div class=" col-md-3">
                        <input type="text" name="emp_code" id="emp_code" class="form-control"
                            value="{{$model->emp_code}}">
                    </div>

                    <label for="emp_name" class="col-sm-2 form-label">Emp Name</label>
                    <div class=" col-md-3">
                        <input type="text" name="emp_name" id="emp_name" class="form-control"
                            value="{{$model->emp_name}}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-sm-2 form-label">Email</label>
                    <div class=" col-md-3">
                        <input type="text" name="email" id="email" class="form-control" value="{{$model->mail}}">
                    </div>

                    <label for="last_name" class="col-sm-2 form-label">Mobile No</label>
                    <div class=" col-md-3">
                        <input type="text" name="mobile" id="mobile" class="form-control" value="{{$model->mobile}}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="first_name" class="col-sm-2 form-label">Project</label>
                    <div class=" col-md-3">
                        <select class="form-control form-control-sm" name="project_id">
                            <option></option>
                            @foreach($projects as $pro)
                            <option value="{{$pro->id}}"
                                {{ old('project_id', $empdet->project_id) == $pro->id ? 'selected' : '' }}>
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
                                {{ old('location_id', $empdet->location_id) == $locat->id ? 'selected' : '' }}>
                                {{ucfirst($locat->location)}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="designation" class="col-sm-2 form-label">Designation</label>
                    <div class=" col-md-3">
                        <input type="text" name="designation" id="designation" class="form-control"
                            value="{{$model->designation_id}}">
                    </div>

                    <label for="doj" class="col-sm-2 form-label">Date Of Joining</label>
                    <div class=" col-md-3">
                        <input type="text" name="doj" id="doj" class="form-control" value="{{$model->date_of_joining}}">
                    </div>
                </div>

                <div class="form-group row">


                    <label for="dol" class="col-sm-2 form-label">Date Of Leaving</label>
                    <div class=" col-md-3">
                        <input type="text" name="dol" id="dol" class="form-control" value="{{$model->date_of_leaving}}">
                    </div>

                    <label for="lad" class="col-sm-2 form-label">Last Appraisal Date</label>
                    <div class=" col-md-3">
                        <input type="text" name="lad" id="lad" class="form-control"
                            value="{{$model->last_appraisal_date}}">
                    </div>
                </div>

                <div class="form-group row">


                    <label for="authority_id" class="col-sm-2 form-label"> Reporting Authority</label>
                    <div class=" col-md-3">
                        <select class="form-control form-control-sm" name="authority_id">
                            <option></option>
                            @foreach($auth as $authority)
                            <option value="{{$locat->id}}"
                                {{ old('authority_id', $empdet->reporting_authority_id) == $authority->id ? 'selected' : '' }}>
                                {{ucfirst($authority->authority_name)}}</option>
                            @endforeach
                        </select>
                    </div>

                    <label for="status_id" class="col-sm-2 form-label"> Status</label>
                    <div class=" col-md-3">
                        <select class="form-control form-control-sm" name="status_id">
                            <option></option>
                            @foreach($status as $sta)
                            <option value="{{$sta->id}}"
                                {{ old('location_id', $empdet->status_id) == $sta->id ? 'selected' : '' }}>
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
                        <a class="btn btn-dark" href="{{ url('/EmpDetails') }}"><i
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