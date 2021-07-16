@extends('layouts.app')
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

<?php
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Attendance;
echo $todate = date('Y-m-d');
error_reporting(0);
?>
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
        <form action="{{URL::current()}}" id='superuser-att-view'>
            <div class="row">
                <div class="col-md-2">
                    <label for="date_from" class="form-label">Project</label>
                    <select class="project" name="project" id="project">
                        <option></option>
                        @foreach($model1->all() as $pro)
                        <option value="{{$pro->id}}" {{request()->project == $pro->id ? 'selected':''}}>
                            {{$pro->project_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="date_from" class="form-label">Month</label>
                    <input type="text" name="date_from" id="date_from" class="form-control"
                        value="{{request()->date_from}}">
                </div>  
            </div>

            <div class="row pt-1">
                <div class="col-md-3"></div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-info  btn-sm">Search</button>
                </div>
                <div class="col-md-2">
                    <button type="reset" id="clearBtn" class="btn  btn-sm">Clear</button>
                </div>

                <div class="col-md-2">
                    <button type='button' onclick="exportTableToExcel('tblData')" type="submit" id="clearBtn"
                        class="btn btn-sm btn-danger  float-right">Export</button>
                </div>
            </div>
    </div>
    </form>
    <h5><u>Attendance 1</u></h5>    
    @php   
    $date_from = request()->date_from ? date('Y-m-d', strtotime(request()->date_from)) : date('Y-m-01', strtotime($today));
    $date_to = Carbon::now()->format('Y-m-d');

    $dateRange = CarbonPeriod::create($date_from, $date_to);
    @endphp

    <div class="form-group row">
        <div class="table-responsive">
            <table class="table table-hover" id="tblData">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Employee</th>
                        <th scope="col">Project</th>
                        <?php
                        
                        if(request()->date_from){
                            $year = date('Y', strtotime(request()->date_from));
                            $mon = date('m', strtotime(request()->date_from));
                            $a_date = $year.'-'.$mon.'-01';
                            $date_from =  date('Y-m-d', strtotime(request()->date_from));
                           echo $end = date('Y-m-t', strtotime($a_date));      
                           echo 'given';                     
                        } else {
                            $date_from =  date('Y-m-01', strtotime($today));
                            echo $end = date('Y-m-t',strtotime($today));
                            echo 'hai';
                        }                       
                        $daterange = new DatePeriod(new DateTime($date_from), new DateInterval('P1D'), new DateTime($end));
                        foreach ($daterange as $date) {
                            echo '<th>' . $date->format("d") . '</th>';
                        }
                        ?>
                        <th scope="col">P</th>
                        <th scope="col">A</th>
                    </tr>
                </thead>
                <tbody>
               
               
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

    $('#date_from').datepicker({      
        changeMonth: true,
            changeYear: true,    
            showButtonPanel: true,     
            dateFormat: 'MM yy',                       
    });

    $("#clearBtn").click(function() {
        $('#date_to').val("");
        $('#date_from').val("");
        $("#project").prop('selectedIndex', -1)
        $("#status").prop('selectedIndex', -1)
        $("#superuser-att-view").submit();
    });
    $('#project').select2();
    $('#status').select2();
});


function exportTableToExcel(tableID, filename = '') {
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');


    // Specify file name
    filename = filename ? filename + '.xls' : 'admin_attendance.xls';

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