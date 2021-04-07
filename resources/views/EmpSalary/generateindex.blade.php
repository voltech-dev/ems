@extends('layouts.app')

@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Payroll</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Salary Generate List </a></li>
        </ol>
    </div>
</div>
@endsection
<?php
error_reporting(0);
$projects = App\Models\ProjectDetails::all();
?>
@section('content')
<div class="ml-1">
    <div class="mt-1 text-gray-600 dark:text-gray-400 text-sm ">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        @endif
        <div id="buttonResults"></div>
        <table class="table table-striped" id="thegrid" style="font-size:11px">
            <thead>
                <tr>
                    <th><input type="checkbox" name="select_all" value="all" id="select-all"></th>

                    <th width="10%">Emp Code</th>
                    <th width="40%">Emp Name</th>
                    <th width="15%">Project Name</th>                   
                    <th>Leave Days</th>
                    <th>LOP Days</th>
                    <th>Conveyance</th>
                    <th>Laptop</th>
                    <th>Travel</th>
                    <th>Mobile</th>
                    <th>TDS</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

    </div>
</div>

@endsection
@push('scripts')
<script type="text/javascript">
var theGrid = null;
$(document).ready(function() {
    var selected1 = [];
    theGrid = $('#thegrid').DataTable({
        "processing": true,
        "serverSide": true,
        "ordering": true,
        "responsive": true,
        "lengthMenu": [
            [50, 100, -1],
            [50, 100, "All"]
        ],


        "ajax": "{{url('/viewgeneratelist')}}",
        "dom": "<'row'<'col-md-1'><'col-md-2'B><'col-md-3'i><'col-md-6'f>> rt<'row'<'col-md-4'l><'col-md-8'p>>",
        "buttons": [{
            text: 'Generate',
            className: 'btn btn-info',

            action: function(e, dt, node, config) {
                var contractIdArray = [];
                $("input:checkbox[class=SelectAllCheck]:checked").each(function() {
                    contractIdArray.push($(this).val());
                });


                if (contractIdArray.length > 0) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        url: "{{url('/salaryprocess')}}",
                        type: 'POST',
                        data: {
                            genIds: contractIdArray
                        },
                        dataType: 'json',
                        success: function(data) {
                         theGrid.draw();	
                        }
                    })
                }
            }
        }],
        "rowCallback": function(row, data) {
            if ($.inArray(data.DT_RowId, selected1) !== -1) {
                $(row).addClass('selected');
            }
        },
        "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "render": function(data, type, row) {
                    return '<input type="checkbox" class="SelectAllCheck" name="id[]" value="' +
                        data + '" value="' + data + '">';
                },
                "targets": 0
            },
            {
                "render": function(data, type, row) {
                    return '<a href="{{ url(' / empview ') }}/' + row[0] + '">' + data +
                        '</a>';
                },
                "targets": 1
            },
        ]
    });

    $('#select-all').on('click', function() {
        $('.SelectAllCheck').prop('checked', this.checked);
    });
});
</script>
@endpush