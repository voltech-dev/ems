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
            <li class="breadcrumb-item"><a href="#">Appraisal for {{$emp->emp_name}} </a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">View</a></li>
        </ol>
    </div>
</div>
<br />
<div class="col text-right">
    <!--<button onclick="location.href='{{url('/export')}}'"
            class="btn-success">Export</button> -->
    <a href="{{url('/appraisaledit/'.$emp->id)}}"><button class="btn-warning">Edit</button></a>

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
                Appraisal View
            </div>
            <br>
            <!-- <input type="hidden" name="empid" id="empid" class="form-control" value="{{$model->id}}"> -->

            <input type="hidden" name="empid" id="empid" class="form-control" value="{{$empid}}">
            <div class="form-group row">
                <label for="grievance" class="col-sm-3 form-label">Date of Review</label>
                <div class=" col-md-3">
                    <input type="text" class="form-control form-control-sm" value="{{$appraisal->review_date}}" readonly>
                </div>
                <label for="employee_code" class="col-sm-3 form-label">Review Period</label>
                <div class=" col-md-3">
                    <input type="text" class="form-control form-control-sm" value="{{$appraisal->review_period}}" readonly>
                </div>
            </div>
            <h5><u>Employee Info</u></h5>
            <div class="form-group row">
                <table class="table table-bordered card-table table-vcenter text-nowrap">
                    <tbody>
                        <tr>
                            <th scope="row" width="20%">Employee Name</th>
                            <td width="30%" style="font-size: 14px;">{{$emp->emp_name}}</td>
                            <th scope="row" width="20%">Project</th>
                            <td width="30%" style="font-size: 14px;">{{$emp->project->project_name}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Employee Code</th>
                            <td style="font-size: 14px;">{{$emp->emp_code}}</td>
                            <th scope="row">Evaluator Name</th>
                            <td style="font-size: 14px;">{{$appraisal->evaluatorname}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Designation</th>
                            <td style="font-size: 14px;">{{$emp->designation->designation_name}}</td>
                            <th scope="row">Evaluator Designation</th>
                            <td style="font-size: 14px;">Project Admin</td>
                        </tr>
                        <tr>
                            <th scope="row">Total years of Experience</th>
                            <td style="font-size: 14px;">{{$emp->years_of_experience}}</td>
                            <th scope="row">Years of Experience in Voltech</th>
                            <td style="font-size: 14px;">
                            <?php
                            $now = date('Y'); // or your date as well
                            $your_date = date('Y',strtotime($emp->date_of_joining));
                            $datediff = $now - $your_date;
                            
                            echo round($datediff / (60 * 60 * 24));
                            ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h5>Evaluation(To be filled by Respective Manager – Client)</h5>
            <h5><u>Scoring Guidelines</u>(1 to 5 | 5 – Being Highest | 1 – Being Lowest)</h5>
            <div class="form-group row">
                <table class="table table-bordered card-table table-vcenter text-nowrap" width="100%">
                    <tbody>
                        <tr>
                            <th scope="row" style="font-size:12px">Quality</th>
                            <th scope="row" style="font-size:12px">Work Efficiency</th>
                            <th scope="row" style="font-size:12px">Responsibility</th>
                            <th scope="row" style="font-size:12px">Team Work</th>
                            <th scope="row" style="font-size:12px">Time Management</th>
                            <th scope="row" style="font-size:12px">Communication Skill</th>
                            <th scope="row" style="font-size:12px">Problem Solving Skill</th>
                            <th scope="row" style="font-size:12px">Integrity</th>
                            <th scope="row" style="font-size:12px">Attendance</th>
                        </tr>
                        <tr>
                            <th scope="row" style="font-size:12px">Score</th>
                            <td style="font-size:12px">{{$appraisal->workefficiency}}</td>
                            <td style="font-size:12px">{{$appraisal->responsibility}}</td>
                            <td style="font-size:12px">{{$appraisal->teamwork}}</td>
                            <td style="font-size:12px">{{$appraisal->timemngt}}</td>
                            <td style="font-size:12px">{{$appraisal->communication}}</td>
                            <td style="font-size:12px">{{$appraisal->problemsolving}}</td>
                            <td style="font-size:12px">{{$appraisal->integrity}}</td>
                            <td style="font-size:12px">{{$appraisal->attendance}}</td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="form-group row">
                <h6 class="col-sm-4">Average Score (Total/No.of Parameters)</h6><input type="text" name="teamwork"
                    id="teamwork" class="form-control form-control-sm col-sm-3" value="{{$appraisal->score}}" readonly>
            </div>
    </div>
    <h5><u>Additional Reviews</u></h5>
    <div class="form-group row">

        <label for="employee_code" class="col-sm-5 form-label">Noteworthy accomplishments during this review
            period</label>
        <div class=" col-md-7">
            <textarea name="noteworthy" id="noteworthy" class="form-control form-control-sm" readonly>{{$appraisal->noteworthy}}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="employee_code" class="col-sm-5 form-label">Suggestions for Performance Improvements</label>
        <div class=" col-md-7">
            <textarea name="suggestion" id="suggestion" class="form-control form-control-sm" readonly>{{$appraisal->suggestion}}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="employee_code" class="col-sm-5 form-label">Overall Evaluation Feedbacks</label>
        <div class=" col-md-7">
            <textarea name="evaluation" id="evaluation" class="form-control form-control-sm" readonly>{{$appraisal->evaluation}}</textarea>
        </div>
    </div>
    <h5><u>Overall Performance Rating: </u>(Poor / Good / Excellent / Outstanding)</h5>
    <div class="form-group row">
        <label for="employee_code" class="col-sm-4 form-label">Recommendation for Increment in % (As per Policy)</label>
        <div class="col-md-4">
        <input type="text" name="teamwork" id="teamwork" class="form-control form-control-sm col-sm-3" value="{{$appraisal->recommendation}}" readonly>           
        </div>
    </div>
    <div class="form-group row">
        <label for="employee_code" class="col-sm-4 form-label">Recommendation for Promotion in % (As per Policy)</label>
        <div class="col-md-4">
           <input type="text" name="teamwork" id="teamwork" class="form-control form-control-sm col-sm-3" value="{{$appraisal->promotion}}" readonly>
        </div>
        <div class="col-md-4">
            <input type="text" name="promotion_detail" id="promotion_detail" class="form-control form-control-sm"
                value="{{$appraisal->promotion_category}}" placeholder="If Yes, Mention Role" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="employee_code" class="col-sm-4 form-label">Recommendation for Change in Role/Designation</label>
        <div class="col-md-4">
          <input type="text" name="teamwork" id="teamwork" class="form-control form-control-sm col-sm-3" value="{{$appraisal->role}}" readonly> 
        </div>
        <div class="col-md-4">
            <input type="text" name="role_detail" id="role_detail" class="form-control form-control-sm" value="{{$appraisal->role_description}}" placeholder="If Yes, Role/Designation" readonly>
        </div>
    </div>
    <br /><br /><br />

    <div class="form-row">
        <div class="col-md-1"></div>
        <div class="col-md-2">
            <a class="btn btn-dark" href="{{ url('/appraisal_project') }}"><i
                    class="glyphicon glyphicon-chevron-left"></i>
                Back</a>
        </div>

        <div class="col-md-1"></div>
        <!-- <div class="col-md-2">
            <button type="submit" class="btn btn-success">
                <i class="fa fa-check"></i> Save
            </button>
        </div> -->
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

});
</script>
@endpush