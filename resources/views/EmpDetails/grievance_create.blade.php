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
            <li class="breadcrumb-item"><a href="#">Grievance</a></li>
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

$numbers = DB::table('grievances')->where('grievance_no', 'like', '%'.'LnT-G-'.'%')->orderBy('id','desc')->first();
$check = $numbers->grievance_no;
if($numbers == ''){
$var = 'LnT-G-';
$serialno = '001';
}else{
$check = $numbers->grievance_no;
$checking = explode('-', $check);
$c = $checking[0];
$cc = $checking[1];
$var = $c.'-'.$cc.'-';
$serialnos = $checking[2]+001;  
$serialno = sprintf("%03s", $serialnos);
}
?>

@section('content')
<div class="row col pb-2" style="margin-left: 5px;">
    <ul class="nav">

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
        <form action="{{ url('/grievancestore') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="p-2" style="background-color:#e9ecec;">
                <i class="fa fa-user" aria-hidden="true"></i>&nbsp;
                Grievance Redressal
            </div>
            <br>
            <!-- <input type="hidden" name="empid" id="empid" class="form-control" value="{{$model->id}}"> -->

            <div class="form-group row">
                <label for="grievance" class="col-sm-3 form-label">Grievance No</label>
                <div class=" col-md-3">
                    <input type="text" name="grievance_no" id="grievance_no" class="form-control form-control-sm"
                        value="LnT-G-{{$serialno}}" readonly>
                </div>
                <label for="employee_code" class="col-sm-3 form-label">Employee Code</label>
                <div class=" col-md-3">
                    <input type="text" name="employee_code" id="employee_code" class="form-control form-control-sm"
                        value="">
                </div>
            </div>
            <div class="form-group row">
                <label for="grievance" class="col-sm-3 form-label">Employee Name</label>
                <div class=" col-md-3">
                    <input type="text" name="employee_name" id="employee_name" class="form-control form-control-sm"
                        value="" readonly>
                </div>
                <label for="employee_code" class="col-sm-3 form-label">Project</label>
                <div class=" col-md-3">
                    <input type="text" name="project" id="project" class="form-control form-control-sm" value=""
                        readonly>
                    <!-- <select class="form-control form-control-sm " id="project" name="project" required>
                        <option></option>
                        @foreach($projects as $project)
                        <option value="{{$project->project_name}}">{{$project->project_name}}</option>
                        @endforeach
                    </select> -->
                </div>
            </div>
            <div class="form-group row">
                <label for="grievance" class="col-sm-3 form-label">Designation</label>
                <div class=" col-md-3">
                    <input type="text" name="designation" id="designation" class="form-control form-control-sm" value=""
                        readonly>
                    <!-- <select class="form-control form-control-sm " id="designation" name="designation" required>
                        <option></option>
                        @foreach($designation as $desg)
                        <option value="{{$desg->designation_name}}">{{$desg->designation_name}}</option>
                        @endforeach
                    </select> -->
                </div>
                <label for="employee_code" class="col-sm-3 form-label">Date of Grievance</label>
                <div class=" col-md-3">
                    <input type="text" name="dateofgrievance" id="dateofgrievance" class="form-control form-control-sm"
                        value="<?php echo date("d-m-Y");?>" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="grievance" class="col-sm-3 form-label"> Type of Query</label>
                <div class=" col-md-3">
                    <select class="form-control form-control-sm " id="type_of_queryies" name="type_of_queryies"
                        required>
                        <option value=""></option>
                        <option value="PF">PF</option>
                        <option value="ESI">ESI</option>
                        <option value="Insurance">Insurance</option>
                        <option value="Salary">Salary</option>
                        <option value="Salary Slip">Salary Slip</option>
                        <option value="Form-16">Form-16</option>
                        <option value="Attendance">Attendance</option>
                        <option value="E-Mail">E-Mail</option>
                        <option value="Others">Others</option>
                    </select>

                </div>

                <label for="grievance" class="col-sm-3 form-label">Query</label>
                <div class=" col-md-3">
                    <textarea name="queryies" id="queryies" class="form-control form-control-sm"></textarea>
                </div>

            </div>
            <div class="form-group row">
                <label for="employee_code" class="col-sm-3 form-label">TAT</label>
                <div class=" col-md-3">
                    <input type="text" name="tat" id="tat" class="form-control form-control-sm" value="">
                </div>
                <label for="grievance" class="col-sm-3 form-label">Action Taken</label>
                <div class=" col-md-3">
                    <input type="text" name="action" id="action" class="form-control form-control-sm" value="">
                </div>
            </div>
    </div>
    <div class="form-group row">
        <label for="employee_code" class="col-sm-3 form-label">Grievance Address by - JRR/RJ</label>
        <div class=" col-md-3">
            <input type="text" name="grievance_address" id="grievance_address" class="form-control form-control-sm"
                value="">
        </div>
        <label for="grievance" class="col-sm-3 form-label">Grievance Resolved Date</label>
        <div class=" col-md-3">
            <input type="text" name="grievance_resolved_date" id="grievance_resolved_date"
                class="form-control form-control-sm" value="">
        </div>
    </div>
    <div class="form-group row">
        <label for="employee_code" class="col-sm-3 form-label">Remarks</label>
        <div class=" col-md-3">
            <!-- <input type="text" name="remarks" id="remarks" class="form-control form-control-sm" value=""> -->
            <textarea name="remarks" id="remarks" class="form-control form-control-sm"></textarea>
        </div>
        <label for="institute" class="col-sm-3 form-label">Status</label>
        <div class=" col-md-3">
            <select class="form-control form-control-sm " id="status" name="status" required>
                <option value="Open" selected>Open</option>
                <option value="Closed">Closed</option>
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-1"></div>
        <div class="col-md-2">
            <a class="btn btn-dark" href="{{ url('/grievancelist') }}"><i class="glyphicon glyphicon-chevron-left"></i>
                Back</a>
        </div>

        <div class="col-md-1"></div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-success">
                <i class="fa fa-check"></i> Save
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
    $('#tat,#grievance_resolved_date').datepicker({
        autoclose: true,
        zIndex: 2048,
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
    });
    $('#status,#type_of_queryies').select2({
        //  theme: 'classic'
    });
    $('#employee_code').change(function(event) {
        var employee_code = $('#employee_code').val();
        //alert(employee_code);
        $.ajax({
            type: "GET",
            url: "{{ url('/gather_data') }}",
            data: {
                employee_code: employee_code
            },
            dataType: 'json',
            success: function(data) {
                //  $('#lod').val(data.lod);
                // alert(data);
                $("#employee_name").val(data.empname);
                $("#project").val(data.project);
                $("#designation").val(data.desg);
            },
            error: function(exception) {
                alert('Something Error');
            }
        });
    });

});
</script>
@endpush