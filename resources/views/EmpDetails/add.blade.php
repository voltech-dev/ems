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
            <a style="width:150px;color:white;text-align:center" class="nav-link" href="#"><b>Cerificate</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:150px;color:white;text-align:center" class="nav-link" href="#"><b>Documents</b></a>
        </li>
    </ul>
</div>

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
        <form action="{{ route('empdetails.store') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="p-2" style="background-color:#e9ecec;">
                <i class="fa fa-user" aria-hidden="true"></i>&nbsp;
                Employee Details
            </div>


            <div class="form-group row mt-5">
                <label for="emp_code" class="col-sm-2 form-label">Emp Code</label>
                <div class=" col-md-3">
                    <input type="text" name="emp_code" id="emp_code" class="form-control form-control-sm" value="">
                </div>

                <label for="emp_name" class="col-sm-2 form-label">Emp Name</label>
                <div class=" col-md-3">
                    <input type="text" name="emp_name" id="emp_name" class="form-control form-control-sm" value="">
                </div>
            </div>

            <div class="form-group row">
                <label for="gender" class="col-sm-2 form-label">Gender</label>
                <div class=" col-md-3">
                    <select class="form-control form-control-sm " name="gender">
                        <option></option>
                        <option value="male"> Male</option>
                        <option value="female">Female</option>
                        <option value="transgender ">Transgender </option>
                    </select>
                </div>

                <label for="email" class="col-sm-2 form-label">Email</label>
                <div class=" col-md-3">
                    <input type="text" name="email" id="email" class="form-control form-control-sm" value="">
                </div>
            </div>

            <div class="form-group row">
                <label for="first_name" class="col-sm-2 form-label">Project</label>
                <div class=" col-md-3">
                    <select class="form-control form-control-sm" name="project_id" id="project">
                        <option></option>
                        @foreach($projects as $pro)
                        <option value="{{$pro->id}}"
                            {{ old('project_id', $pro->project_name) == $pro->id ? 'selected' : '' }}>
                            {{ucfirst($pro->project_name)}}</option>
                        @endforeach
                    </select>
                </div>

                <label for="last_name" class="col-sm-2 form-label">Mobile No</label>
                <div class=" col-md-3">
                    <input type="text" name="mobile" id="mobile" class="form-control form-control-sm" value="">
                </div>
            </div>
            
            

            <div class="form-group row">
                <label for="last_name" class="col-sm-2 form-label">Location</label>
                <div class=" col-md-3">
                    <select class="form-control form-control-sm " name="location_id" id="location">
                        <option></option>
                        @foreach($location as $locat)
                        <option value="{{$locat->id}}"
                            {{ old('location_id', $locat->location) == $locat->id ? 'selected' : '' }}>
                            {{ucfirst($locat->location)}}</option>
                        @endforeach
                    </select>
                </div>
                <label for="designation" class="col-sm-2 form-label">Designation</label>
                <div class=" col-md-3">

                    <select class="form-control form-control-sm" name="designation" id="designation">
                        <option></option>
                        @foreach($designation as $desig)
                        <option value="{{$desig->id}}"
                            {{ old('designation', $desig->designation_id) == $desig->id ? 'selected' : '' }}>
                            {{ucfirst($desig->designation_name)}}</option>
                        @endforeach
                    </select>

                </div>
            </div>

            <div class="form-group row">
                <label for="office_location" class="col-sm-2 form-label">Office Location</label>
                <div class=" col-md-3">
                <input type="text" name="office_location" id="office_location" class="form-control form-control-sm" value="">
                </div>
                <label for="dol" class="col-sm-2 form-label">Date Of Joining</label>
                <div class=" col-md-3">
                    <input type="text" name="doj" id="doj" class="form-control form-control-sm" value="">
                </div>
            </div>


            <div class="form-group row">
              
                <label for="doj" class="col-sm-2 form-label">Date Of birth</label>
                <div class=" col-md-3">
                    <input type="text" name="dob" id="dob" class="form-control form-control-sm" value="">
                </div>
                <label for="blood" class="col-sm-2 form-label"> Blood Group</label>
                <div class=" col-md-3">
                    <input type="text" name="blood" id="blood" class="form-control form-control-sm" value="">
                </div>
            </div>

            <div class="form-group row">
                <label for="doj" class="col-sm-2 form-label">Last Appraisal Date</label>
                <div class=" col-md-3">
                    <input type="text" name="lad" id="lad" class="form-control form-control-sm" value="">
                </div>
                <label for="lad" class="col-sm-2 form-label">Appraisal Due Date</label>
                <div class=" col-md-3">
                    <input type="text" name="appraisal_due_date" id="appraisal_due_date"
                        class="form-control form-control-sm" value="">
                </div>

            </div>

            <div class="form-group row">
                <label for="lad" class="col-sm-2 form-label">Date Of Leaving</label>
                <div class=" col-md-3">
                    <input type="text" name="dol" id="dol" class="form-control form-control-sm" value="">
                </div>
            </div>

            <div class="p-2" style="background-color:#e9ecec;">
                <i class="fa fa-user" aria-hidden="true"></i>&nbsp;
                Employee Address
            </div>

            <div class="form-group row mt-4">
                <label for="address_1" class="col-sm-2 form-label">Res.No</label>
                <div class=" col-md-3">
                    <input type="text" name="address_1" id="address_1" class="form-control form-control-sm" value="">
                </div>

                <label for="address_2" class="col-sm-2 form-label">Res.Name</label>
                <div class=" col-md-3">
                    <input type="text" name="address_2" id="address_2" class="form-control form-control-sm" value="">
                </div>
            </div>
            <div class="form-group row">


                <label for="address_3" class="col-sm-2 form-label">Road/Street</label>
                <div class=" col-md-3">
                    <input type="text" name="address_3" id="address_3" class="form-control form-control-sm" value="">
                </div>

                <label for="address_4" class="col-sm-2 form-label">Locality/Area</label>
                <div class=" col-md-3">
                    <input type="text" name="address_4" id="address_4" class="form-control form-control-sm" value="">
                </div>
            </div>
            <div class="form-group row">


                <label for="address_5" class="col-sm-2 form-label">City</label>
                <div class=" col-md-3">
                    <input type="text" name="address_5" id="address_5" class="form-control form-control-sm" value="">
                </div>

                <label for="address_6" class="col-sm-2 form-label">District</label>
                <div class=" col-md-3">
                    <input type="text" name="address_6" id="address_6" class="form-control form-control-sm" value="">
                </div>
            </div>
            <div class="form-group row">

                <label for="address_7" class="col-sm-2 form-label">State</label>
                <div class=" col-md-3">
                    <input type="text" name="address_7" id="address_7" class="form-control form-control-sm" value="">
                </div>

                <label for="address_8" class="col-sm-2 form-label">Pincode</label>
                <div class=" col-md-3">
                    <input type="text" name="address_8" id="address_8" class="form-control form-control-sm" value="">
                </div>
            </div>
            <div class="form-group row">
                <label for="status_id" class="col-sm-2 form-label"> Status</label>
                <div class=" col-md-3">
                    <select class="form-control form-control-sm" name="status_id">
                        <option></option>
                        @foreach($status as $sta)
                        <option value="{{$sta->id}}"
                            {{ old('location_id', $sta->status) == $sta->id ? 'selected' : '' }}>
                            {{ucfirst($sta->status)}}</option>
                        @endforeach
                    </select>
                </div>
                <label for="status_id" class="col-sm-2 form-label"> </label>
                <div class="col-md-2 imgage-box">
                    <img id="blah" alt="your image" width="130" height="150" />
                    <input type="file" name="file_upload"
                        onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                </div>
            </div>


            <div class="form-row">
                <div class="col-md-1"></div>
                <div class="col-md-2">
                    <a class="btn btn-dark" href="{{ url('/empdetails') }}"><i
                            class="glyphicon glyphicon-chevron-left"></i> Back</a>
                </div>

                <div class="col-md-1"></div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-plus"></i> Next
                    </button>
                </div>
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