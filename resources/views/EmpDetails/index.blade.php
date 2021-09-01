@extends('layouts.app')
@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Emp Details</a></li>

        </ol>
    </div>
</div>
<br>

<div class="col text-right">
    <div class="btn-group mr-5">
        <div class="dropdown">
            <button class="btn btn-sm btn-lite dropdown-toggle" type="button" id="dropdownMenuButton"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Menu
            </button>
            <div class="dropdown-menu p-1" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item p-1" data-toggle="modal" data-target="#follow-modal" href="#">Pick
                    Column</a>

            </div>
        </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


        <button onclick="location.href='{{url('/empdetails/create')}}'"
            class="btn btn-sm btn-primary">Create</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

        <button onclick="location.href='{{url('/export')}}'" class="btn btn-sm btn-danger">Export</button>
    </div>
</div>

@endsection
<?php
//$emp= App\Models\EmpDetails::all();
error_reporting(0);
?>
@section('content')

<div class="card p-3">
    <input type="hidden" name="pageurl" id="pageurl" value="fetch_empdata">
    <input type="hidden" name="exporturl" id="exporturl" value="leaddataexport">

    <form id="filter">
        {{ csrf_field() }}
        <div class="row">

            <label for="" class="col-sm-1 col-form-label text-right">Emp Name</label>
            <div class="col-sm-2">
                <input type="text" name="emp_name" id="emp_name" class="form-control form-control-sm"
                    value="{{$data['emp_name']}}">
            </div>
            <div class="col-sm-1 mr-6">
                <button type="button" class="btn btn-sm btn-square btn-success px-6" id="filterSubmit">Search</button>
            </div>
            <div class="col-sm-1"> <a href="{{ url('/empdetails') }}" class=" btn btn-sm btn-square btn-danger px-6">Clear</a>
            </div>
        </div>
    </form>

    <div class="row pt-2 ml-6 pb-2">
        <div class="col-sm-1"><input id="filterAdd" class="btn btn-sm btn-square btn-light px-4" type="button"
                value=" Add Filter " /></div>

    </div>
    <form id="extrafilter">
        <table id="dsTable" class="table-sm ml-6"> </table>
        <div id="filterContainer">
            <!--add filters here  -->
        </div>
    </form>

    <div id="thegrid">
         @include('layouts.emppaginationdata') 
    </div>
</div>

<div id="follow-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>column pickup</h3>
                <a class="close" data-dismiss="modal">×</a>
            </div>

            <div class="modal-body" id="checkboxarray">

            </div>

            <div class="modal-footer">
                <input type="button" class="btn-sm btn-success" id="showcolumn" value="show">
                <button type="button" class="btn-sm btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- 
<div class="ml-12">
    <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
        <table class="table table-striped" id="thegrid" width="100%">
            <thead>
                <tr>
                    <th><input type="checkbox" name="select_all" value="all" id="select-all"></th>

                    <th>Emp Code</th>
                    <th>Emp Name</th>
                    <th>Email</th>
                    <th>Designation</th>
                    <th>Project Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div> -->
<!-- </div> -->
@endsection

@push('scripts')
<script src="bladejs/gridtable.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#dsTable').DataTable();
   });
// var theGrid = null;
// $(document).ready(function() {
//     theGrid = $('#thegrid').DataTable({
//         "processing": true,
//         "serverSide": true,
//         "ordering": true,
//         "responsive": true,
//         "lengthMenu": [
//             [25, 100, -1],
//             [25, 100, "All"]
//         ],
//         "ajax": "{{url('/viewdata')}}",
//         "columnDefs": [{
//                 "data": "id",
//                 render: function(data, type, row, meta) {
//                     return meta.row + meta.settings._iDisplayStart + 1;
//                 },
//                 "targets": 0
//             },
//             {
//                 "render": function(data, type, row) {
//                     return '<a href="{{ url(' / empview ') }}/' + row[0] + '">' + data + '</a>';
//                 },
//                 "targets": 1
//             },
//             {
//                 "render": function(data, type, row) {
//                     return '<a href="{{ url(' / empdetails ') }}/' + row[7] +
//                         '/edit"> <i class="ion ion-edit"></i> </a>';

//                 },
//                 "targets": 7

//             },


//         ]
//     });

    // $('#select-all').on('click', function() {
    //     $('.SelectAllCheck').prop('checked', this.checked);
    // });
//});

</script>
@endpush