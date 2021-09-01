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
      ['in_time','<>', 'NULL']
  ])->count();
  $absent = App\Models\Attendance::where([
    ['project_id', '=', auth()->user()->project_id],
    ['date','=', $today],
    ['status','=', 'Absent']
])->count();
  $wait = App\Models\Attendance::where([
    ['project_id', '=', auth()->user()->project_id],
    ['date','=', $today],
    ['status','=', 'Waiting for Punch']
])->count();
$outtime = App\Models\Attendance::where([
    ['project_id', '=', auth()->user()->project_id],
    ['date','=', $today]]) 
    ->whereNull('out_time')
  ->count();
  //$leave = App\Models\Leave::where(['emp_id' => auth()->user()->emp_id])->orderBy('id', 'desc')->first();
  $absentiesname = DB::table('emp_attendance')
  ->select('emp_details.emp_name','emp_details.emp_code')
  ->join('emp_details','emp_details.id','=','emp_attendance.emp_id')
  ->where('emp_attendance.project_id','=', auth()->user()->project_id)
  ->where('emp_attendance.date','=',$today)
  ->where('emp_attendance.status','=','Absent')
  ->get();
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
                                    <b>{{($project->locations->location) ? $project->locations->location:''}}</b></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Absent</h3>
                        </div>
                        <div class="card-body pl-5 pr-5">
                            <ul class="list-group">
                            <h3 class="card-title">Names : </h3>
                            @foreach($absentiesname as $abs)
                                <li class="listunorder"><b>{{$abs->emp_code}}-{{$abs->emp_name}}</b></br></li>
                            @endforeach 
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
                            <h6>Total Emp: {{$emp}}</h6> &nbsp;&nbsp;&nbsp;<h6>Total Present: {{$present}}</h6>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<h6>Total Absent:
                                {{$absent}}</h6>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <div class="row">
                                    <div class="col">
                                        
                                        <div  style="width: 100%; height: 100%; float: center">
                                            <div id="piechart"></div>
                                        </div>
                                    </div>
                                </div>
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
var piechart = {
	series: [{{$present}},{{$absent}}],
	colors: ['#B0CE0C',  '#F5CC56'],
	chart: {
		height: 200,
		type: 'pie',
	},
	labels: ['Present', 'Absent'],
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
var chart = new ApexCharts(document.querySelector("#piechart"), piechart);
chart.render();
</script>
@endpush