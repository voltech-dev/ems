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
      ['status','=', 'Present']
  ])->count();
  $absent = App\Models\Attendance::where([
    ['project_id', '=', auth()->user()->project_id],
    ['date','=', $today],
    ['status','=', 'Absent']
])->count();
$outtime = App\Models\Attendance::where([
    ['project_id', '=', auth()->user()->project_id],
    ['date','=', $today]])
    ->whereNull('out_time')
  ->count();
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
                                <li class="listunorder"> Location :
                                    <b>{{($project->locations->location) ? $project->location->location:''}}</b></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Attendance</h3>
                        </div>
                        <div class="card-header">
                            <h6>Total Emp: {{$emp}}</h6> &nbsp;&nbsp;&nbsp;<h6>Total Punch-In: {{$present}}</h6>
                            &nbsp;&nbsp;&nbsp;<h6>Total Punch-Out: {{$outtime}}</h6>&nbsp;&nbsp;&nbsp;<h6>Total Absent:
                                {{$absent}}</h6>
                        </div>
                        <div class="card-body pl-5 pr-5">
                            <div class="text-center">
                                <div class="row">
                                    <div class="col-lg-12">
                                        
                                        <div  style="width: 100%; height: 100%; float: center">
                                            <div id="chart5"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!--  <ul class="list-group">
                                <li class="listunorder"> Total Employee : <b>{{$emp}}</b></li>
                                <li class="listunorder"> Total Present : <b>{{$present}}</b></li> 
                                <li class="listunorder"> Total Absent : <b>{{$absent}}</b></li>
                                <li class="listunorder"> Total Punch-In : <b>{{$absent}}</b></li>
                                <li class="listunorder"> Total Punch-Out : <b>{{$absent}}</b></li>
                            </ul>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
var options5 = {
	series: [{{$present}},{{$outtime}},{{$absent}}],
	colors: ['#705ec8', '#fa057a',  '#2dce89'],
	chart: {
		height: 200,
		type: 'pie',
	},
	labels: ['Total Punch-In', 'Total Punch-Out', 'Total Absent'],
	legend: {
		show: false,
	},
	responsive: [{
		breakpoint: 480,
		options: {
			chart: {
				width: 500
			},
			legend: {
				show: false,
				position: 'bottom'
			}
		}
	}]
};
var chart5 = new ApexCharts(document.querySelector("#chart5"), options5);
chart5.render();
</script>
@endpush