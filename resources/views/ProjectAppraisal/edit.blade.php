@extends('layouts.project')
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
    <div class="page-rightheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Appraisal</a></li>
            <li class="breadcrumb-item"><a href="#"> Appraisal View</a></li>
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
$designation = App\Models\Designation::all();
error_reporting(0);
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
        <form action="{{url('/appraisalpost/'.$emp->id)}}" method="POST" onsubmit="return validateForm()">
            {{ csrf_field() }}

            <div class="p-2" style="background-color:#e9ecec;">
                <i class="fa fa-user" aria-hidden="true"></i>&nbsp;
                {{$emp->emp_name}} Appraisal Result of financial Year <?php if(date('m') > 3){echo (date('Y') - 1 ).'-'.date('Y');} ?>
            </div>
            <br>
            <input type="hidden" name="empid" id="empid" class="form-control" value="{{$emp->id}}">
            <input type="hidden" name="project_id" id="project_id" class="form-control" value="{{Auth::user()->project_id}}">
            <input type="hidden" name="date" id="date" class="form-control" value="<?php echo date('Y-m-d');?>">
            <input type="hidden" name="review" id="review" class="form-control" value="<?php if(date('m') > 3){echo (date('Y') - 1 ).'-'.date('Y');} ?>">


            <h5><u>Evaluation</u></h5>
            <div class="form-group row">
                <label for="grievance" class="col-sm-3 form-label">Evaluator Name</label>
                <div class=" col-md-3">
                    <input type="text" name="evaname" id="evaname" class="form-control form-control-sm"
                        value="{{$appraisal->evaluatorname}}" required>
                </div>
                <label for="employee_code" class="col-sm-3 form-label">Evaluator Emp Code</label>
                <div class=" col-md-3">
                    <input type="text" name="evacode" id="evacode" class="form-control form-control-sm"
                        value="{{$appraisal->evaluatorid}}" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="grievance" class="col-sm-3 form-label">Work Efficiency</label>
                <div class=" col-md-3">
                    <input type="text" name="workefficiency" id="workefficiency" class="form-control form-control-sm"
                        value="{{$appraisal->workefficiency}}">
                </div>
                <label for="employee_code" class="col-sm-3 form-label">Responsibility</label>
                <div class=" col-md-3">
                    <input type="text" name="responsibility" id="responsibility" class="form-control form-control-sm"
                        value="{{$appraisal->responsibility}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="grievance" class="col-sm-3 form-label">Team Work</label>
                <div class=" col-md-3">
                    <input type="text" name="teamwork" id="teamwork" class="form-control form-control-sm" value="{{$appraisal->teamwork}}">
                </div>
                <label for="employee_code" class="col-sm-3 form-label">Time Management</label>
                <div class=" col-md-3">
                    <input type="text" name="timemngt" id="timemngt" class="form-control form-control-sm" value="{{$appraisal->timemngt}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="grievance" class="col-sm-3 form-label">Communication Skill</label>
                <div class=" col-md-3">
                    <input type="text" name="communication" id="communication" class="form-control form-control-sm"
                        value="{{$appraisal->communication}}">
                </div>
                <label for="employee_code" class="col-sm-3 form-label">Problem Solving Skill</label>
                <div class=" col-md-3">
                    <input type="text" name="problemsolving" id="problemsolving" class="form-control form-control-sm"
                        value="{{$appraisal->problemsolving}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="grievance" class="col-sm-3 form-label">Integrity</label>
                <div class=" col-md-3">
                    <input type="text" name="integrity" id="integrity" class="form-control form-control-sm" value="{{$appraisal->integrity}}">
                </div>

                <label for="grievance" class="col-sm-3 form-label">Attendance</label>
                <div class=" col-md-3">
                    <input type="text" name="attendance" id="attendance" class="form-control form-control-sm" value="{{$appraisal->attendance}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="employee_code" class="col-sm-3 form-label"><u>Average Score</u></label>
                <div class=" col-md-3">
                    <input type="text" name="score" id="score" class="form-control form-control-sm" value="{{$appraisal->score}}">
                </div>
            </div>
    </div>
    <h5><u>Additional Reviews</u></h5>
    <div class="form-group row">

        <label for="employee_code" class="col-sm-5 form-label">Noteworthy accomplishments during this review
            period</label>
        <div class=" col-md-7">
            <textarea name="noteworthy" id="noteworthy" class="form-control form-control-sm">{{$appraisal->noteworthy}}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="employee_code" class="col-sm-5 form-label">Suggestions for Performance Improvements</label>
        <div class=" col-md-7">
            <textarea name="suggestion" id="suggestion" class="form-control form-control-sm">{{$appraisal->suggestion}}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="employee_code" class="col-sm-5 form-label">Overall Evaluation Feedbacks</label>
        <div class=" col-md-7">
            <textarea name="evaluation" id="evaluation" class="form-control form-control-sm">{{$appraisal->evaluation}}</textarea>
        </div>
    </div>
    <h5><u>Overall Performance Rating: </u>(Poor / Good / Excellent / Outstanding)</h5>
    <div class="form-group row">
        <label for="employee_code" class="col-sm-4 form-label">Recommendation for Increment in % (As per Policy)</label>
        <div class="col-md-2">
            <select name="recommendation" id="recommendation" class="form-control form-control-sm">
                <option value="{{$appraisal->recommendation}}" selected>{{$appraisal->recommendation}}</option>
                <option value="" disabled>Select Performance</option>
                <option value="Poor">Poor</option>
                <option value="Good">Good</option>
                <option value="Excellent">Excellent</option>
                <option value="Outstanding">Outstanding</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="employee_code" class="col-sm-4 form-label">Recommendation for Promotion in % (As per Policy)</label>
        <div class="col-md-2">
            <select name="promotion" id="promotion" class="form-control form-control-sm">
            <option value="{{$appraisal->promotion}}" selected>{{$appraisal->promotion}}</option>
                <option value="" disabled>Select Promotion</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>
        <div class="col-md-6">
            <input type="text" name="promotion_detail" id="promotion_detail" class="form-control form-control-sm"
                value="{{$appraisal->promotion_category}}" style='display:none;' placeholder="If Yes, Mention Role">
        </div>
    </div>
    <div class="form-group row">
        <label for="employee_code" class="col-sm-4 form-label">Recommendation for Change in Role/Designation</label>
        <div class="col-md-2">
            <select name="role" id="role" class="form-control form-control-sm">
            <option value="{{$appraisal->role}}" selected>{{$appraisal->role}}</option>
                <option value="" disabled>Select Performance</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>
        <div class="col-md-6">
            <input type="text" name="role_detail" id="role_detail" class="form-control form-control-sm" value="{{$appraisal->role_description}}"
                style='display:none;' placeholder="If Yes, Role/Designation">
        </div>
    </div>
    <br /><br /><br />
    <div class="form-row">
        <div class="col-md-1"></div>
        <div class="col-md-2">
            <a class="btn btn-dark" href="{{ url('/appraisalview/'.$emp->id) }}"><i
                    class="glyphicon glyphicon-chevron-left"></i>
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
    $('#status,#type_of_queryies,#grievance_address').select2({
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
    $('#promotion').on('change', function() {
        if (this.value == 'Yes') {
            $("#promotion_detail").show();
        } else {
            $("#promotion_detail").hide();
        }
    });
    $('#role').on('change', function() {
        if (this.value == 'Yes') {
            $("#role_detail").show();
        } else {
            $("#role_detail").hide();
        }
    });

    function validateForm() {
        alert('hiii');
        var promotion = $('#promotion').val();
        var promotion_details = $('#promotion_detail').val();
        if(promotion == "Yes" && promotion_details == ""){
            alert("Role must be filled out");
            return false;
        }  
    }
    $("#role,#promotion,#recommendation").select2({
        //  theme: 'classic'
    });
    $("#workefficiency,#responsibility,#teamwork,#timemngt,#communication,#problemsolving,#attendance").keyup(function() {
        const value1 = parseInt($("#workefficiency").val());
        const value2 = parseInt($("#responsibility").val());
        const value3 = parseInt($("#teamwork").val());
        const value4 = parseInt($("#timemngt").val());
        const value5 = parseInt($("#communication").val());
        const value6 = parseInt($("#problemsolving").val());
        const value7 = parseInt($("#attendance").val());
        const value8 = parseInt($("#integrity").val());
        const value9 = value1 + value2 + value3 + value4 + value5 + value6 + value7 + value8;
        const value10 = value9 / 8;
        $("#score").val(value10);
    });
});
</script>
@endpush