<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'VOLTECH') }}</title>

    <!-- bala insert -->
    <!--Favicon -->
    <link rel="icon" href="{{ asset('images/brand/favicon.png') }}" type="image/x-icon" />


    <!-- Style css -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/dark.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/skin-modes.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/pay.css') }}" rel="stylesheet" />

    <!-- Animate css -->
    <link href="{{ asset('css/animated.css') }}" rel="stylesheet" />

    <!-- P-scroll bar css-->
    <link href="{{ asset('plugins/p-scrollbar/p-scrollbar.css') }}" rel="stylesheet" />

    <!---Icons css-->
    <link href="{{ asset('css/icons.css') }}" rel="stylesheet" />

    <!-- Simplebar css -->
    <link rel="stylesheet" href="{{ asset('plugins/simplebar/css/simplebar.css') }}">

    <!-- Color Skin css -->
    <link id="theme" href="{{ asset('colors/color1.css') }}" rel="stylesheet" type="text/css" />

    <!-- Switcher css 
    <link rel="stylesheet" href="{{ asset('switcher/css/switcher.css') }}">
    <link rel="stylesheet" href="{{ asset('switcher/demo.css') }}">
   <link rel="stylesheet" href="{{ asset('css/app.css') }}"> -->

    <!-- Data table css -->
    <link href="{{ asset('plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/datatable/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <!-- INTERNAL File Uploads css -->
    <link href="{{ asset('plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />

    <!-- INTERNAL Time picker css -->
    <link href="{{ asset('plugins/time-picker/jquery.timepicker.css') }}" rel="stylesheet" />

    <!-- INTERNAL Date Picker css -->
    <link href="{{ asset('plugins/date-picker/date-picker.css') }}" rel="stylesheet" />

    <!-- select2 css -->
    <link href="{{ asset('plugins/select2/select2.min.css') }}" rel="stylesheet" />


    <!-- INTERNAL File Uploads css-->
    <link href="{{ asset('plugins/fileupload/css/fileupload.css') }}" rel="stylesheet" type="text/css" />

    <!-- bala insert end -->

</head>

<body class="app main-body">
    <!---Global-loader-->
    <div id="global-loader">
        <img src="{{ asset('images/svgs/loader.svg') }}" alt="loader">
    </div>
    <!--- End Global-loader-->

    <!-- Page -->
    <div class="page">
        <div class="page-main">

            <!--header-->
            <div class="hor-header bg-white top-header stripimg">
                <div class="container">
                    <div class="d-flex">
                        <a class="animated-arrow hor-toggle horizontal-navtoggle"><span></span></a>
                        <a class="header-brand" href="#">
                            <img src="{{ asset('images/logo.png') }}" class="header-brand-img desktop-lgo" alt="logo">
                            <img src="{{ asset('images/brand/logo1.png') }}" class="header-brand-img dark-logo"
                                alt=" logo">
                            <img src="{{ asset('images/brand/favicon.png') }}" class="header-brand-img mobile-logo"
                                alt=" logo">
                            <img src="{{ asset('images/brand/favicon1.png') }}" class="header-brand-img darkmobile-logo"
                                alt=" logo">
                        </a>
                        <div class="mt-1">
                            <form class="form-inline">
                                <div class="search-element">
                                    <!--<input type="search" class="form-control header-search" placeholder="Search…" aria-label="Search" tabindex="1">
										<button class="btn btn-primary-color" type="submit">
											<svg class="header-icon search-icon" x="1008" y="1248" viewBox="0 0 24 24"  height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
												<path d="M0 0h24v24H0V0z" fill="none"/><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
											</svg>
										</button>-->
                                </div>
                            </form>
                        </div>

                        <!-- SEARCH -->
                        <div class="d-flex order-lg-2 ml-auto">
                            <a href="#" data-toggle="search" class="nav-link nav-link-lg d-md-none navsearch">
                                <svg class="header-icon search-icon" x="1008" y="1248" viewBox="0 0 24 24" height="100%"
                                    width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
                                    <path d="M0 0h24v24H0V0z" fill="none" />
                                    <path
                                        d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                                </svg>
                            </a>
                            <div class="dropdown   header-fullscreen">
                                <a class="nav-link icon full-screen-link p-0" id="fullscreen-button">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="header-icon" width="24" height="24"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M10 4L8 4 8 8 4 8 4 10 10 10zM8 20L10 20 10 14 4 14 4 16 8 16zM20 14L14 14 14 20 16 20 16 16 20 16zM20 8L16 8 16 4 14 4 14 10 20 10z" />
                                    </svg>
                                </a>
                            </div>

                            <div class="dropdown profile-dropdown">
                                <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">

                                    <button class="border-transparent rounded-circle bg-white">
                                        <img class="h-7 w-7 rounded-circle " src="{{ Auth::user()->profile_photo_url }}"
                                            alt="{{ Auth::user()->name }}" />
                                    </button>

                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow animated">
                                    <div class="text-center">
                                        <a href="#"
                                            class="dropdown-item text-center user pb-0 font-weight-bold">{{auth()->user()->name}}</a>
                                        <span class="text-center user-semi-title"></span>
                                        <div class="dropdown-divider"></div>
                                    </div>
                                    <!-- <a class="dropdown-item d-flex" href="{{ url('site/profile') }}">
                                        <svg class="header-icon mr-3" xmlns="http://www.w3.org/2000/svg" height="24"
                                            viewBox="0 0 24 24" width="24">
                                            <path d="M0 0h24v24H0V0z" fill="none" />
                                            <path
                                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zM7.07 18.28c.43-.9 3.05-1.78 4.93-1.78s4.51.88 4.93 1.78C15.57 19.36 13.86 20 12 20s-3.57-.64-4.93-1.72zm11.29-1.45c-1.43-1.74-4.9-2.33-6.36-2.33s-4.93.59-6.36 2.33C4.62 15.49 4 13.82 4 12c0-4.41 3.59-8 8-8s8 3.59 8 8c0 1.82-.62 3.49-1.64 4.83zM12 6c-1.94 0-3.5 1.56-3.5 3.5S10.06 13 12 13s3.5-1.56 3.5-3.5S13.94 6 12 6zm0 5c-.83 0-1.5-.67-1.5-1.5S11.17 8 12 8s1.5.67 1.5 1.5S12.83 11 12 11z" />
                                        </svg>
                                        <div class=""> 
                                          Profile 
                                        </div>
                                    </a>-->
                                    <!--<a class="dropdown-item d-flex" href="#">
											<svg class="header-icon mr-3" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19.43 12.98c.04-.32.07-.64.07-.98 0-.34-.03-.66-.07-.98l2.11-1.65c.19-.15.24-.42.12-.64l-2-3.46c-.09-.16-.26-.25-.44-.25-.06 0-.12.01-.17.03l-2.49 1c-.52-.4-1.08-.73-1.69-.98l-.38-2.65C14.46 2.18 14.25 2 14 2h-4c-.25 0-.46.18-.49.42l-.38 2.65c-.61.25-1.17.59-1.69.98l-2.49-1c-.06-.02-.12-.03-.18-.03-.17 0-.34.09-.43.25l-2 3.46c-.13.22-.07.49.12.64l2.11 1.65c-.04.32-.07.65-.07.98 0 .33.03.66.07.98l-2.11 1.65c-.19.15-.24.42-.12.64l2 3.46c.09.16.26.25.44.25.06 0 .12-.01.17-.03l2.49-1c.52.4 1.08.73 1.69.98l.38 2.65c.03.24.24.42.49.42h4c.25 0 .46-.18.49-.42l.38-2.65c.61-.25 1.17-.59 1.69-.98l2.49 1c.06.02.12.03.18.03.17 0 .34-.09.43-.25l2-3.46c.12-.22.07-.49-.12-.64l-2.11-1.65zm-1.98-1.71c.04.31.05.52.05.73 0 .21-.02.43-.05.73l-.14 1.13.89.7 1.08.84-.7 1.21-1.27-.51-1.04-.42-.9.68c-.43.32-.84.56-1.25.73l-1.06.43-.16 1.13-.2 1.35h-1.4l-.19-1.35-.16-1.13-1.06-.43c-.43-.18-.83-.41-1.23-.71l-.91-.7-1.06.43-1.27.51-.7-1.21 1.08-.84.89-.7-.14-1.13c-.03-.31-.05-.54-.05-.74s.02-.43.05-.73l.14-1.13-.89-.7-1.08-.84.7-1.21 1.27.51 1.04.42.9-.68c.43-.32.84-.56 1.25-.73l1.06-.43.16-1.13.2-1.35h1.39l.19 1.35.16 1.13 1.06.43c.43.18.83.41 1.23.71l.91.7 1.06-.43 1.27-.51.7 1.21-1.07.85-.89.7.14 1.13zM12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 6c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/></svg>
											<div class="">Settings</div>
										</a>
										<a class="dropdown-item d-flex" href="#">
											<svg class="header-icon mr-3" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M4 4h16v12H5.17L4 17.17V4m0-2c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2H4zm2 10h12v2H6v-2zm0-3h12v2H6V9zm0-3h12v2H6V6z"/></svg>
											<div class="">Messages</div>
										</a> -->

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <a class="dropdown-item d-flex" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                            this.closest('form').submit();">

                                            <svg class="header-icon mr-3" xmlns="http://www.w3.org/2000/svg"
                                                enable-background="new 0 0 24 24" height="24" viewBox="0 0 24 24"
                                                width="24">
                                                <g>
                                                    <rect fill="none" height="24" width="24" />
                                                </g>
                                                <g>
                                                    <path
                                                        d="M11,7L9.6,8.4l2.6,2.6H2v2h10.2l-2.6,2.6L11,17l5-5L11,7z M20,19h-8v2h8c1.1,0,2-0.9,2-2V5c0-1.1-0.9-2-2-2h-8v2h8V19z" />
                                                </g>
                                            </svg>
                                            <div class="">Sign Out</div>
                                        </a>
                                    </form>


                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!--/header-->
            <!--/Horizontal-main -->
            <div class="sticky">
                <div class="horizontal-main hor-menu clearfix">
                    <div class="horizontal-mainwrapper container clearfix">
                        <!--Nav-->
                        <nav class="horizontalMenu clearfix">
                            <ul class="horizontalMenu-list">
                                <li aria-haspopup="true">
                                    <a href="{{ url('/') }}" class="sub-icon">
                                        <svg class="hor-icon" xmlns="http://www.w3.org/2000/svg" height="24"
                                            viewBox="0 0 24 24" width="24">
                                            <path d="M0 0h24v24H0V0z" fill="none" />
                                            <path
                                                d="M19 5v2h-4V5h4M9 5v6H5V5h4m10 8v6h-4v-6h4M9 17v2H5v-2h4M21 3h-8v6h8V3zM11 3H3v10h8V3zm10 8h-8v10h8V11zm-10 4H3v6h8v-6z" />
                                        </svg>
                                        Dashboard
                                    </a>
                                </li>
                                <li aria-haspopup="true">
                                    <a href="{{ url('/empdetails') }}" class="">
                                        <svg class="hor-icon" xmlns="http://www.w3.org/2000/svg" height="24"
                                            viewBox="0 0 24 24" width="24">
                                            <path d="M0 0h24v24H0V0z" fill="none" />
                                            <path
                                                d="M16.66 4.52l2.83 2.83-2.83 2.83-2.83-2.83 2.83-2.83M9 5v4H5V5h4m10 10v4h-4v-4h4M9 15v4H5v-4h4m7.66-13.31L11 7.34 16.66 13l5.66-5.66-5.66-5.65zM11 3H3v8h8V3zm10 10h-8v8h8v-8zm-10 0H3v8h8v-8z" />
                                        </svg>
                                        MIS
                                    </a>

                                    <ul class="sub-menu">
                                        <li aria-haspopup="true"><a href="{{ url('/empdetails') }}"
                                                class="slide-item">Employee MIS</a></li>
                                        <li aria-haspopup="true"><a href="{{url('/ImportEmployee')}}"
                                                class="slide-item">
                                                Employee Import</a></li>
                                        <li aria-haspopup="true"><a href="{{url('/checklistexport')}}"
                                                class="slide-item">
                                                CheckList Export</a></li>
                                    </ul>
                                </li>
                                <li aria-haspopup="true">
                                    <a href="{{ url('/empsalary') }}" class="sub-icon">
                                        <svg class="hor-icon" xmlns="http://www.w3.org/2000/svg" height="24"
                                            viewBox="0 0 24 24" width="24">
                                            <path d="M0 0h24v24H0V0z" fill="none" />
                                            <path
                                                d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM7 10h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z" />
                                        </svg>
                                        Payroll
                                    </a>

                                    <ul class="sub-menu">
                                        <!-- <li aria-haspopup="true"><a href="{{ url('/empsalary') }}"
                                                class="slide-item">Payslip</a></li> -->
                                        <li aria-haspopup="true"><a href="{{ url('/generate') }}"
                                                class="slide-item">Generate Salary
                                            </a></li>
                                        <!-- <li aria-haspopup="true"><a href="{{ url('/') }}"
                                                class="slide-item">Payslip</a></li> -->
                                        <li aria-haspopup="true"><a href="{{ url('/mailindex') }}"
                                                class="slide-item">Payslip Mail</a></li>
                                    </ul>
                                </li>

                                <li aria-haspopup="true">
                                    <a href="{{ url('/superuser_attendance') }}" class="sub-icon">
                                        <svg class="hor-icon" xmlns="http://www.w3.org/2000/svg" height="20"
                                            viewBox="0 0 20 20" width="20">
                                            <path d="M0 0h24v24H0V0z" fill="none" />
                                            <path
                                                d="M19 15v4H5v-4h14m1-2H4c-.55 0-1 .45-1 1v6c0 .55.45 1 1 1h16c.55 0 1-.45 1-1v-6c0-.55-.45-1-1-1zM7 18.5c-.82 0-1.5-.67-1.5-1.5s.68-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM19 5v4H5V5h14m1-2H4c-.55 0-1 .45-1 1v6c0 .55.45 1 1 1h16c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1zM7 8.5c-.82 0-1.5-.67-1.5-1.5S6.18 5.5 7 5.5s1.5.68 1.5 1.5S7.83 8.5 7 8.5z" />
                                        </svg>
                                        Attendance
                                    </a>
                                    <ul class="sub-menu">
                                        <li aria-haspopup="true"><a href="{{ url('/todayattendance') }}"
                                                class="slide-item">Today Attendance</a></li>
                                        <li aria-haspopup="true"><a href="{{ url('/superuser_attendance') }}"
                                                class="slide-item">Attendance</a></li>
                                        <li aria-haspopup="true"><a href="{{ url('/leavebalance') }}"
                                                class="slide-item">Leave Balance</a></li>
                                        <li aria-haspopup="true"><a href="{{ url('/musterroll') }}"
                                                class="slide-item">Monthly Attendance</a></li>
                                        <li aria-haspopup="true"><a href="{{ url('/leavebalancetemplate') }}"
                                                class="slide-item">Leave Balance Template</a></li>
                                    </ul>
                                </li>

                                <!-- <li aria-haspopup="true">
                                    <a href="#" class="sub-icon">
                                        <svg class="hor-icon" xmlns="http://www.w3.org/2000/svg" height="24"
                                            viewBox="0 0 24 24" width="24">
                                            <path d="M0 0h24v24H0V0z" fill="none" />
                                            <path
                                                d="M4 5h3l2-2h6l2 2h3a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2zm12 12v-1c0-1.332-2.667-2-4-2-1.333 0-4 .668-4 2v1h8zm-4-8a2.001 2.001 0 0 0 0 4 2.001 2.001 0 0 0 0-4z" />
                                        </svg>
                                        Recruitment
                                    </a>
                                </li> -->
                                <li aria-haspopup="true">
                                    <a href="{{url('/grievancelist')}}" class="sub-icon">
                                        <svg class="hor-icon" xmlns="http://www.w3.org/2000/svg" height="24"
                                            viewBox="0 0 24 24" width="24">
                                            <path d="M0 0h24v24H0V0z" fill="none" />
                                            <path
                                                d="M4 5h3l2-2h6l2 2h3a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2zm12 12v-1c0-1.332-2.667-2-4-2-1.333 0-4 .668-4 2v1h8zm-4-8a2.001 2.001 0 0 0 0 4 2.001 2.001 0 0 0 0-4z" />
                                        </svg>
                                        HR Support
                                    </a>
                                </li>


                                <li aria-haspopup="true">
                                    <a href="#" class="sub-icon">
                                        <svg class="hor-icon" xmlns="http://www.w3.org/2000/svg" height="24"
                                            viewBox="0 0 24 24" width="24">
                                            <path d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M12 22C6.49 22 2 17.51 2 12S6.49 2 12 2s10 4.04 10 9c0 3.31-2.69 6-6 6h-1.77c-.28 0-.5.22-.5.5 0 .12.05.23.13.33.41.47.64 1.06.64 1.67 0 1.38-1.12 2.5-2.5 2.5zm0-18c-4.41 0-8 3.59-8 8s3.59 8 8 8c.28 0 .5-.22.5-.5 0-.16-.08-.28-.14-.35-.41-.46-.63-1.05-.63-1.65 0-1.38 1.12-2.5 2.5-2.5H16c2.21 0 4-1.79 4-4 0-3.86-3.59-7-8-7z" />
                                            <circle cx="6.5" cy="11.5" r="1.5" />
                                            <circle cx="9.5" cy="7.5" r="1.5" />
                                            <circle cx="14.5" cy="7.5" r="1.5" />
                                            <circle cx="17.5" cy="11.5" r="1.5" />
                                        </svg>
                                        Settings
                                    </a>
                                    <ul class="sub-menu">
                                        <li aria-haspopup="true"><a href="{{ url('/Project/projectlist') }}"
                                                class="slide-item">Project</a></li>
                                        <li aria-haspopup="true"><a href="{{ url('/Department/departmentlist') }}"
                                                class="slide-item">Department</a></li>
                                        <li aria-haspopup="true"><a href="{{ url('/Designations/designationlist') }}"
                                                class="slide-item">Designation</a></li>
                                        <li aria-haspopup="true"><a href="{{url('/Location/locationlist')}}"
                                                class="slide-item">
                                                Location</a></li>
                                        <li aria-haspopup="true"><a href="{{ url('/Project/statuslist') }}"
                                                class="slide-item">Status
                                            </a></li>
                                        <li aria-haspopup="true"><a href="{{ url('/holidays') }}"
                                                class="slide-item">Holidays
                                            </a></li>
                                        <li aria-haspopup="true"><a href="{{ url('/pf') }}" class="slide-item">PF
                                            </a></li>
                                        <li aria-haspopup="true"><a href="{{ url('/esi') }}" class="slide-item">ESI
                                            </a></li>
                                        <li aria-haspopup="true"><a href="{{ url('/qualificationlist') }}"
                                                class="slide-item">Qualification
                                            </a></li>
                                        <li aria-haspopup="true"><a href="{{ url('/Documents/doc_addition') }}"
                                                class="slide-item">Document Addition
                                            </a></li>
                                        <li aria-haspopup="true"><a href="{{url('/salarymonth')}}" class="slide-item">
                                                Salary Month</a></li>
                                        <li aria-haspopup="true"><a href="{{ url('/salaryupload') }}"
                                                class="slide-item">Template
                                            </a></li>
                                        <li aria-haspopup="true"><a href="{{ url('/appraisalupload') }}"
                                                class="slide-item">Appraisal Template
                                            </a></li>
                                    </ul>
                                </li>
                                <li aria-haspopup="true">
                                    <a href="#" class="sub-icon">
                                        <svg class="hor-icon" xmlns="http://www.w3.org/2000/svg" height="24"
                                            viewBox="0 0 24 24" width="24">
                                            <path d="M0 0h24v24H0V0z" fill="none" />
                                            <path
                                                d="M8 16h8v2H8zm0-4h8v2H8zm6-10H6c-1.1 0-2 .9-2 2v16c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11z" />
                                        </svg>
                                        Report
                                    </a>
                                    <ul class="sub-menu">
                                        <li aria-haspopup="true"><a href="#" class="slide-item">Salary</a>
                                            <ul class="sub-menu">
                                                <li aria-haspopup="true"><a
                                                        href="{{ url('/empsalarystatement') }}"
                                                        class="slide-item">Salary Statement</a></li>
                                                        <li aria-haspopup="true"><a
                                                        href="#"
                                                        class="slide-item">EPF Remittance</a></li>
                                                        <li aria-haspopup="true"><a
                                                        href="#"
                                                        class="slide-item">ESI </a></li>
                                                        <li aria-haspopup="true"><a
                                                        href="#"
                                                        class="slide-item">Bank Remittance</a></li>
                                            </ul>
                                        </li>
                                        
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                        <!--Nav-->
                    </div>
                </div>
            </div>

            <div class="hor-content main-content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card ">
                                <div class="card-header">
                                    @yield('header')
                                </div>
                                <div class="card-body">
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Footer-->
        <footer class="footer main-footer">
            <div class="container">
                <div class="row align-items-center flex-row-reverse">
                    <div class="col-md-12 col-sm-12 text-center">
                        Copyright © 2020 <a href="http://voltechgroup.com/">Voltechgroup</a>. Developed by <a
                            href="http://voltechgroup.com/">TeamERP</a> All rights reserved.
                    </div>
                </div>
            </div>
        </footer>
        <!-- End Footer-->
    </div><!-- End Page -->
    <!-- Back to top -->
    <a href="#top" id="back-to-top"><i class="fe fe-chevrons-up"></i></a>

    <!-- Jquery js-->
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <!--Othercharts js-->
    <script src="{{ asset('plugins/othercharts/jquery.sparkline.min.js') }}"></script>
    <!--INTERNAL Apexchart js-->
    <script src="{{ asset('js/apexcharts.js') }}"></script>

    <!-- Bootstrap4 js-->
    <script src="{{ asset('plugins/bootstrap/popper.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>

    <!--Othercharts js-->
    <script src="{{ asset('plugins/othercharts/jquery.sparkline.min.js') }}"></script>

    <!-- Circle-progress js-->
    <script src="{{ asset('js/circle-progress.min.js') }}"></script>

    <!-- Jquery-rating js-->
    <script src="{{ asset('plugins/rating/jquery.rating-stars.js') }}"></script>

    <!--Horizontal-menu js-->
    <script src="{{ asset('plugins/horizontal-menu/horizontal-menu.js') }}"></script>

    <!-- P-scroll js-->
    <script src="{{ asset('plugins/p-scrollbar/p-scrollbar.js') }}"></script>
    <script src="{{ asset('plugins/p-scrollbar/p-scroll.js') }}"></script>

    <!--INTERNAL ECharts js-->
    <script src="{{ asset('plugins/echarts/echarts.js') }}"></script>

    <!--INTERNAL Index js-->
    <script src="{{ asset('js/index1.js') }}"></script>

    <!-- stiky js-->
    <script src="{{ asset('js/stiky.js') }}"></script>

    <!-- Simplebar JS -->
    <script src="{{ asset('plugins/simplebar/js/simplebar.min.js') }}"></script>

    <!-- INTERNAL Timepicker js -->
    <script src="{{ asset('plugins/time-picker/jquery.timepicker.js') }}"></script>
    <script src="{{ asset('plugins/time-picker/toggles.min.js') }}"></script>

    <!-- INTERNAL Datepicker js -->
    <script src="{{ asset('plugins/date-picker/date-picker.js') }}"></script>
    <script src="{{ asset('plugins/date-picker/jquery-ui.js') }}"></script>
    <script src="{{ asset('plugins/input-mask/jquery.maskedinput.js') }}"></script>

    <!-- INTERNAL File-Uploads Js-->
    <script src="{{ asset('plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ asset('plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ asset('plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ asset('plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ asset('plugins/fancyuploder/fancy-uploader.js') }}"></script>

    <!-- INTERNAL File uploads js -->
    <script src="{{ asset('plugins/fileupload/js/dropify.js') }}"></script>
    <script src="{{ asset('js/filupload.js') }}"></script>


    <!-- INTERNAL Data tables -->
    <script src="{{ asset('plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('plugins/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatable/responsive.bootstrap4.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/select2.full.min.js') }}"></script>

    <!-- Calender -->
    <script src="{{ asset('plugins/calendar/custom.js') }}"></script>
    <script src="{{ asset('plugins/calendar/app-calendar.js') }}"></script>
    <script src="{{ asset('plugins/calendar/app-calendar-events.js') }}"></script>
    <script src="{{ asset('plugins/calendar/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('plugins/calendar/moment.min.js') }}"></script>

    <!-- Calender end -->

    <!-- export ---->
    <script src="{{ asset('plugins/Export/tableExport/tableExport.js') }}"></script>
    <script src="{{ asset('plugins/Export/tableExport/jquery.base64.js') }}"></script>
    <!-- export end ---->





    @stack('scripts')

</body>

</html>