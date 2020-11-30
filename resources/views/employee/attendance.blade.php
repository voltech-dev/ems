@extends('layouts.emp')

@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Employee</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Attendance</a></li>
        </ol>
    </div>
</div>
@endsection


@section('content')



<div class="p-6">
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
            <form action="{{ url('/attendancestore') }}" method="POST">
                @csrf
                <h5><u>Emp Details</u></h5>
                <div class="form-group row">
                    <input type="hidden" name="empid" id="empid" class="form-control" value="{{$model->id}}">
                    <input type="hidden" name="projectid" id="projectid" class="form-control" value="{{$model->project_id}}">
                    <label for="emp_code" class="col-sm-2 form-label">Emp Code</label>
                    <div class=" col-md-3">
                        <input type="text" name="emp_code" id="emp_code" class="form-control"
                            value="{{$model->emp_code}}" readonly />
                    </div>

                    <label for="emp_name" class="col-sm-2 form-label">Emp Name</label>
                    <div class=" col-md-3">
                        <input type="text" name="emp_name" id="emp_name" class="form-control"
                            value="{{$model->emp_name}}" readonly />
                    </div>
                </div>

                <div class="form-group row">
                    <label for="project" class="col-sm-2 form-label">Project</label>
                    <div class=" col-md-3">
                        <input type="text" name="emp_name" id="emp_name" class="form-control"
                            value="{{$model->project->project_name}}" readonly />
                    </div>
                    <label for="designation" class="col-sm-2 form-label">Designation</label>
                    <div class=" col-md-3">
                        <input type="text" name="designation" id="designation" class="form-control"
                            value="{{$model->designation->designation_name}}" readonly />
                    </div>
                </div>

                <h5><u>Attendance</u></h5>

                <div class="form-group row">
                    <label for="date" class="col-sm-2 form-label">Attendance Date</label>
                    <div class=" col-md-3">
                        <input type="text" name="attendance_date" id="attendance_date" class="form-control"
                            value="{{date('d-m-Y')}}" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="intime" class="col-sm-2 form-label">In Time</label>
                    <div class=" col-md-3">
                        <input type="text" name="in_time" id="in_time" class="form-control" value="{{date('H:i')}}" onClick="inTime()">
                    </div>
                    <label for="outime" class="col-sm-2 form-label">OUT Time</label>
                    <div class=" col-md-3">
                        <input type="text" name="out_time" id="out_time" class="form-control" value=""  onClick="outTime()">
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success">
                             save
                        </button>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                        <a class="btn btn-dark" href="{{ url('/attendance-view') }}"><i
                                class="glyphicon glyphicon-chevron-left"></i>
                            Back</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
$(function() {
   
});
    function inTime(){
        $('#in_time').wickedpicker({
        twentyFour: true,
        title: 'In/Out Time',       
    });
    }

    function outTime(){
        $('#out_time').wickedpicker({
        twentyFour: true,
        title: 'In/Out Time',       
    });
    }

</script>
@endpush