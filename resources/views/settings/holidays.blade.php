@extends('layouts.project')
@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fe fe-layers mr-2 fs-14"></i>Settings</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Full Calendar</a></li>
        </ol>
    </div>
</div>
@endsection
<!--Favicon 
<link rel="icon" href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/images/brand/favicon.ico" type="image/x-icon"/>-->

<!--Bootstrap css -->
<link
    href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/plugins/bootstrap/css/bootstrap.min.css"
    rel="stylesheet">

<!-- Style css 
<link href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/css/style.css" rel="stylesheet" />
<link href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/css/dark.css" rel="stylesheet" />
<link href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/css/skin-modes.css" rel="stylesheet" />-->

<!-- Animate css -->
<link href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/css/animated.css" rel="stylesheet" />

<!--Sidemenu css 
<link href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/css/sidemenu.css" rel="stylesheet">-->

<!-- P-scroll bar css
<link href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/plugins/p-scrollbar/p-scrollbar.css" rel="stylesheet" />-->

<!---Icons css-->
<link href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/css/icons.css" rel="stylesheet" />
<!-- INTERNAL Select2 css -->
<link href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/plugins/select2/select2.min.css"
    rel="stylesheet" />

<!-- INTERNAL Fullcalendar css-->
<link href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/plugins/fullcalendar/fullcalendar.css"
    rel='stylesheet' />
<link
    href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/plugins/fullcalendar/fullcalendar.print.min.css"
    rel='stylesheet' media='print' />

<!-- Simplebar css 
<link rel="stylesheet" href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/plugins/simplebar/css/simplebar.css">-->

<!-- Color Skin css
<link id="theme" href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/colors/color1.css" rel="stylesheet" type="text/css"/> -->

<!-- Switcher css 
<link rel="stylesheet" href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/switcher/css/switcher.css">
<link rel="stylesheet" href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/switcher/demo.css">-->

@section('content')

<div class="ml-1">
    @if ($errors->any())
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div class="mt-1 text-gray-600 dark:text-gray-400 text-sm">
        <form action="{{URL::current()}}" id='evoCalendar'>

        </form>
        <!-- App-Content -->
        <div class="app-content main-content">
            <div class="side-app">

                <!-- Row -->
                <div class="card">
                    <div class="row no-gutters">
                        <div class="col-lg-3">
                            <div class="card-body p-0">
                                <div class="card-header">
                                    <div class="card-title">Holiday List</div>
                                </div>
                                <div class="card-body">
                                    <nav class="nav main-nav-column main-nav-calendar-event">
                                        <a class="nav-link w-100 d-flex" href="">
                                            <div class="w-4 h-4 brround bg-primary mr-3"></div>
                                            <div>National Holiday</div>
                                        </a>
                                        <a class="nav-link w-100 d-flex" href="">
                                            <div class="w-4 h-4 brround bg-secondary mr-3"></div>
                                            <div>State Holiday</div>
                                        </a>
                                        <a class="nav-link w-100 d-flex" href="">
                                            <div class="w-4 h-4 brround bg-success mr-3"></div>
                                            <div>Weekly Off</div>
                                        </a>
                                    </nav>
                                    <div class="mt-5">
                                        <a class="btn btn-primary"
                                            href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/#"
                                            data-toggle="modal" data-target="#modalSetSchedule"><i
                                                class="fe fe-plus"></i> Add New Holiday</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="main-content-body main-content-body-calendar card-body border-left">
                                <div class="main-calendar" id="calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end app-content-->
        <!-- Modal -->
        <div aria-hidden="true" class="modal main-modal-calendar-schedule" id="modalSetSchedule" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">Create New Event</h6><button aria-label="Close" class="close"
                            data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form action="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/calendar"
                            id="mainFormCalendar" method="post" name="mainFormCalendar">
                            <div class="form-group">
                                <input class="form-control" placeholder="Add title" type="text">
                            </div>
                            <div class="form-group d-flex align-items-center">
                                <label class="custom-control custom-radio mr-4">
                                    <input type="radio" class="custom-control-input" name="example-radios"
                                        value="option1" checked>
                                    <span class="custom-control-label">Event</span>
                                </label>
                                <label class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="example-radios"
                                        value="option1">
                                    <span class="custom-control-label">Reminder</span>
                                </label>
                            </div>
                            <div class="form-group mg-t-30">
                                <label class="tx-13 mg-b-5 tx-gray-600">Start Date</label>
                                <div class="row row-xs">
                                    <div class="col-7">
                                        <input class="form-control" id="mainEventStartDate" placeholder="Select date"
                                            type="text" value="">
                                    </div><!-- col-7 -->
                                    <div class="col-5">
                                        <select class="select2 main-event-time" data-placeholder="Select time"
                                            id="mainEventStartTime">
                                            <option label="Select time">
                                                Select time
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="tx-13 mg-b-5 tx-gray-600">End Date</label>
                                <div class="row row-xs">
                                    <div class="col-7">
                                        <input class="form-control" id="EventEndDate" placeholder="Select date"
                                            type="text" value="">
                                    </div><!-- col-7 -->
                                    <div class="col-5">
                                        <select class="select2 main-event-time" data-placeholder="Select time"
                                            id="EventEndTime">
                                            <option label="Select time">
                                                Select time
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" placeholder="Write some description (optional)"
                                    rows="2"></textarea>
                            </div>
                            <div class="d-flex mg-t-15 mg-lg-t-30">
                                <button class="btn btn-primary mr-4" type="submit">Save</button>
                                <a class="btn btn-light" data-dismiss="modal" href="">Discard</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Modal -->
        <!-- Modal -->
        <div aria-hidden="true" class="modal main-modal-calendar-event" id="modalCalendarEvent" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <nav class="nav nav-modal-event">
                            <a class="nav-link" href="#"><i class="icon ion-md-open"></i></a>
                            <a class="nav-link" href="#"><i class="icon ion-md-trash"></i></a>
                            <a class="nav-link" data-dismiss="modal" href="#">
                                <i class="icon ion-md-close"></i></a>
                        </nav>
                    </div>
                    <div class="modal-body">
                        <div class="row row-sm">
                            <div class="col-sm-6">
                                <label class="tx-13 tx-gray-600 mg-b-2">Start Date</label>
                                <p class="event-start-date"></p>
                            </div>
                            <div class="col-sm-6">
                                <label class="tx-13 mg-b-2">End Date</label>
                                <p class="event-end-date"></p>
                            </div>
                        </div><label class="tx-13 tx-gray-600 mg-b-2">Description</label>
                        <p class="event-desc tx-gray-900 mg-b-30"></p><a class="btn btn-secondary wd-80"
                            data-dismiss="modal" href="">Close</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Modal -->
    </div>
    @endsection
    @push('scripts')
    <!-- Jquery js-->
    <script src="{{ asset('plugins/calender/jquery-3.5.2.min.js') }}"></script>
    <script src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/js/jquery-3.5.1.min.js"></script>

    <script src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/plugins/bootstrap/popper.min.js">
    </script>
    <script
        src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/plugins/bootstrap/js/bootstrap.min.js">
    </script>

    <!-- INTERNAL Full-calendar js-->
    <script
        src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/plugins/fullcalendar/moment.min.js">
    </script>
    <script
        src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/plugins/fullcalendar/fullcalendar.min.js">
    </script>
    <script src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/js/app-calendar-events.js">
    </script>
    <script src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/js/app-calendar.js"></script>

    <!-- Custom js-->
    <script src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/js/custom.js"></script>
    <!-- INTERNAL Select2 js -->
    <script
        src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/plugins/select2/select2.full.min.js">
    </script>
    <script src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/js/select2.js"></script>
    @endpush