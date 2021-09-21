@extends('layouts.app')
@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-home mr-2 fs-14"></i>Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{url('/')}}">Dashboard</a></li>

        </ol>
    </div>
</div>
@endsection
<?php
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\EmpDetails;
// use DB;
error_reporting(0);

$employeecount = EmpDetails::count();

// current month & year
$today = date('Y-m-d');
$cdate = date('m');
$cyear = date('Y');
$cfirstdate = date('Y-m-d',strtotime($cyear."-".$cdate."-01")); 
$clastdate =  date('Y-m-d',strtotime($cyear."-".$cdate."-31")); 
$currentmonth = EmpDetails::whereBetween('date_of_joining', [$cfirstdate,  $clastdate])->count(); 
$currentmonthresigned = EmpDetails::where('status_id','7')->whereBetween('date_of_leaving', [$cfirstdate,  $clastdate])->count(); 
$todaypresent = Attendance::where('date',$today)->whereIn('status',['Present','Waiting for Punch'])->count(); 
$todayabsent = Attendance::where('date',$today)->where('status','Absent')->count(); 

$cyears = date('Y');
$cfirstdates = date('Y-m-d',strtotime($cyears."-01-01")); 
$clastdates =  date('Y-m-d',strtotime($cyears."-12-31")); 
$clastyear = EmpDetails::whereBetween('date_of_joining', [$cfirstdates,  $clastdates])->count(); 
$currentyearresigned = EmpDetails::where('status_id','7')->whereBetween('date_of_leaving', [$cfirstdates,  $clastdates])->count(); 


// end of current month & year 

// last month 
$date = date('m')-1;
$year = date('Y');
$firstdate = date('Y-m-d',strtotime($year."-".$date."-01")); 
$lastdate =  date('Y-m-d',strtotime($year."-".$date."-31")); 
$lastmonth = EmpDetails::whereBetween('date_of_joining', [$firstdate,  $lastdate])->count();
$lasttmonthresigned = EmpDetails::where('status_id','7')->whereBetween('date_of_leaving', [$firstdate,  $lastdate])->count(); 

// end of last month 
// last year 
$years = date('Y')-1;
$firstdates = date('Y-m-d',strtotime($years."-01-01")); 
$lastdates =  date('Y-m-d',strtotime($years."-12-31")); 
$lastyear = EmpDetails::whereBetween('date_of_joining', [$firstdates,  $lastdates])->count(); 
$lasttyearresigned = EmpDetails::where('status_id','7')->whereBetween('date_of_leaving', [$firstdates,  $lastdates])->count();        

// end of last year 

// $user_info = DB::table('emp_details')
//                  ->select('project_id', DB::raw('count(*) as total'))
//                  ->groupBy('project_id')
//                  ->get();
// foreach($user_info as $info){
//     echo $info->total;
// }

//SELECT count(*) as project, `project_id` FROM `emp_details` GROUP By `project_id` 

for($d=1; $d<=31; $d++)
{
    $time=mktime(12, 0, 0, $month, $d, $year);          
    if (date('m', $time)==$month)       
    $list[] = date('d', $time);
}

$first = current($list);
$last = end($list); 
$firstdate = $y."-".$day."-".$first;
//echo $firstdate;
$lastdate = $y."-".$day."-".$last;
//echo $lastdate;
 
?>
@section('content')
<div class="p-6">
    <div class="ml-1">
        <div class="mt-1 text-gray-600 dark:text-gray-400 text-sm">

            <!-- Row-1 -->
            <div class="row">
                <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
                    <div class="card overflow-hidden dash1-card ">
                        <div class="card-body">
                            <div class="d-flex align-items-end justify-content-between">
                                <div>
                                    <p class=" mb-1 fs-14">No of Employees</p>
                                    <h2 class="mb-0"><span class="number-font1">{{$employeecount}}</span>                                      
                                    </h2>
                                </div>
                                <span class="text-primary fs-35 dash1-iocns bg-primary-transparent border-primary"
                                    style="padding: 14px 14px; color: #ADCA00 !important; background-color: rgba(173, 202, 0, 0.2);border-color: #ADCA00 !important;"><i class="las la-users"></i></span>
                            </div>
                            <div class="d-flex mt-4">
                                <div>
                                    <span class="text-muted fs-12 mr-1">Last Month</span>
                                    <span class="number-font fs-12"><i
                                            class="fa fa-caret-up mr-1 text-success"></i>{{$lastmonth}}</span>
                                </div>
                                <div class="ml-auto">
                                    <span class="text-muted fs-12 mr-1">Last Year</span>
                                    <span class="number-font fs-12"><i
                                            class="fa fa-caret-down mr-1 text-success"></i>{{$lastyear}}</span>
                                </div>
                            </div>
                        </div>
                        <!-- <div id="spark1"></div> -->
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
                    <div class="card overflow-hidden dash1-card">
                        <div class="card-body">
                            <div class="d-flex align-items-end justify-content-between">
                                <div>
                                    <p class=" mb-1 fs-14">New Joining</p>
                                    <h2 class="mb-0"><span class="number-font1">{{$clastyear}}</span><span
                                            class="ml-2 text-muted fs-11"><span class="text-success"><i
                                                    class="fa fa-caret-up"></i> {{$currentmonth}}</span> this
                                            month</span></h2>
                                </div>
                                <span class="text-primary fs-35 dash1-iocns bg-primary-transparent border-primary"
                                    style="padding: 14px 14px; color: #FCCE44 !important; background-color: rgba(251, 206, 65, 0.2);border-color: #FCCE44 !important;"><i class="las la la-user-plus"></i></span>
                            </div>
                            <div class="d-flex mt-4">
                                <div>
                                    <span class="text-muted fs-12 mr-1">Last Month</span>
                                    <span class="number-font fs-12"><i
                                            class="fa fa-caret-up mr-1 text-success"></i>{{$lastmonth}}</span>
                                </div>
                                <div class="ml-auto">
                                    <span class="text-muted fs-12 mr-1">Last Year</span>
                                    <span class="number-font fs-12"><i
                                            class="fa fa-caret-down mr-1 text-success"></i>{{$lastyear}}</span>
                                </div>
                            </div>
                        </div>
                        <!-- <div id="spark2"></div> -->
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
                    <div class="card overflow-hidden dash1-card">
                        <div class="card-body">
                            <div class="d-flex align-items-end justify-content-between">
                                <div>
                                    <p class=" mb-1 fs-14">Resigned</p>
                                    <h2 class="mb-0"><span class="number-font1">{{$currentyearresigned}}</span><span
                                            class="ml-2 text-muted fs-11"><span class="text-success"><i
                                                    class="fa fa-caret-up"></i> {{$currentmonthresigned}}</span> this
                                            month</span></h2>
                                </div>
                                <span class="text-primary fs-35 dash1-iocns bg-primary-transparent border-primary"
                                    style="padding: 14px 14px; color: #AC437B !important; background-color: rgba(174, 69, 125, 0.2);border-color: #AC437B !important;"><i class="las la la-user-times"></i></span>
                            </div>
                            <div class="d-flex mt-4">
                                <div>
                                    <span class="text-muted fs-12 mr-1">Last Month</span>
                                    <span class="number-font fs-12"><i
                                            class="fa fa-caret-up mr-1 text-success"></i>{{$lasttmonthresigned}}</span>
                                </div>
                                <div class="ml-auto">
                                    <span class="text-muted fs-12 mr-1">Last Year</span>
                                    <span class="number-font fs-12"><i
                                            class="fa fa-caret-down mr-1 text-success"></i>{{$lasttyearresigned}}</span>
                                </div>
                            </div>
                        </div>
                        <!-- <div id="spark3"></div> -->
                    </div>
                </div>
            </div>
            <!-- End Row-1 -->
            <!-- Row-2 -->
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Attendance</h3>
                            <div class="card-options">
                                <div class="btn-group p-0">
                                    <button class="btn btn-outline-light btn-sm" type="button">Financial Year</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="echart1" class="chart-tasks chart-dropshadow text-center"></div>
                            <div class="text-center mt-2">
                                <span class="mr-4"><span class="dot-label bg-primary"></span>Total Present</span>
                                <span><span class="dot-label bg-secondary"></span>Total Absent</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4  col-md-12">
                    <div class="card">
                        <div class="card overflow-hidden dash1-card border-0">
                            <div class="card-body">
                                <p class=" mb-1 ">Present</p>
                                <h2 class="mb-1 number-font">{{$todaypresent}}</h2>
                                <small class="fs-12 text-muted">Today</small>
                                <span class="ratio bg-info">{{round($todaypresent*100/$employeecount)}}%</span>
                            </div>
                            <div class="d-flex">
                                <div class="ml-auto"><span class="text-success mr-1"><i
                                            class="fe fe-trending-up"></i></span><span
                                        class="number-font">{{$employeecount}}</span> </div>
                            </div>
                            <div class="progress h-2  mt-1">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-info"
                                    style="width: {{round($todaypresent*100/$employeecount)}}%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card overflow-hidden dash1-card border-0">
                            <div class="card-body">
                                <p class=" mb-1 ">Absent</p>
                                <h2 class="mb-1 number-font">{{$todayabsent}}</h2>
                                <small class="fs-12 text-muted">Today</small>
                                <span class="ratio bg-danger">{{round($todayabsent*100/$employeecount)}}%</span>
                            </div>
                            <div class="d-flex">
                                <div class="ml-auto"><span class="text-danger mr-1"><i
                                            class="fe fe-trending-down"></i></span><span
                                        class="number-font">{{$employeecount}}</span> </div>
                            </div>
                            <div class="progress h-2  mt-1">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger"
                                    style="width: {{round($todayabsent*100/$employeecount)}}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Row-2 -->
            <!-- Row-3 -->
            <div class="row">

            <div class="col-xl-4 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Projects</h3>                            
                        </div>
                        <div class="card-body">
                            <div class="latest-timeline scrollbar3" id="scrollbar3">
                                <ul class="timeline mb-0">
                                    <li class="mt-0">
                                        <div class="d-flex"><span class="time-data">Task Finished</span><span
                                                class="ml-auto text-muted fs-11">09 June 2020</span></div>
                                        <p class="text-muted fs-12"><span class="text-info">Joseph Ellison</span>
                                            finished task on<a
                                                href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/#"
                                                class="font-weight-semibold"> Project Management</a></p>
                                    </li>
                                    <li>
                                        <div class="d-flex"><span class="time-data">New Comment</span><span
                                                class="ml-auto text-muted fs-11">05 June 2020</span></div>
                                        <p class="text-muted fs-12"><span class="text-info">Elizabeth Scott</span>
                                            Product delivered<a
                                                href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/#"
                                                class="font-weight-semibold"> Service Management</a></p>
                                    </li>
                                    <li>
                                        <div class="d-flex"><span class="time-data">Target Completed</span><span
                                                class="ml-auto text-muted fs-11">01 June 2020</span></div>
                                        <p class="text-muted fs-12"><span class="text-info">Sonia Peters</span> finished
                                            target on<a
                                                href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/#"
                                                class="font-weight-semibold"> this month Sales</a></p>
                                    </li>
                                    <li>
                                        <div class="d-flex"><span class="time-data">Revenue Sources</span><span
                                                class="ml-auto text-muted fs-11">26 May 2020</span></div>
                                        <p class="text-muted fs-12"><span class="text-info">Justin Nash</span> source
                                            report on<a
                                                href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/#"
                                                class="font-weight-semibold"> Generated</a></p>
                                    </li>
                                    <li>
                                        <div class="d-flex"><span class="time-data">Dispatched Order</span><span
                                                class="ml-auto text-muted fs-11">22 May 2020</span></div>
                                        <p class="text-muted fs-12"><span class="text-info">Ella Lambert</span> ontime
                                            order delivery <a
                                                href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/#"
                                                class="font-weight-semibold">Service Management</a></p>
                                    </li>
                                    <li>
                                        <div class="d-flex"><span class="time-data">New User Added</span><span
                                                class="ml-auto text-muted fs-11">19 May 2020</span></div>
                                        <p class="text-muted fs-12"><span class="text-info">Nicola Blake</span> visit
                                            the site<a
                                                href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/#"
                                                class="font-weight-semibold"> Membership allocated</a></p>
                                    </li>
                                    <li>
                                        <div class="d-flex"><span class="time-data">Revenue Sources</span><span
                                                class="ml-auto text-muted fs-11">15 May 2020</span></div>
                                        <p class="text-muted fs-12"><span class="text-info">Richard Mills</span> source
                                            report on<a
                                                href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/#"
                                                class="font-weight-semibold"> Generated</a></p>
                                    </li>
                                    <li class="mb-0">
                                        <div class="d-flex"><span class="time-data">New Order Placed</span><span
                                                class="ml-auto text-muted fs-11">11 May 2020</span></div>
                                        <p class="text-muted fs-12"><span class="text-info">Steven Hart</span> is proces
                                            the order<a
                                                href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/#"
                                                class="font-weight-semibold"> #987</a></p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> 



                <div class="col-xl-4 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Recent Customers</h3>
                            <div class="card-options">
                                <a href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/#"
                                    class="option-dots" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"><i class="fe fe-more-horizontal fs-20"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item"
                                        href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/#">Today</a>
                                    <a class="dropdown-item"
                                        href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/#">Last
                                        Week</a>
                                    <a class="dropdown-item"
                                        href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/#">Last
                                        Month</a>
                                    <a class="dropdown-item"
                                        href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/#">Last
                                        Year</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="list-card">
                                <span class="bg-warning list-bar"></span>
                                <div class="row align-items-center">
                                    <div class="col-9 col-sm-9">
                                        <div class="media mt-0">
                                            <img src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/images/users/1.jpg"
                                                alt="img" class="avatar brround avatar-md mr-3">
                                            <div class="media-body">
                                                <div class="d-md-flex align-items-center mt-1">
                                                    <h6 class="mb-1">Lisa Marshall</h6>
                                                </div>
                                                <span class="mb-0 fs-13 text-muted">User ID:#2342<span
                                                        class="ml-2 text-success fs-13 font-weight-semibold">Paid</span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3 col-sm-3">
                                        <div class="text-right">
                                            <span class="font-weight-semibold fs-16 number-font">$558</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="list-card">
                                <span class="bg-info list-bar"></span>
                                <div class="row align-items-center">
                                    <div class="col-9 col-sm-9">
                                        <div class="media mt-0">
                                            <img src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/images/users/9.jpg"
                                                alt="img" class="avatar brround avatar-md mr-3">
                                            <div class="media-body">
                                                <div class="d-md-flex align-items-center mt-1">
                                                    <h6 class="mb-1">John Chapman</h6>
                                                </div>
                                                <span class="mb-0 fs-13 text-muted">User ID:#6720<span
                                                        class="ml-2 text-danger fs-13 font-weight-semibold">Pending</span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3 col-sm-3">
                                        <div class="text-right">
                                            <span class="font-weight-semibold fs-16 number-font">$458</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="list-card">
                                <span class="bg-danger list-bar"></span>
                                <div class="row align-items-center">
                                    <div class="col-9 col-sm-9">
                                        <div class="media mt-0">
                                            <img src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/images/users/2.jpg"
                                                alt="img" class="avatar brround avatar-md mr-3">
                                            <div class="media-body">
                                                <div class="d-md-flex align-items-center mt-1">
                                                    <h6 class="mb-1">Sonia Smith </h6>
                                                </div>
                                                <span class="mb-0 fs-13 text-muted">User ID:#8763<span
                                                        class="ml-2 text-success fs-13 font-weight-semibold">Paid</span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3 col-sm-3">
                                        <div class="text-right">
                                            <span class="font-weight-semibold fs-16 number-font">$358</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="list-card">
                                <span class="bg-success list-bar"></span>
                                <div class="row align-items-center">
                                    <div class="col-9 col-sm-9">
                                        <div class="media mt-0">
                                            <img src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/images/users/11.jpg"
                                                alt="img" class="avatar brround avatar-md mr-3">
                                            <div class="media-body">
                                                <div class="d-md-flex align-items-center mt-1">
                                                    <h6 class="mb-1">Joseph Abraham</h6>
                                                </div>
                                                <span class="mb-0 fs-13 text-muted">User ID:#1076<span
                                                        class="ml-2 text-danger fs-13 font-weight-semibold">Pending</span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3 col-sm-3">
                                        <div class="text-right">
                                            <span class="font-weight-semibold fs-16 number-font">$796</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="list-card">
                                <span class="bg-primary list-bar"></span>
                                <div class="row align-items-center">
                                    <div class="col-9 col-sm-9">
                                        <div class="media mt-0">
                                            <img src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/images/users/3.jpg"
                                                alt="img" class="avatar brround avatar-md mr-3">
                                            <div class="media-body">
                                                <div class="d-md-flex align-items-center mt-1">
                                                    <h6 class="mb-1">Joseph Abraham</h6>
                                                </div>
                                                <span class="mb-0 fs-13 text-muted">User ID:#986<span
                                                        class="ml-2 text-success fs-13 font-weight-semibold">Paid</span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3 col-sm-3">
                                        <div class="text-right">
                                            <span class="font-weight-semibold fs-16 number-font">$867</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4  col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Revenue by customers in Countries</h3>
                            <div class="card-options">
                                <a href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/#"
                                    class="option-dots" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"><i class="fe fe-more-horizontal fs-20"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item"
                                        href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/#">Today</a>
                                    <a class="dropdown-item"
                                        href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/#">Last
                                        Week</a>
                                    <a class="dropdown-item"
                                        href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/#">Last
                                        Month</a>
                                    <a class="dropdown-item"
                                        href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/#">Last
                                        Year</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="country-card">
                                <div class="mb-5">
                                    <div class="d-flex">
                                        <span class=""><img
                                                src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/images/flags/us.svg"
                                                class="w-5 h-5 mr-2" alt="">United States</span>
                                        <div class="ml-auto"><span class="text-success mr-1"><i
                                                    class="fe fe-trending-up"></i></span><span
                                                class="number-font">$45,870</span> (86%)</div>
                                    </div>
                                    <div class="progress h-2  mt-1">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-secondary"
                                            style="width: 80%"></div>
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <div class="d-flex">
                                        <span class=""><img
                                                src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/images/flags/in.svg"
                                                class="w-5 h-5 mr-2" alt="">India</span>
                                        <div class="ml-auto"><span class="text-danger mr-1"><i
                                                    class="fe fe-trending-down"></i></span><span
                                                class="number-font">$32,879</span> (65%)</div>
                                    </div>
                                    <div class="progress h-2  mt-1">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-info"
                                            style="width: 60%"></div>
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <div class="d-flex">
                                        <span class=""><img
                                                src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/images/flags/ru.svg"
                                                class="w-5 h-5 mr-2" alt="">Russia</span>
                                        <div class="ml-auto"><span class="text-success mr-1"><i
                                                    class="fe fe-trending-up"></i></span><span
                                                class="number-font">$22,710</span> (55%)</div>
                                    </div>
                                    <div class="progress h-2  mt-1">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                            style="width: 50%"></div>
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <div class="d-flex">
                                        <span class=""><img
                                                src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/images/flags/ca.svg"
                                                class="w-5 h-5 mr-2" alt="">Canada</span>
                                        <div class="ml-auto"><span class="text-danger mr-1"><i
                                                    class="fe fe-trending-down"></i></span><span
                                                class="number-font">$56,291</span> (69%)</div>
                                    </div>
                                    <div class="progress h-2  mt-1">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger"
                                            style="width: 80%"></div>
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <div class="d-flex">
                                        <span class=""><img
                                                src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/images/flags/ge.svg"
                                                class="w-5 h-5 mr-2" alt="">Germany</span>
                                        <div class="ml-auto"><span class="text-success mr-1"><i
                                                    class="fe fe-trending-up"></i></span><span
                                                class="number-font">$67,357</span> (73%)</div>
                                    </div>
                                    <div class="progress h-2  mt-1">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-teal"
                                            style="width: 70%"></div>
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <div class="d-flex">
                                        <span class=""><img
                                                src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/images/flags/br.svg"
                                                class="w-5 h-5 mr-2" alt="">Brazil</span>
                                        <div class="ml-auto"><span class="text-success mr-1"><i
                                                    class="fe fe-trending-up"></i></span><span
                                                class="number-font">$34,209</span> (60%)</div>
                                    </div>
                                    <div class="progress h-2  mt-1">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-indigo"
                                            style="width: 60%"></div>
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <div class="d-flex">
                                        <span class=""><img
                                                src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/images/flags/au.svg"
                                                class="w-5 h-5 mr-2" alt="">Australia</span>
                                        <div class="ml-auto"><span class="text-success mr-1"><i
                                                    class="fe fe-trending-up"></i></span><span
                                                class="number-font">$12,876</span> (46%)</div>
                                    </div>
                                    <div class="progress h-2  mt-1">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                            style="width: 40%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> 
            <!-- End Row-3 -->

        </div>
    </div>
</div>
@endsection

@push('scripts')

@endpush