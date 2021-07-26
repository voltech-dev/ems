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
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>EmpDetails</a></li>
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
//$empdet = App\Models\EmpDetails::where(['id'=>$model->id])->first();
$designation = App\Models\Designation::all();
$depts = App\Models\Departments::all();
error_reporting(0);

?>

@section('content')



<div class="row col" style="margin-left: 5px;">
    <ul class="nav">
        <li class="nav-item" style="background-color:#00a09d;border:1px solid white">
            <a style="width:80px;color:white;text-align:center" class="nav-link"
                href="{{ route('empdetails.index')}}"><b>List</b></a>
        </li>
        <li class="nav-item active " style="background: #ffffff;border:1px ">
            <a style="width:120px;color:#367fa9;text-align:center" class=""
                href="{{ route('empdetails.edit',$model->id)}}"><b>Employee </b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:150px;color:white;text-align:center" class="nav-link"
                href="{{ url('/remunerationedit/'.$model->id)}}"><b>Remuneration</b></a>
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
            <a style="width:150px;color:white;text-align:center" class="nav-link"
                href="{{ url('/certificateedit/' . $model->id)}}"><b>Certificate</b></a>
        </li> -->
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:100px;color:white;text-align:center" class="nav-link"
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
<div class="card">
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
            <form action="{{ route('empdetails.update',$model->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="card-header" style="background-color:#BBDEFB;color: #000;font-size: 16px;">
                    <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;
                    Employee Details
                </div>
                <br>
                <div class="card-body">
                    <div class="form-group row">
                        <input type="hidden" name="empid" id="empid" class="form-control" value="{{$model->id}}">
                        <label for="emp_code" class="col-sm-2 form-label">Emp Code <span
                                style="color:red">*</span></label>
                        <div class=" col-md-3">
                            <input type="text" name="emp_code" id="emp_code" class="form-control form-control-sm"
                                value="{{$model->emp_code}}" required>
                        </div>

                        <label for="emp_name" class="col-sm-2 form-label">Emp Name <span
                                style="color:red">*</span></label>
                        <div class=" col-md-3">
                            <input type="text" name="emp_name" id="emp_name" class="form-control form-control-sm"
                                value="{{$model->emp_name}}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="gender" class="col-sm-2 form-label">Gender <span style="color:red">*</span></label>
                        <div class=" col-md-3">
                            <select class="form-control form-control-sm" name="gender" required>
                                <option></option>
                                <option value="Male" {{$model->gender== Male ?'selected':''}}> Male</option>
                                <option value="Female" {{$model->gender== Female ?'selected':''}}>Female</option>
                                <option value="Transgender" {{$model->gender== Transgender ?'selected':''}}>Transgender
                                </option>
                            </select>
                        </div>

                        <label for="email" class="col-sm-2 form-label">Email (Official) <span
                                style="color:red">*</span></label>
                        <div class=" col-md-3">
                            <input type="text" name="email" id="email" class="form-control form-control-sm"
                                value="{{$model->mail}}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="mobile" class="col-sm-2 form-label">Mobile No</label>
                        <div class=" col-md-3">
                            <input type="text" name="mobile" id="mobile" class="form-control form-control-sm"
                                value="{{$model->mobile}}">
                        </div>

                        <label for="project_id" class="col-sm-2 form-label">Project <span
                                style="color:red">*</span></label>
                        <div class=" col-md-3">
                            <select class="form-control form-control-sm" name="project_id" id="project" required>
                                <option></option>
                                @foreach($projects as $pro)
                                <option value="{{$pro->id}}"
                                    {{ old('project_id', $model->project_id) == $pro->id ? 'selected' : '' }}>
                                    {{ucfirst($pro->project_name)}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="location_id" class="col-sm-2 form-label">Location <span
                                style="color:red">*</span></label>
                        <div class=" col-md-3">
                            <select class="form-control form-control-sm" name="location_id" id="location" required>
                                <option></option>
                                @foreach($location as $locat)
                                <option value="{{$locat->id}}"
                                    {{ old('location_id', $model->location_id) == $locat->id ? 'selected' : '' }}>
                                    {{ucfirst($locat->location)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="designation" class="col-sm-2 form-label">Designation <span
                                style="color:red">*</span></label>
                        <div class=" col-md-3">

                            <select class="form-control form-control-sm" name="designation" id="designation" required>
                                <option></option>
                                @foreach($designation as $desig)
                                <option value="{{$desig->id}}"
                                    {{ old('designation', $model->designation_id) == $desig->id ? 'selected' : '' }}>
                                    {{ucfirst($desig->designation_name)}}</option>                                    
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="office_location" class="col-sm-2 form-label">Office Location</label>
                        <div class=" col-md-3">
                            <input type="text" name="office_location" id="office_location"
                                class="form-control form-control-sm" value="{{$model->office_location}}">
                        </div>
                        <label for="blood" class="col-sm-2 form-label"> Blood Group</label>
                        <div class=" col-md-3">
                            <input type="text" name="blood" id="blood" class="form-control form-control-sm"
                                value="{{$model->blood_group}}">
                        </div>
                    </div>

                    <!-- <div class="form-group row">
  <label for="dob" class="col-sm-2 form-label">Date Of Birth</label>
                        <div class=" col-md-3">
                            <input type="text" name="dob" id="dob" class="form-control form-control-sm"
                                value="{{$model->date_of_birth ? date('d-m-Y', strtotime($model->date_of_birth)) : ''}}">
                        </div>
                      <label for="doj" class="col-sm-2 form-label">Date Of Joining <span style="color:red">*</span></label>
                        <div class=" col-md-3">
                            <input type="text" name="doj" id="doj" class="form-control form-control-sm"
                                value="{{$model->date_of_joining ? date('d-m-Y', strtotime($model->date_of_joining)) : ''}}" required>
                        </div>

                     </div>   -->
                    <div class="form-group row">

                        <label for="doj" class="col-sm-2 form-label">Date Of Birth <span
                                style="color:red">*</span></label>
                        <div class=" col-md-3">
                            <input type="text" name="dob" id="dob" class="form-control form-control-sm"
                                value="{{$model->date_of_birth ? date('d-m-Y', strtotime($model->date_of_birth)) : ''}}"
                                required>
                        </div>
                        <label for="dol" class="col-sm-2 form-label">Age <span style="color:red">*</span></label>
                        <div class=" col-md-3">
                            <input type="text" name="age" id="age" class="form-control form-control-sm"
                                value="{{$model->age}}" required readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="dol" class="col-sm-2 form-label">DOJ<span style="color:red">*</span></label>
                        <div class=" col-md-3">
                            <input type="text" name="doj" id="doj" class="form-control form-control-sm"
                                value="{{$model->date_of_joining ? date('d-m-Y', strtotime($model->date_of_joining)) : ''}}"
                                required>
                        </div>
                        <label for="dol" class="col-sm-2 form-label">DOJ - (L & T) <span
                                style="color:red">*</span></label>
                        <div class=" col-md-3">
                            <input type="text" name="dojlt" id="dojlt" class="form-control form-control-sm"
                                value="{{$model->date_of_joining_lt ? date('d-m-Y', strtotime($model->date_of_joining_lt)) : ''}}"
                                required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="doj" class="col-sm-2 form-label">Total Years of Exp<span
                                style="color:red">*</span></label>
                        <div class=" col-md-3">
                            <input type="text" name="years" id="years" class="form-control form-control-sm"
                                value="{{$model->years_of_experience}}" required>
                        </div>
                        <label for="dol" class="col-sm-2 form-label">Date Of Leaving</label>
                        <div class=" col-md-3">
                            <input type="text" name="dol" id="dol" class="form-control form-control-sm"
                                value="{{$model->date_of_leaving ? date('d-m-Y', strtotime($model->date_of_leaving)) : ''}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lad" class="col-sm-2 form-label">Last Appraisal Date</label>
                        <div class=" col-md-3">
                            <input type="text" name="lad" id="lad" class="form-control form-control-sm"
                                value="{{$model->last_appraisal_date ? date('d-m-Y', strtotime($model->last_appraisal_date)) : ''}}">
                        </div>
                        <label for="lad" class="col-sm-2 form-label">Appraisal Due Date</label>
                        <div class=" col-md-3">
                            <input type="text" name="appraisal_due_date" id="appraisal_due_date"
                                class="form-control form-control-sm"
                                value="{{$model->appraisal_due_date ? date('d-m-Y', strtotime($model->appraisal_due_date)) : ''}}">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="lad" class="col-sm-2 form-label">Date Of Offer </label>
                        <div class=" col-md-3">
                            <input type="text" name="date_of_offer" id="date_of_offer"
                                class="form-control form-control-sm"
                                value="{{$model->date_of_offer ? date('d-m-Y', strtotime($model->date_of_offer)) : ''}}">
                        </div>

                        <label for="email_personal" class="col-sm-2 form-label">Email(Personal) </label>
                        <div class=" col-md-3">
                            <input type="text" name="email_personal" id="email_personal"
                                class="form-control form-control-sm" value="{{$model->email_personal}}">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="offer_accepted" class="col-sm-2 form-label">Offer Accepted</label>
                        <div class=" col-md-3">
                            <input type="text" name="offer_accepted" id="offer_accepted"
                                class="form-control form-control-sm"
                                value="{{$model->offer_accepted ?  date('d-m-Y', strtotime($model->offer_accepted)) : ''}}">
                        </div>
                        <label for="department" class="col-sm-2 form-label">Department<span
                                style="color:red">*</span></label>
                        <div class=" col-md-3">
                            <select class="form-control form-control-sm" name="department" id="department" required>
                                <option></option>
                                @foreach($depts as $dept)
                                <option value="{{$dept->id}}"
                                    {{ old('department', $model->department_id) == $dept->id ? 'selected' : '' }}>
                                    {{ucfirst($dept->department_name)}}</option>  
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <h6><u>Employee Address</u></h6>
                    <div class="form-group row">
                        <label for="address_1" class="col-sm-2 form-label">Res.No</label>
                        <div class=" col-md-3">
                            <input type="text" name="address_1" id="address_1" class="form-control form-control-sm"
                                value="{{$model->address_1}}">
                        </div>

                        <label for="address_2" class="col-sm-2 form-label">Res.Name</label>
                        <div class=" col-md-3">
                            <input type="text" name="address_2" id="address_2" class="form-control form-control-sm"
                                value="{{$model->address_2}}">
                        </div>
                    </div>
                    <div class="form-group row">


                        <label for="address_3" class="col-sm-2 form-label">Road/Street</label>
                        <div class=" col-md-3">
                            <input type="text" name="address_3" id="address_3" class="form-control form-control-sm"
                                value="{{$model->address_3}}">
                        </div>

                        <label for="address_4" class="col-sm-2 form-label">Locality/Area</label>
                        <div class=" col-md-3">
                            <input type="text" name="address_4" id="address_4" class="form-control form-control-sm"
                                value="{{$model->address_4}}">
                        </div>
                    </div>
                    <div class="form-group row">


                        <label for="address_5" class="col-sm-2 form-label">City</label>
                        <div class=" col-md-3">
                            <input type="text" name="address_5" id="address_5" class="form-control form-control-sm"
                                value="{{$model->address_5}}">
                        </div>

                        <label for="address_6" class="col-sm-2 form-label">District</label>
                        <div class=" col-md-3">
                            <input type="text" name="address_6" id="address_6" class="form-control form-control-sm"
                                value="{{$model->address_6}}">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label for="address_7" class="col-sm-2 form-label">State</label>
                        <div class=" col-md-3">
                            <input type="text" name="address_7" id="address_7" class="form-control form-control-sm"
                                value="{{$model->address_7}}">
                        </div>

                        <label for="address_8" class="col-sm-2 form-label">Pincode</label>
                        <div class=" col-md-3">
                            <input type="text" name="address_8" id="address_8" class="form-control form-control-sm"
                                value="{{$model->address_8}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status_id" class="col-sm-2 form-label"> Status</label>
                        <div class=" col-md-3">
                            <select class="form-control form-control-sm" name="status_id">
                                <option></option>
                                @foreach($status as $sta)
                                <option value="{{$sta->id}}"
                                    {{ old('location_id', $model->status_id) == $sta->id ? 'selected' : '' }}>
                                    {{ucfirst($sta->status)}}</option>
                                @endforeach
                            </select>
                        </div>



                        <label for="status_id" class="col-sm-2 form-label"> </label>
                        <div class="col-md-2 imgage-box">
                            <img src="{{ asset('../storage/app/public/employee/'.$model->photo) }}" img id="blah"
                                alt="your image" width="130" height="150" />
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
                    <div>
            </form>

        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
$(function() {
    $('#doj,#dojlt,#dol,#lad,#appraisal_due_date,#date_of_offer,#offer_accepted').datepicker({
        autoclose: true,
        zIndex: 2048,
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
    });
    $("#designation,#location,#project,#department").select2();
});
$(function() {
    $('#dob').datepicker({
        autoclose: true,
        zIndex: 2048,
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        yearRange: '1950:' + new Date().getFullYear().toString()
    }).change(function() {
        var dob = new Date($(this).val());
        var today = new Date();
        var age = Math.floor((today - dob) / (365.25 * 24 * 60 * 60 * 1000));
        $('#age').val(age);
    });

});
</script>
@endpush