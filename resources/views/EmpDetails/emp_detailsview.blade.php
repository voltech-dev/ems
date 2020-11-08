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
<div class="row">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header" style="color: #31708f;background-color: #d9edf7; border-color: #bce8f1;">
                <h3 class="card-title">Employee Id: {{$model-> emp_code}}</h3>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-vcenter text-nowrap mb-0 table-striped table-bordered border-top">
                        <thead class="">
                            <tr>
                                <th colspan=4>General</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="font-weight-bold">Employment Code</td>
                                <td><span class="badge badge-primary">{{$model->emp_code}}</span></td>
                                <td class="font-weight-bold">Name</td>
                                <td><span class="badge badge-primary">{{$model->emp_name}}</span></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold"> Date of Joining</td>
                                <td><span class="badge badge-info">{{$model->date_of_joining}}</span></td>
                                <td class="font-weight-bold"> Date of Birth (as per document)</td>
                                <td><span class="badge badge-info">{{$model->date_of_birth}}</span></td>

                            </tr>
                            <tr>
                                <td class="font-weight-bold">Mobile</td>
                                <td><span class="badge badge-info">{{$model->mobile}}</span></td>
                                <td class="font-weight-bold"> Email</td>
                                <td><span class="badge badge-info">{{$model->mail}}</span></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold"> Department</td>
                                <td><span class="badge badge-info">{{$model->department_id}}</span></td>
                                <td class="font-weight-bold"> date Of Leaving</td>
                                <td><span class="badge badge-info">{{$model->date_of_leaving}}</span></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Project</td>
                                <td><span class="badge badge-info">{{$model->project_id}}</span></td>
                                <td class="font-weight-bold">Location</td>
                                <td><span class="badge badge-info">{{$model->location_id}}</span></td>

                            </tr>
                            <tr>
                                <td class="font-weight-bold">Last Appraisal Date</td>
                                <td><span class="badge badge-info">{{$model->last_appraisal_date}}</span></td>
                                <td class="font-weight-bold">Reason for Leaving </td>
                                <td><span class="badge badge-info">{{$model->reason_for_leaving}}</span></td>

                            </tr>
                            <tr>
                                <td class="font-weight-bold">Reporting Authority </td>
                                <td><span class="badge badge-info">{{$model->reporting_authority_id}}</span></td>
                                <td class="font-weight-bold">Status</td>
                                <td><span class="badge badge-info">{{$model->status_id}}</span></td>
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
                                <td><span class="badge badge-info">{{$remunerat->salary_structure}}</span></td>
                                <td class="font-weight-bold">Esi Applicability</td>
                                <td><span class="badge badge-info">{{$remunerat->esi_applicability}}</span></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Pf Applicablity</td>
                                <td><span class="badge badge-info">{{$remunerat->pf_applicablity}}</span></td>
                                <td class="font-weight-bold">Restrict Pf</td>
                                <td><span class="badge badge-info">{{$remunerat->restrict_pf}}</span></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Basic</td>
                                <td><span class="badge badge-info">{{$remunerat->basic}}</span></td>
                                <td class="font-weight-bold">HRA</td>
                                <td><span class="badge badge-info">{{$remunerat->hra}}</span></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Splallowance</td>
                                <td><span class="badge badge-info">{{$remunerat->splallowance}}</span></td>
                                <td class="font-weight-bold">Dearness Allowance</td>
                                <td><span class="badge badge-info">{{$remunerat->Dearness_allowance}}</span></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Conveyance</td>
                                <td><span class="badge badge-info">{{$remunerat->conveyance}}</span></td>
                                <td class="font-weight-bold">Lta</td>
                                <td><span class="badge badge-info">{{$remunerat->lta}}</span></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Medical</td>
                                <td><span class="badge badge-info">{{$remunerat->medical}}</span></td>
                                <td class="font-weight-bold">Other Allowance</td>
                                <td><span class="badge badge-info">{{$remunerat->other_allowance}}</span></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Gross Salary</td>
                                <td><span class="badge badge-info">{{$remunerat->gross_salary}}</span></td>
                                <td class="font-weight-bold"></td>
                                <td><span class="badge badge-info"></span></td>
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
                                <td><span class="badge badge-info">{{$statue->esino}}</span></td>
                                <td class="font-weight-bold">ESI Dispensary</td>
                                <td><span class="badge badge-info">{{$statue->esidispensary}}</span></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">EPF No</td>
                                <td><span class="badge badge-info">{{$statue->epfno}}</span></td>
                                <td class="font-weight-bold">EPF UAN No</td>
                                <td><span class="badge badge-info">{{$statue->epfuanno}}</span></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Professional Tax</td>
                                <td><span class="badge badge-info">{{$statue->professionaltax}}</span></td>
                                <td class="font-weight-bold"></td>
                                <td><span class="badge badge-info"></span></td>
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
                                <td><span class="badge badge-info">{{$bank->bankname}}</span></td>
                                <td class="font-weight-bold">AC Number</td>
                                <td><span class="badge badge-info">{{$bank->acnumber}}</span></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Branch</td>
                                <td><span class="badge badge-info">{{$bank->branch}}</span></td>
                                <td class="font-weight-bold">IFSC</td>
                                <td><span class="badge badge-info">{{$bank->ifsc}}</span></td>
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
           
                <a  class="list-group-item" href="{{ url('/applicants') }}">Appointment Generate</a>
                <a  class="list-group-item" href="{{ url('/applicants') }}">Appointment Pdf</a>
                <a  class="list-group-item" href="{{ url('/applicants') }}">Annexure</a>
                <a  class="list-group-item" href="{{ url('/applicants') }}">Bonafide </a>
                <a  class="list-group-item" href="{{ url('/applicants') }}">Relieving Letter</a>
                <a  class="list-group-item" href="{{ url('/applicants') }}">Show Cause Notice</a>
                <a  class="list-group-item" href="{{ url('/applicants') }}">Employee Tracking</a>

           
        </div>
    </div>

</div>







@endsection