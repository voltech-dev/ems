@extends('layouts.app')
@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fe fe-layers mr-2 fs-14"></i>Dashboard</a>
            </li>
            <li class="breadcrumb-item" aria-current="page"><a href="#">Attendance</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">View</a></li>
        </ol>
    </div>
</div>
@endsection
<?php
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Attendance;
error_reporting(0);
 $day = date('m');
 $y = date('Y');

// $start_day = strtotime(date("Y-m-d"));
// $end_day = $start_day + 86400 * $day;

//     while($end_day >= $start_day){
//             echo date("j F, Y",$start_day)."\r\n";
//            //$start_day = $start_day + 86400;
//     }
$list=array();
$month = $day;
$year = $y;

for($d=1; $d<=31; $d++)
{
    $time=mktime(12, 0, 0, $month, $d, $year);          
    if (date('m', $time)==$month)       
    $list[] = date('d', $time);
}
//echo "<pre>";
//print_r($list);
//echo "</pre>";
$first = current($list);
$last = end($list); 
$firstdate = $y."-".$day."-".$first;
//echo $firstdate;
//echo "<br/>";
$lastdate = $y."-".$day."-".$last;


// foreach($attendances as $att){
//    echo $att->date; 
// }
?>
<style>
body {
    line-height: 1.6;
    margin: 2em;
    min-width: 990px;
}

th {
    /* background-color: #705ec8; */
    color: #fff;
    padding: 0.5em 1em;
}

td {
    border-top: 1px solid #eee;
    padding: 0px;
}

input {
    cursor: pointer;
}

/* Column types */
th.missed-col {
    background-color: #f00;
}

td.missed-col {
    background-color: #ffecec;
    color: #f00;
    text-align: center;
}

.name-col {
    text-align: left;
}
</style>
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
        <h5><u>Attendance</u></h5>
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
                    <label for="date_from" class="form-label">From</label>
                    <input type="text" name="date_from" id="date_from" class="form-control"
                        value="{{request()->date_from}}">
                </div>
                <div class="col-md-2">
                    <label for="date_from" class="form-label">To</label>
                    <input type="text" name="date_to" id="date_to" class="form-control" value="{{request()->date_to}}">
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
                <div class="col-md-2">
                    <button type="submit" class="btn btn-info  btn-sm">Search</button>
                    <button type="reset" id="clearBtn" class="btn  btn-sm">Clear</button>
                </div>
            </div>
            <!-- <div class="row pt-1">
                <div class="col-md-3"></div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-info  btn-sm">Search</button>
                </div>
                <div class="col-md-2">
                    <button type="reset" id="clearBtn" class="btn  btn-sm">Clear</button>
                </div> -->

            <!-- <div class="col-md-2">
                    <button type='button' onclick="exportTableToExcel('tblData')" type="submit" id="clearBtn"
                        class="btn btn-sm btn-danger  float-right">Export</button>
                </div> -->
            <!-- </div> -->
    </div>
    </form>
    <br>
    <div class="form-group row">
        <div class="table-responsive">
            <table class="table table-bordered text-nowrap table-hover" id="tblData" width="100%"
                style="font-size: 0.575rem; padding:0px;">
                <thead>
                    <tr>
                        <!-- <th style="font-size: 0.575rem; padding:5px;text-align:center" class="sorting_disabled">SI</th> -->
                        <th style="font-size: 0.575rem; padding: 5px; text-align: center" class="sorting_disabled">SI
                        </th>
                        <th style="font-size: 0.575rem;padding:5px;text-align:center">Employee</th>
                        <?php 
                            for($d=1; $d<=$last; $d++)
                            {
                            $time=mktime(12, 0, 0, $month, $d, $year);          
                            if (date('m', $time)==$month)   
                        ?>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center"><?php echo date('d', $time);?>
                        </th>
                        <?php
                        }
                        ?>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">Month Days</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">No of Days Present</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">No of Days Paid Leave</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">No of Days Absent</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">C.off</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">Holidays</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">Total Paid Days</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">Lop</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">Leave</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- @php
                    $date_from = request()->date_from ? request()->date_from :Carbon::now()->format('Y-m-d');
                    $date_to = request()->date_to ? request()->date_to : Carbon::now()->format('Y-m-d');

                    $dateRange = CarbonPeriod::create($date_from, $date_to);
                    @endphp
                    @foreach($dateRange as $rang)-->
                    @foreach($model as $models)

                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$models->emp_name}}</td>                    
                       @for($i = 1; $i <= $last; $i++) 
                       <?php
                            $make_date = date("Y-m")."-".$i; 
                            if(Attendance::where(['emp_id'=>$models->id,'date'=> $make_date])->exists()) {                                        
                                $attendance_for_day ="P";
                            } else {
                                $attendance_for_day ="-";
                            }                            
                        ?>
                    <td>{{$attendance_for_day}}</td>
                    @endfor      
                    
                    <td class="missed-col"><?php echo end($list);?></td>
                    <td class="missed-col">0</td>
                    
                    <td class="missed-col">0</td>
                    <td class="missed-col">0</td>
                    <td class="missed-col">0</td>
                    <td class="missed-col">0</td>
                    <td class="missed-col">0</td>
                    <td class="missed-col">0</td>
                    <td class="missed-col">0</td>
                    </tr>
                    
                    @endforeach
                    <!-- @endforeach -->
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
        $('#date_to').val("");
        $('#date_from').val("");
        $("#project").prop('selectedIndex', -1)
        $("#status").prop('selectedIndex', -1)
        $("#superuser-att-view").submit();
    });
    $('#project').select2();
    $('#status').select2();

// datatable start

    $('#tblData').DataTable({
        "bPaginate": false,
        "scroll": false,
        // "lengthMenu": [[ 25, 50,100, -1], [ 25, 50,100, "All"]]
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19,
                20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33
            ]
        }]
    });
// datatable end

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