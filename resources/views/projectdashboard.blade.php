@extends('layouts.project')

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
error_reporting(0);
$today = date('Y-m-d'); 
  $emp = App\Models\EmpDetails::where(['project_id' => auth()->user()->project_id])->count();
  $project = App\Models\EmpDetails::where(['project_id' => auth()->user()->project_id])->first();
  $present = App\Models\Attendance::where([
      ['project_id', '=', auth()->user()->project_id],
      ['date','=', $today],
      ['status','<>', 'Absent']
  ])->count();
  $absent = App\Models\Attendance::where([
    ['project_id', '=', auth()->user()->project_id],
    ['date','=', $today],
    ['status','=', 'Absent']
])->count();
  //$leave = App\Models\Leave::where(['emp_id' => auth()->user()->emp_id])->orderBy('id', 'desc')->first();

?>
@section('content')
<div class="p-6">
    <div class="ml-1">
        <div class="mt-1 text-gray-600 dark:text-gray-400 text-sm">
            <div class="row">                

                <div class="col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Project</h3>
                        </div>
                        <div class="card-body pl-5 pr-5">
                            <ul class="list-group">
                                <li class="listunorder"> Project : <b>{{$project->project->project_name}}</b></li>
                                <li class="listunorder"> Location : <b>{{($project->locations->location) ? $project->location->location:''}}</b></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Employee</h3>
                        </div>
                        <div class="card-body pl-5 pr-5">
                            <ul class="list-group">
                                <li class="listunorder"> Total Employee : <b>{{$emp}}</b></li>
                                <li class="listunorder"> Total Present : <b>{{$present}}</b></li>
                                <li class="listunorder"> Total Absent : <b>{{$absent}}</b></li>
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