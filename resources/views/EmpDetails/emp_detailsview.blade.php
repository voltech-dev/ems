@extends('layouts.app')

@section('header')
<style>
/* The Modal (background) */
.modal {
    display: none;
    /* Hidden by default */
    position: fixed;
    /* Stay in place */
    z-index: 1;
    /* Sit on top */
    padding-top: 100px;
    /* Location of the box */
    left: 0;
    top: 0;
    width: 100%;
    /* Full width */
    height: 100%;
    /* Full height */
    overflow: auto;
    /* Enable scroll if needed */
    background-color: rgb(0, 0, 0);
    /* Fallback color */
    background-color: rgba(0, 0, 0, 0.4);
    /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 40%;
}

/* The Close Button */
.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
</style>
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Employee Details </a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">{{$model->id}}</a></li>
        </ol>
    </div>
    <br />
    <!-- <div class="col">
        <span class="page-title">Applicant</span> &#187; Create
    </div>-->
</div>
@endsection
<?php
$projects = App\Models\ProjectDetails::where(['id'=>$model->project_id])->first();
$location = App\Models\Locations::where(['id'=>$model->location_id])->first();
$status = App\Models\Statuses::where(['id'=>$model->status_id])->first();
//$dob  = App\Models\Emp::where(['id'=>$model->project_id])->first();
$auth = App\Models\Authorities::all();
$dept = App\Models\Departments::where(['id'=>$model->department_id])->first();
error_reporting(0);

?>

@section('content')
<div class="ml-1">
    <div class="mt-1 text-gray-600 dark:text-gray-400 text-sm">
        <div class="row">
            <div class="col-md-10">
                <div class="card-body" style="padding: 0.5rem 0.5rem;">
                    <div class="table-responsive">
                        <table class="table table-vcenter text-nowrap mb-0 table-striped table-bordered border-top">
                            <thead class="">
                                <tr>
                                    <th colspan=5>Employee Details: {{$model-> emp_code}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="font-weight-bold">Employment Code</td>
                                    <td> {{$model->emp_code}} </td>
                                    <td class="font-weight-bold">Name</td>
                                    <td> {{$model->emp_name}} </td>
                                    <td rowspan="5" align="center">
                                        <img
                                            src="<?php 
                                            if ($model->photo == null){
                                                echo asset('../storage/app/public/employee/avatar.png');
                                             }else{
                                               echo asset('../storage/app/public/employee/'.$model->photo);
                                             }
                                              ?>"
                                            id="blah" alt="your image" width="130px;" height="150px;" /></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold"> Date of Joining</td>
                                    <td> {{ $model->date_of_joining ? date('d-m-Y', strtotime($model->date_of_joining)) : ''}}
                                    </td>
                                    <td class="font-weight-bold"> Date of Joining L & T</td>
                                    <td> {{ $model->date_of_joining_lt ? date('d-m-Y', strtotime($model->date_of_joining_lt)) : ''}}
                                    </td>

                                </tr>
                                <tr>
                                <td class="font-weight-bold">Age</td>
                                    <td> {{$model->age}} </td>
                                    <td class="font-weight-bold"> Date of Birth (as per document)</td>
                                    <td> {{ $model->date_of_birth ? date('d-m-Y', strtotime($model->date_of_birth)) : ''}}
                                    </td>

                                </tr>
                                <tr>                                    
                                    <td class="font-weight-bold">Experience</td>
                                    <td> {{$model->years_of_experience}} </td>
                                    <td class="font-weight-bold">Gender</td>
                                    <td> {{$model->gender}} </td>
                                </tr>
                                <tr>                                    
                                    <td class="font-weight-bold">Blood Group</td>
                                    <td> {{$model->blood_group}} </td>
                                    <td class="font-weight-bold">Mobile</td>
                                    <td> {{$model->mobile}} </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold"> Email</td>
                                    <td> {{$model->mail}} </td>
                                    <td class="font-weight-bold"> Department</td>
                                    <td colspan="2"> {{$dept->department_name}} </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold"> Date Of Leaving</td>
                                    <td> {{ $model->date_of_leaving ? date('d-m-Y', strtotime($model->date_of_leaving)):''}}
                                    </td>
                                    <td class="font-weight-bold">Project</td>
                                    <td colspan="2"> {{$projects->project_name}} </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Location</td>
                                    <td colspan="4"> {{$location->location}} </td>

                                </tr>

                                <tr>
                                    <td class="font-weight-bold">Office Location</td>
                                    <td colspan="4"> {{$model->office_location}} </td>
                                </tr>


                                <tr>
                                    <td class="font-weight-bold">Last Appraisal Date</td>
                                    <td> {{ $model->last_appraisal_date ? date('d-m-Y', strtotime($model->last_appraisal_date)) :''}}
                                    </td>
                                    <td class="font-weight-bold">Reason for Leaving </td>
                                    <td colspan="2"> {{$model->reason_for_leaving}} </td>

                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Road/Street</td>
                                    <td> {{$model->address_3}} </td>
                                    <td class="font-weight-bold">Locality/Area</td>
                                    <td> {{$model->address_4}} </td>
                                    <td></td>

                                </tr>
                                <tr>
                                    <td class="font-weight-bold">City</td>
                                    <td> {{$model->address_5}} </td>
                                    <td class="font-weight-bold">District</td>
                                    <td> {{$model->address_6}} </td>
                                    <td></td>

                                </tr>
                                <tr>
                                    <td class="font-weight-bold">State</td>
                                    <td> {{$model->address_7}} </td>
                                    <td class="font-weight-bold">Pincode</td>
                                    <td> {{$model->address_8}} </td>
                                    <td></td>

                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Status</td>
                                    <td> {{$status->status}} </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>

                                </tr>

                            </tbody>
                            <?php 
                        $remunerat = App\Models\EmpRemunerationDetails::where(['empid'=>$model->id])->first();
                        ?>
                            <thead class="">
                                <tr>
                                    <th colspan=5>Remuneration</th>


                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="font-weight-bold">Salary Structure</td>
                                    <td> {{$remunerat->salary_structure}} </td>
                                    <td class="font-weight-bold">ESI Applicability</td>
                                    <td> {{$remunerat->esi_applicability}} </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">PF Applicablity</td>
                                    <td> {{$remunerat->pf_applicablity}} </td>
                                    <td class="font-weight-bold">Restrict PF</td>
                                    <td> {{$remunerat->restrict_pf}} </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Basic</td>
                                    <td> {{$remunerat->basic ? number_format($remunerat->basic,2) :''}} </td>
                                    <td class="font-weight-bold">HRA</td>
                                    <td> {{$remunerat->hra ? number_format($remunerat->hra,2):''}} </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Spl Allowance</td>
                                    <td> {{$remunerat->splallowance ? number_format($remunerat->splallowance,2):''}}
                                    </td>
                                    <td class="font-weight-bold">Medical</td>
                                    <td> {{$remunerat->medical ? number_format($remunerat->medical,2):''}} </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Conveyance</td>
                                    <td> {{$remunerat->conveyance ? number_format($remunerat->conveyance,2) :''}} </td>
                                    <td class="font-weight-bold">Education</td>
                                    <td> {{$remunerat->education ? number_format($remunerat->education,2) : ''}} </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Gross Salary</td>
                                    <td> {{$remunerat->gross_salary ? number_format($remunerat->gross_salary,2):''}}
                                    </td>
                                    <td class="font-weight-bold"></td>
                                    <td> </td>
                                    <td></td>
                                </tr>
                            </tbody>
                            <?php 
                        $statue = App\Models\EmpStatutorydetails::where(['empid'=>$model->id])->first();
                        ?>
                            <thead class="">
                                <tr>
                                    <th colspan=5>Statutory</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="font-weight-bold">ESI No</td>
                                    <td> {{$statue->esino}} </td>
                                    <td class="font-weight-bold">ESI Dispensary</td>
                                    <td> {{$statue->esidispensary}} </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">EPF No</td>
                                    <td> {{$statue->epfno}} </td>
                                    <td class="font-weight-bold">EPF UAN No</td>
                                    <td> {{$statue->epfuanno}} </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Professional Tax</td>
                                    <td> {{$statue->professionaltax}} </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td class="font-weight-bold">GPA</td>
                                    <td> {{$statue->gpa}} </td>
                                    <td class="font-weight-bold">GPA Agency</td>
                                    <td> {{$statue->gpa_agency }}</td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td class="font-weight-bold">GMC</td>
                                    <td> {{$statue->gmc}} </td>
                                    <td class="font-weight-bold">GMC Agency</td>
                                    <td> {{$statue->gmc_agency }}</td>
                                    <td></td>
                                </tr>


                            </tbody>
                            <?php 
                        $bank = App\Models\EmpBankdetails::where(['empid'=>$model->id])->first();
                        ?>
                            <thead class="">
                                <tr>
                                    <th colspan=5>Bank</th>


                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="font-weight-bold">Bank Name</td>
                                    <td> {{$bank->bankname}} </td>
                                    <td class="font-weight-bold">A/C Num</td>
                                    <td> {{$bank->acnumber}} </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Branch</td>
                                    <td> {{$bank->branch}} </td>
                                    <td class="font-weight-bold">IFSC Code</td>
                                    <td> {{$bank->ifsc}} </td>
                                    <td></td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card-body" style="padding: 0.5rem 0.1rem;">
                    <div class="card-header" style="color: #fff;background-color: #337ab7; border-color: #337ab7;">
                        <h3 class="card-title">Documents</h3>
                    </div>
                    <a class="list-group-item" href="{{ url('/offerletter/'.$model->id) }}" target="_blank">Offer
                        Generate</a>
                    <a class="list-group-item" href="#" id="myBtn">Renewal Offer Letter</a>
                    <a class="list-group-item" href="{{ url('/checklist/'.$model->id) }}">Check List</a>
                    <a class="list-group-item" href="{{ url('/credential/'.$model->id) }}">EMS Login</a>
                    <!-- <button id="myBtn">Open Modal</button> -->
                </div>
            </div>
        </div>


        <form action="{{ url('/renewal/'.$model->id) }}" method="POST" target="_blank">
        @csrf
        <!-- The Modal -->
        <!-- The Modal -->
        <div id="myModal" class="modal">
        <input type="hidden" name="empid" id="empid" class="form-control" value="{{$model->id}}">
            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <div class="form-group row">
                    <label for="grievance" class="col-sm-3 form-label">Renewal Date</label>
                    <div class=" col-md-6">
                        <input type="text" name="renewal_date" id="renewal_date" class="form-control form-control-sm"
                            value="{{$model->date_of_joining}}">
                    </div>
                    <!-- <label for="employee_code" class="col-sm-3 form-label"></label> -->
                    <!-- <button class="col-md-3">Next</button> -->
                    <button id="myBtn" type="submit" class="btn btn-success">
                        <i class="fa fa-plus"></i> Continue
                    </button>
                </div>

            </div>

        </div>
        </form>

        <!-- <div class="col-md-2">
                    <div class="card">
                        <div class="card-header" style="color: #fff;background-color: #337ab7; border-color: #337ab7;">
                            <h3 class="card-title">Documents</h3>

                        </div>

                        <a class="list-group-item" href="{{ url('/applicants') }}">Appointment Generate</a>
                        <a class="list-group-item" href="{{ url('/applicants') }}">Appointment Pdf</a>
                        <a class="list-group-item" href="{{ url('/applicants') }}">Annexure</a>
                        <a class="list-group-item" href="{{ url('/applicants') }}">Bonafide </a>
                        <a class="list-group-item" href="{{ url('/applicants') }}">Relieving Letter</a>
                        <a class="list-group-item" href="{{ url('/applicants') }}">Show Cause Notice</a>
                        <a class="list-group-item" href="{{ url('/applicants') }}">Employee Tracking</a>
                    </div>
                </div> -->
    </div>
</div>
@endsection
@push('scripts')
<script>
$(function() {
    $('#renewal_date').datepicker({
        autoclose: true,
        zIndex: 2048,
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
    });
});
// function myFunction() {
//     var id = {{$model->id}};
//     var dateofjoining =  date('d-m-Y', strtotime({{$model->date_of_joining}}));
//     //prompt(id);
//     prompt(id,dateofjoining);
//     // $.ajax({
//     //     type: "GET",
//     //    // url: "{{ url('/projassign') }}",
//     //     url: "{{ url('/renewal/.(id)') }}",
//     //     data: {
//     //         id: id
//     //     },
//     //     //dataType : 'json',                            
//     //     success: function(data) {
//     //         //  $('#lod').val(data.lod);
//     //        // alert(data);
//     //         $("#enquiryreceiveddate").val(data);

//     //     },
//     //     error: function(exception) {

//     //         alert('Something Error');
//     //     }
//     // });

// //   if (person != null) {
// //     document.getElementById("demo").innerHTML =
// //     "Hello " + person + "! How are you today?";
// //   }
// }

// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
@endpush