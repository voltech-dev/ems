@extends('layouts.emp')

@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Dashboard</a></li>
        </ol>
    </div>
</div>
@endsection
<?php
  $emp = App\Models\EmpDetails::where(['id' => auth()->user()->emp_id])->first();
  $atts = App\Models\Attendance::where(['emp_id' => auth()->user()->emp_id])->orderBy('id', 'desc')->take(3)->get();
  $leave = App\Models\Leave::where(['emp_id' => auth()->user()->emp_id])->orderBy('id', 'desc')->first();

?>
@section('content')
<div class="p-6">
    <div class="ml-1">
        <div class="mt-1 text-gray-600 dark:text-gray-400 text-sm">
            <div class="row">
                <div class="col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Profile</h3>
                        </div>
                        <div class="card-body pl-5 pr-5">
                            <ul class="list-group">
                                <li class="listunorder"> Name : <b>{{$emp->emp_name}}</b></li>
                                <li class="listunorder">Designation : <b>{{$emp->designation->designation_name}} </b></li>
                                <li class="listunorder"> Project : <b>{{ucfirst($emp->project->project_name)}}</b></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Attendance</h3>
                        </div>
                        <div class="card-body pl-5 pr-5">
                            <ul class="list-group">
                            @foreach($atts as $att)
                            <li class="listunorder"> {{date('d-m-Y',strtotime($att->date))}} : <b>{{$att->status}}</b></li>
                            @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Leave Details</h3>
                        </div>
                        <div class="card-body pl-5 pr-5">
                            <ul class="list-group">
                            <li class="listunorder"> Last Leave Taken: {{date('d-m-Y',strtotime($leave->date_from))}} : <b>{{$leave->action}}</b></li>
                            <li class="listunorder"> Balance Leave :<b> 5</b></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

@endpush