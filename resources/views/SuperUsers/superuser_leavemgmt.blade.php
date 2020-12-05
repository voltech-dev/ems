@extends('layouts.project')

@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fe fe-layers mr-2 fs-14"></i>Dashboard</a>
            </li>
            <li class="breadcrumb-item" aria-current="page"><a href="#">Attendance</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Leave Management</a></li>
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
            <form action="{{URL::current()}}" id='leave-view'>
                <div class="row">
                    <div class="col-md-2">
                        <label for="project" class="form-label">Project</label>
                        <select class="form-control form-control-sm" name="superuser" id="superuser">
                            <option></option>
                            @foreach($model1->all() as $pro)
                            <option value="{{$pro->id}}" {{request()->project == $pro->id ? 'selected':''}}>
                                {{$pro->project_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="date_from" class="form-label">From</label>
                        <input type="text" name="date_from" id="date_from" class="form-control form-control-sm"
                            value="{{request()->date_from}}">
                    </div>
                    <div class="col-md-2">
                        <label for="date_from" class="form-label">To</label>
                        <input type="text" name="date_to" id="date_to" class="form-control form-control-sm"
                            value="{{request()->date_to}}">

                    </div>
                    <div class="col-md-2">
                        <label for="date_from" class="form-label">Status</label>
                        <select class="form-control form-control-sm" name="action" id="action">
                            <option selected></option>
                            <option value="Waiting for approvel" @if(request()->action == 'Waiting for approvel')
                                selected @endif>Waiting for approvel</option>
                            <option value="Approved" @if(request()->action == 'Approved') selected @endif>Approved
                            </option>
                            <option value="Rejected" @if(request()->action == 'Rejected') selected @endif>Rejected
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-info btn-sm">
                            Search
                        </button>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" id="clearBtn" class="btn btn-sm">
                            Clear
                        </button>
                    </div>
                </div>
            </form>
            <div class="col-md-12">
                <button onclick="exportTableToExcel('tblData')" type="submit" id="clearBtn"
                    class="btn btn-sm btn-success  float-right">Export</button>
            </div><br />
            <div class="form-group row">
                <h6><u>Leave List</u></h6>
            </div>
            <div class="form-group row">
                <div class="table-responsive">
                    <table class="table table-hover" id="tblData">
                        <thead>
                            <tr>
                                <th scope="col">Emp Name</th>
                                <th scope="col">Date From</th>
                                <th scope="col">Date To</th>
                                <th scope="col">Leave Type</th>
                                <th scope="col">Reason</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($model as $leave)
                            <tr>
                                <td>{{$leave->employee->emp_name}}</td>
                                <td>{{$leave->date_from}}</td>
                                <td>{{$leave->date_to}}</td>
                                <td>{{$leave->leave_type}}</td>
                                <td>{{$leave->reason}}</td>
                                <td>{{$leave->action}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
$(function() {
    $('#date_from,#date_to').datepicker({
        autoclose: true,
        dateFormat: 'dd-mm-yy'
    });
    $("#clearBtn").click(function() {
        $('#date_to').val();
        $('#date_from').val();
        $("#superuser").prop('selectedIndex', -1)
        $("#leave-view").submit();
    });
});
function exportTableToExcel(tableID, filename = '') {
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');


    // Specify file name
    filename = filename ? filename + '.xls' : 'admin_leavemgmt.xls';

    // Create download link element
    downloadLink = document.createElement("a");

    document.body.appendChild(downloadLink);

    if (navigator.msSaveOrOpenBlob) {
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob(blob, filename);
    } else {
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

        // Setting the file name
        downloadLink.download = filename;

        //triggering the function
        downloadLink.click();
    }
}
</script>
@endpush