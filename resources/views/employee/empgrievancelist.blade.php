@extends('layouts.emp')

@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Grievance</a></li>
            <li class="breadcrumb-item"><a href="#">{{auth()->user()->name}}</a></li>
        </ol>
    </div>
</div>
<br>

 <div class="col text-right"> 
     <!--<button onclick="location.href='{{url('/export')}}'"
            class="btn-success">Export</button> -->
            <button onclick="location.href='{{url('/empgrievance')}}'"
            class="btn-primary">Create</button>

    </div>

@endsection

@section('content')
<div class="ml-12">
    <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
        <table class="table table-striped" id="thegrid" width="100%">
            <thead>
                <tr>
                    <th><input type="checkbox" name="select_all" value="all" id="select-all"></th>
                    <th>Grievanvce No</th>
                    <th>Emp Code</th>
                    <th>Emp Name</th>
                    <th>Project Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
var theGrid = null;
$(document).ready(function() {
    theGrid = $('#thegrid').DataTable({
        "processing": true,
        "serverSide": true,
        "ordering": true,
        "responsive": true,
        "lengthMenu": [
            [25, 100, -1],
            [25, 100, "All"]
        ],
        "order": [[ 1, "desc" ]],
        "ajax": "{{url('/empviewdatalist')}}",
        //"dom": "B<'row'<'col-md-6'i><'col-md-6'f>> rt<'row'<'col-md-4'l><'col-md-8'p>>",
       /* "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],*/
        "columnDefs": [{
                "data": "id",
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
                "targets": 0
            },
            {
                "render": function(data, type, row) {
                    return '<a href="{{ url('/empgrievanceshow') }}/' + row[1] + '">' + data + '</a>';
                },
                "targets": 1
            },
            {
                "render": function(data, type, row) {
                    return '<a href="{{ url('/empgrievance_edit') }}/' + row[6] +
                        '"> <i class="ion ion-edit"></i> </a>';

                },
                "targets": 6

            },


        ]





    });

    $('#select-all').on('click', function() {
        $('.SelectAllCheck').prop('checked', this.checked);
    });
});
</script>
@endpush