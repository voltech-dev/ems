@extends('layouts.app')

@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Emp Details View</a></li>
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
$projects = App\Models\ProjectDetails::all();
$location = App\Models\Locations::all();
$status = App\Models\Statuses::all();
$auth = App\Models\Authorities::all();

error_reporting(0);

?>

@section('content')
<div class="p-6">
    <div class="ml-1">
        <div class="mt-1 text-gray-600 dark:text-gray-400 text-sm">
            <div class="row">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header"
                            style="color: #31708f;background-color: #d9edf7; border-color: #bce8f1;">
                            <h3 class="card-title">Employee Id: {{$model-> emp_code}}</h3>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table
                                    class="table table-vcenter text-nowrap mb-0 table-striped table-bordered border-top">
                                    <thead class="">
                                        <tr>
                                            <th colspan=4>General</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="font-weight-bold">Employment Code</td>
                                            <td> {{$model->emp_code}} </td>
                                            <td class="font-weight-bold">Name</td>
                                            <td> {{$model->emp_name}} </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold"> Date of Joining</td>
                                            <td> {{$model->date_of_joining}} </td>
                                            <td class="font-weight-bold"> Date of Birth (as per document)</td>
                                            <td> {{$model->date_of_birth}} </td>

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
                                            <td> {{$model->date_of_leaving}} </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Project</td>
                                            <td> {{$model->project_id}} </td>
                                            <td class="font-weight-bold">Location</td>
                                            <td> {{$model->location_id}} </td>

                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Last Appraisal Date</td>
                                            <td> {{$model->last_appraisal_date}} </td>
                                            <td class="font-weight-bold">Reason for Leaving </td>
                                            <td> {{$model->reason_for_leaving}} </td>

                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Reporting Authority </td>
                                            <td> {{$model->reporting_authority_id}} </td>
                                            <td class="font-weight-bold">Status</td>
                                            <td> {{$model->status_id}} </td>
                                        </tr>

                                    </tbody>
                                    <?php 
                        $remunerat = App\Models\EmpRemunerationDetails::where(['empid'=>$model->id])->first();
                        ?>
                                    <thead class="">
                                        <tr>
                                            <th colspan=4>Remuneration</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="font-weight-bold">Salary Structure</td>
                                            <td> {{$remunerat->salary_structure}} </td>
                                            <td class="font-weight-bold">Esi Applicability</td>
                                            <td> {{$remunerat->esi_applicability}} </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Pf Applicablity</td>
                                            <td> {{$remunerat->pf_applicablity}} </td>
                                            <td class="font-weight-bold">Restrict Pf</td>
                                            <td> {{$remunerat->restrict_pf}} </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Basic</td>
                                            <td> {{$remunerat->basic}} </td>
                                            <td class="font-weight-bold">HRA</td>
                                            <td> {{$remunerat->hra}} </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Splallowance</td>
                                            <td> {{$remunerat->splallowance}} </td>
                                            <td class="font-weight-bold">Dearness Allowance</td>
                                            <td> {{$remunerat->Dearness_allowance}} </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Conveyance</td>
                                            <td> {{$remunerat->conveyance}} </td>
                                            <td class="font-weight-bold">Lta</td>
                                            <td> {{$remunerat->lta}} </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Medical</td>
                                            <td> {{$remunerat->medical}} </td>
                                            <td class="font-weight-bold">Other Allowance</td>
                                            <td> {{$remunerat->other_allowance}} </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Gross Salary</td>
                                            <td> {{$remunerat->gross_salary}} </td>
                                            <td class="font-weight-bold"></td>
                                            <td> </td>
                                        </tr>
                                    </tbody>
                                    <?php 
                        $statue = App\Models\EmpStatutorydetails::where(['empid'=>$model->id])->first();
                        ?>
                                    <thead class="">
                                        <tr>
                                            <th colspan=4>Statutory</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="font-weight-bold">ESI No</td>
                                            <td> {{$statue->esino}} </td>
                                            <td class="font-weight-bold">ESI Dispensary</td>
                                            <td> {{$statue->esidispensary}} </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">EPF No</td>
                                            <td> {{$statue->epfno}} </td>
                                            <td class="font-weight-bold">EPF UAN No</td>
                                            <td> {{$statue->epfuanno}} </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Professional Tax</td>
                                            <td> {{$statue->professionaltax}} </td>
                                            <td class="font-weight-bold"></td>
                                            <td> </td>
                                        </tr>
                                        <tr>

                                    </tbody>
                                    <?php 
                        $bank = App\Models\EmpBankdetails::where(['empid'=>$model->id])->first();
                        ?>
                                    <thead class="">
                                        <tr>
                                            <th colspan=4>Bank</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="font-weight-bold">Bank Name</td>
                                            <td> {{$bank->bankname}} </td>
                                            <td class="font-weight-bold">AC Number</td>
                                            <td> {{$bank->acnumber}} </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Branch</td>
                                            <td> {{$bank->branch}} </td>
                                            <td class="font-weight-bold">IFSC</td>
                                            <td> {{$bank->ifsc}} </td>
                                        </tr>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection