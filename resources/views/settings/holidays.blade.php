@extends('layouts.app')

@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Set New holiday</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Create</a></li>
        </ol>
    </div>
    <br />
    <!-- <div class="col">
        <span class="page-title">Applicant</span> &#187; Create
    </div>-->
</div>
@endsection
<?php
use Carbon\Carbon;
error_reporting(0);
$project = App\Models\ProjectDetails::all();
?>
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
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif

            @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
            @endif
            <div class="ml-12">
                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                    <table class="table table-striped" id="thegrid">
                        <thead>
                            <tr>
                                <th>Si</th>
                                <th>Date</th>
                                <th>Project</th>
                                <th>Holiday</th>

                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <form action="{{ url('/holidays') }}" method="POST">
                {{ csrf_field() }}

                <h5><u>Holidays</u></h5>
                <div class="form-group row">
                    <label for="sal_month" class="col-sm-2 form-label">Holiday Type</label>
                    <div class=" col-md-3">
                        <select class="form-control form-control-sm" name="check">
                            <option></option>
                            <option value="all"> All</option>
                            <option value="project"> Project</option>
                        </select>

                    </div>

                    <label for="date" class="col-sm-2 form-label">Date</label>
                    <div class=" col-md-3">
                        <input type="text" name="date" id="date" class="form-control" value=""
                            onchange="myFunction_date();">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="Salary" class="col-sm-2 form-label">Project List</label>
                    <div class=" col-md-3">
                        <select class="form-control form-control-sm" name="project" id="project">
                            <option></option>
                            @foreach($project as $pro)
                            <option value="{{$pro->id}}"
                                {{ old('project', $pro->project_name) == $pro->id ? 'selected' : '' }}>
                                {{ucfirst($pro->project_name)}}</option>
                            @endforeach
                        </select>
                    </div>

                    <label for="date" class="col-sm-2 form-label">Leave Details</label>
                    <div class=" col-md-3">
                        <input type="text" name="leave_details" id="leave_details" class="form-control" value=""
                            style="color:red;">
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                        <a class="btn btn-dark" href="{{ url('/applicants') }}"><i
                                class="glyphicon glyphicon-chevron-left"></i> Back</a>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success" id="setnewmonth">
                            <i class="fa fa-plus"></i> Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>


    </div>
</div>
</div>
</div>
</div>
@endsection
@push('scripts')
<script>
$('#date').datepicker({
    autoclose: true,
    zIndex: 2048,
    dateFormat: 'dd-mm-yy',
});

function myFunction_date() {
    var date_value = $("#date").val();
    var leave_details = $("#leave_details").val();


    $.ajax({
        type: "GET",

        url: "{{ url('/leavedays') }}",
        data: {
            date_value: date_value
        },
        dataType: 'json',

        success: function(data) {


            $('#leave_details').val(data.leave_details);


        },
        error: function(exception) {
            alert('Something Error');
        }
    });
    //alert(date_value);
}
theGrid = $('#thegrid').DataTable({
    "processing": true,
    "serverSide": true,
    "ordering": true,
    "responsive": true,
    "ajax": "{{url('/leavedata')}}",
    "dom": "<'row'<'col-md-6'i><'col-md-6'f>> rt<'row'<'col-md-4'l><'col-md-8'p>>",
    "columnDefs": [{
            "searchable": false,
            "orderable": false,
            /*"render": function(data, type, row) {
                return '<input type="checkbox" class="SelectAllCheck" name="id[]" value="' +
                    data + '">';
            },*/
            "targets": 0
        },

    ]
});
</script>
@endpush