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
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header" style="color: #31708f;background-color: #d9edf7; border-color: #bce8f1;">
                <h3 class="card-title">Employee Id: {{$model-> emp_code}}</h3>
                <!-- <div class="card-options">
                    <a href="https://laravel.spruko.com/admitro/Horizontal-Light/#" class="option-dots"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                            class="fe fe-more-horizontal fs-20"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="https://laravel.spruko.com/admitro/Horizontal-Light/#">Today</a>
                        <a class="dropdown-item" href="https://laravel.spruko.com/admitro/Horizontal-Light/#">Last
                            Week</a>
                        <a class="dropdown-item" href="https://laravel.spruko.com/admitro/Horizontal-Light/#">Last
                            Month</a>
                        <a class="dropdown-item" href="https://laravel.spruko.com/admitro/Horizontal-Light/#">Last
                            Year</a>
                    </div>
                </div>-->
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
                                <td class="font-weight-bold">Reason for Leaving	</td>
                                <td><span class="badge badge-info">{{$model->reason_for_leaving}}</span></td>
                               
                            </tr>
                            <tr>
                            <td class="font-weight-bold">Reporting Authority </td>
                                <td><span class="badge badge-info">{{$model->reporting_authority_id}}</span></td>
                                <td class="font-weight-bold">Status</td>
                                <td><span class="badge badge-info">{{$model->status_id}}</span></td>
                            </tr>
                           
                        </tbody>
                        <thead class="">
                            <tr>
                                <th colspan=4>General</th>

                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection