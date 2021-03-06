@extends('layouts.project')

@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fe fe-layers mr-2 fs-14"></i>Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Attendance View</a></li>
        </ol>
    </div>
</div>
@endsection

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
            <form action="{{URL::current()}}" id='att-view'>
                <div class="row">
                    <div class="col-md-3">
                        <label for="date_from" class="form-label">Employee</label>
                        <select class="form-control " name="employee" id="employee">
                            <option selected></option>
                            @foreach($modelEmp as $emp)
                            <option value='{{$emp->id}}' {{request()->employee == $emp->id ? 'selected':''}}>
                                {{$emp->emp_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="date_from" class="form-label">From</label>
                        <input type="text" name="date_from" id="date_from" class="form-control"
                            value="{{request()->date_from}}">
                    </div>

                    <div class="col-md-2">
                        <label for="date_from" class="form-label">To</label>
                        <input type="text" name="date_to" id="date_to" class="form-control"
                            value="{{request()->date_to}}">
                    </div>
                    <div class="col-md-2">
                        <label for="date_from" class="form-label">Status</label>
                        <select class="form-control " name="status" id="status">
                            <option selected></option>
                            <option value="Waiting for Punch" @if(request()->status == 'Waiting for Punch') selected
                                @endif>Waiting for Punch</option>
                            <option value="Present" @if(request()->status == 'Present') selected @endif>Present
                            </option>
                            <option value="Half-Day" @if(request()->status == 'Half-Day') selected @endif>Half-Day
                            </option>
                            <option value="Absent" @if(request()->status == 'Absent') selected @endif>Absent</option>
                        </select>
                    </div>
                </div>

                <div class="row pt-1">
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm btn-info">
                            Search
                        </button>
                    </div>

                    <div class="col-md-2">
                        <button type="reset" id="clearBtn" class="btn btn-sm">
                            Clear
                        </button>
                    </div>
                 <div class="col-md-2">
                 <button onclick="exportTableToExcel('tblData')" id="clearBtn" class="btn btn-sm btn-danger  float-right">Export</button>
                    </div>
                </div>
            </form>

            <h5><u>Attendance</u></h5>

            <div class="form-group row">
                <div class="table-responsive">
                    <table class="table table-hover" id="tblData">
                        <thead>
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Employee</th>
                                <th scope="col">In Time</th>
                                <th scope="col">OUT Time</th>
                                <th scope="col">Status</th>
                                <th scope="col">Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($model as $att)
                            <tr>
                                <td>{{$att->date}}</td>
                                <td>{{$att->employee->emp_name}}</td>
                                <td>{{$att->in_time}}</td>
                                <td>{{$att->out_time}}</td>
                                <td>{{$att->status}}</td>
                                <td></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
        $("#employee").prop('selectedIndex', -1)
        $("#att-view").submit();
    });
    $('#employee').select2();
});

function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'Admin_attendance.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
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