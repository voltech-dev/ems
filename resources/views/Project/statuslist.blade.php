@extends('layouts.app')

@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Status</a></li>

        </ol>
    </div>
</div>
<br>
<div class="col text-right"> <button onclick="location.href='{{url('/Project/statuscreation')}}'"
        class="btn-primary">Create Status</button>
</div>
@endsection

@section('content')
<div class="ml-12">
    <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
        <div class="row">
            <div class="col">
                <table class="table table-striped" id="thegrid">
                    <thead>
                        <tr>
                            <th><input type="checkbox" name="select_all" value="all" id="select-all"></th>

                            <th>Status</th>

                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="col">
            </div>
        </div>

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
        "ajax": "{{url('/statusdata')}}",
        "dom": "<'row'<'col-md-6'i><'col-md-6'f>> rt<'row'<'col-md-4'l><'col-md-8'p>>",
        "columnDefs": [{
                "data": "id",
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
                "targets": 0
            },
            {
                "render": function(data, type, row) {
                    return '<a href="{{ url('/Project/statusedit') }}/' + row[0] + '">' +
                        data + '</a>';
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