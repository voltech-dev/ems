@extends('layouts.app')

@section('header')
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
                                    <td  rowspan="5" align="center"><img src="{{ asset('../storage/app/public/employee/'.$model->photo) }}"img id="blah" alt="your image" width="130px;" height="150px;"/></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold"> Date of Joining</td>
                                    <td> {{ date('d-m-Y', strtotime($model->date_of_joining))}} </td>
                                    <td class="font-weight-bold"> Date of Birth (as per document)</td>
                                    <td>  {{ date('d-m-Y', strtotime($model->date_of_birth))}}</td>

                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Gender</td>
                                    <td> {{$model->gender}} </td>
                                    <td class="font-weight-bold">Blood Group</td>
                                    <td> {{$model->blood_group}} </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Mobile</td>
                                    <td> {{$model->mobile}} </td>
                                    <td class="font-weight-bold"> Email</td>
                                    <td> {{$model->mail}} </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold"> Department</td>
                                    <td> {{$model->department_id}} </td>
                                    <td class="font-weight-bold"> date Of Leaving</td>
                                    <td>  {{ date('d-m-Y', strtotime($model->date_of_leaving))}} </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Project</td>
                                    <td> {{$projects->project_name}} </td>
                                    <td class="font-weight-bold">Location</td>
                                    <td> {{$location->location}} </td>
                                    <td></td>

                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Last Appraisal Date</td>
                                    <td>  {{ date('d-m-Y', strtotime($model->last_appraisal_date))}} </td>
                                    <td class="font-weight-bold">Reason for Leaving </td>
                                    <td> {{$model->reason_for_leaving}} </td>
                                    <td></td>

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
                                    <td class="font-weight-bold">Esi Applicability</td>
                                    <td> {{$remunerat->esi_applicability}} </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Pf Applicablity</td>
                                    <td> {{$remunerat->pf_applicablity}} </td>
                                    <td class="font-weight-bold">Restrict Pf</td>
                                    <td> {{$remunerat->restrict_pf}} </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Basic</td>
                                    <td> {{$remunerat->basic}} </td>
                                    <td class="font-weight-bold">HRA</td>
                                    <td> {{$remunerat->hra}} </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Splallowance</td>
                                    <td> {{$remunerat->splallowance}} </td>
                                    <td class="font-weight-bold">Medical</td>
                                    <td> {{$remunerat->medical}} </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Conveyance</td>
                                    <td> {{$remunerat->conveyance}} </td>
                                    <td class="font-weight-bold">Education</td>
                                    <td> {{$remunerat->education}} </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Gross Salary</td>
                                    <td> {{$remunerat->gross_salary}} </td>
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
                                    <td class="font-weight-bold">GPA</td>
                                    <td> {{$statue->gpa}} </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">GMC</td>
                                    <td> {{$statue->gmc}} </td>
                                    <td class="font-weight-bold"></td>
                                    <td></td>
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
                                    <td class="font-weight-bold">AC Number</td>
                                    <td> {{$bank->acnumber}} </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Branch</td>
                                    <td> {{$bank->branch}} </td>
                                    <td class="font-weight-bold">IFSC</td>
                                    <td> {{$bank->ifsc}} </td>
                                    <td></td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
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