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
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">1</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">2</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">3</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">4</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">5</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">6</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">7</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">8</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">9</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">10</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">11</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">12</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">13</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">14</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">15</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">16</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">17</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">18</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">19</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">20</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">21</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">22</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">23</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">24</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">25</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">26</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">27</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">28</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">29</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">30</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">31</th>
                        <th style="font-size: 0.575rem;padding:5px; text-align:center">Leave</th>
                    </tr>
                </thead>
                <tbody><?php $i=0;$i++;
                echo $attend->emp_id;
                ?>
                    <!-- @php
                    $date_from = request()->date_from ? request()->date_from :Carbon::now()->format('Y-m-d');
                    $date_to = request()->date_to ? request()->date_to : Carbon::now()->format('Y-m-d');

                    $dateRange = CarbonPeriod::create($date_from, $date_to);
                    @endphp
                    @foreach($dateRange as $rang)-->
                    @foreach($model as $models)

                    <tr>
                        <td>{{$i++}}</td>
                        <!-- <td>{{$rang->format('d-m-Y')}}</td> -->
                        <td>{{$models->emp_name}}</td>
                        <!-- <td>{{$models->attend->emp_id}}</td> -->
                        <td>@if($models->attend->date == "2021-08-01")
                            <p>p</p>
                                @else
                                <p>-</p>
                            @endif
                        </td>
                        <td>@if($models->attend->date == "2021-08-02")
                            <p>p</p>
                                @else
                                <p>-</p>
                            @endif
                        </td>
                        <td>@if($models->attend->date == "2021-08-03")
                            <p>p</p>
                                @else
                                <p>-</p>
                            @endif
                        </td>
                        <td>@if($models->attend->date == "2021-08-04")
                            <p>p</p>
                                @else
                                <p>-</p>
                            @endif
                        </td>
                        <td>@if($models->attend->date == "2021-08-05")
                            <p>p</p>
                                @else
                                <p>-</p>
                            @endif
                        </td>
                        <td>@if($models->attend->date == "2021-08-06")
                            <p>p</p>
                                @else
                                <p>-</p>
                            @endif
                        </td>
                        <td>@if($models->attend->date == "2021-08-07")
                            <p>p</p>
                                @else
                                <p>-</p>
                            @endif
                        </td>
                        <td>@if($models->attend->date == "2021-08-08")
                            <p>p</p>
                                @else
                                <p>-</p>
                            @endif
                        </td>
                        <td>@if($models->attend->date == "2021-08-09")
                            <p>p</p>
                                @else
                                <p>-</p>
                            @endif
                        </td>
                        <td>@if($models->attend->date == "2021-08-10")
                            <p>p</p>
                                @else
                                <p>-</p>
                            @endif
                        </td>
                        <td>@if($models->attend->date == "2021-08-11")
                            <p>p</p>
                                @else
                                <p>-</p>
                            @endif
                        </td>
                        <td>@if($models->attend->date == "2021-08-12")
                            <p>p</p>
                                @else
                                <p>-</p>
                            @endif
                        </td>
                        <td>@if($models->attend->date == "2021-08-13")
                            <p>p</p>
                                @else
                                <p>-</p>
                            @endif
                        </td>
                        <td>@if($models->attend->date == "2021-08-14")
                            <p>p</p>
                                @else
                                <p>-</p>
                            @endif
                        </td>
                        <td>@if($models->attend->date == "2021-08-15")
                            <p>p</p>
                                @else
                                <p>-</p>
                            @endif
                        </td>
                        <td>@if($models->attend->date == "2021-08-16")
                            <p>p</p>
                                @else
                                <p>-</p>
                            @endif
                        </td>
                        <td>@if($models->attend->date == "2021-08-17")
                            <p>p</p>
                                @else
                                <p>-</p>
                            @endif
                        </td>
                        <td>@if($models->attend->date == "2021-08-18")
                            <p>p</p>
                                @else
                                <p>-</p>
                            @endif
                        </td>
                        <td>@if($models->attend->date == "2021-08-19")
                            <p>p</p>
                                @else
                                <p>-</p>
                            @endif
                        </td>
                        <td>@if($models->attend->date == "2021-08-20")
                            <p>p</p>
                                @else
                                <p>-</p>
                            @endif
                        </td>
                        <td>@if($models->attend->date == "2021-08-21")
                            <p>p</p>
                                @else
                                <p>-</p>
                            @endif
                        </td>
                        <td>@if($models->attend->date == "2021-08-22")
                            <p>p</p>
                                @else
                                <p>-</p>
                            @endif
                        </td>
                        <td>@if($models->attend->date == "2021-08-23")
                            <p>p</p>
                                @else
                                <p>-</p>
                            @endif
                        </td>
                        <td>@if($models->attend->date == "2021-08-24")
                            <p>p</p>
                                @else
                                <p>-</p>
                            @endif
                        </td>
                        <td>@if($models->attend->date == "2021-08-25")
                            <p>p</p>
                                @else
                                <p>-</p>
                            @endif
                        </td>
                        <td>@if($models->attend->date == "2021-08-26")
                            <p>p</p>
                                @else
                                <p>-</p>
                            @endif
                        </td>
                        <td>@if($models->attend->date == "2021-08-27")
                            <p>p</p>
                                @else
                                <p>-</p>
                            @endif
                        </td>
                        <td>@if($models->attend->date == "2021-08-28")
                            <p>p</p>
                                @else
                                <p>-</p>
                            @endif
                        </td>
                        <td>@if($models->attend->date == "2021-08-29")
                            <p>p</p>
                                @else
                                <p>-</p>
                            @endif
                        </td>
                        <td>@if($models->attend->date == "2021-08-30")
                            <p>p</p>
                                @else
                                <p>-</p>
                            @endif
                        </td>
                        <td>@if($models->attend->date == "2021-08-31")
                            <p>p</p>
                                @else
                                <p>-</p>
                            @endif
                        </td>
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

    $('#tblData').DataTable({
        // "lengthMenu": [[ 25, 50,100, -1], [ 25, 50,100, "All"]]
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19,
                20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33
            ]
        }]
    });
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








/* STUDENTS IGNORE THIS FUNCTION
 * All this does is create an initial
 * attendance record if one is not found
 * within localStorage.
 */
(function() {
    if (!localStorage.attendance) {
        console.log('Creating attendance records...');

        function getRandom() {
            return (Math.random() >= 0.5);
        }

        var nameColumns = $('tbody .name-col'),
            attendance = {};

        nameColumns.each(function() {
            var name = this.innerText;
            attendance[name] = [];

            for (var i = 0; i <= 11; i++) {
                attendance[name].push(getRandom());
            }
        });

        localStorage.attendance = JSON.stringify(attendance);
    }
}());


/* STUDENT APPLICATION */
$(function() {
    var attendance = JSON.parse(localStorage.attendance),
        $allMissed = $('tbody .missed-col'),
        $allCheckboxes = $('tbody input');

    // Count a student's missed days
    function countMissing() {
        $allMissed.each(function() {
            var studentRow = $(this).parent('tr'),
                dayChecks = $(studentRow).children('td').children('input'),
                numMissed = 0;

            dayChecks.each(function() {
                if (!$(this).prop('checked')) {
                    numMissed++;
                }
            });

            $(this).text(numMissed);
        });
    }

    // Check boxes, based on attendace records
    $.each(attendance, function(name, days) {
        var studentRow = $('tbody .name-col:contains("' + name + '")').parent('tr'),
            dayChecks = $(studentRow).children('.attend-col').children('input');

        dayChecks.each(function(i) {
            $(this).prop('checked', days[i]);
        });
    });

    // When a checkbox is clicked, update localStorage
    $allCheckboxes.on('click', function() {
        var studentRows = $('tbody .student'),
            newAttendance = {};

        studentRows.each(function() {
            var name = $(this).children('.name-col').text(),
                $allCheckboxes = $(this).children('td').children('input');

            newAttendance[name] = [];

            $allCheckboxes.each(function() {
                newAttendance[name].push($(this).prop('checked'));
            });
        });

        countMissing();
        localStorage.attendance = JSON.stringify(newAttendance);
    });

    countMissing();
}());
</script>
@endpush