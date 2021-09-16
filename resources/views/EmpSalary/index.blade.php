@extends('layouts.app')
@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Payroll</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Salary Index</a></li>
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
<table border="0" cellspacing="5" cellpadding="5">
        <tbody><tr>
            <td>Project</td>
            <td>
				<select class="form-control form-control-sm" name="project_id" id="project">
                        <option></option>
                        @foreach($projects as $pro)
                        <option value="{{$pro->project_name}}"
                            {{ old('project_id', $pro->project_name) == $pro->id ? 'selected' : '' }}>
                            {{ucfirst($pro->project_name)}}</option>
                        @endforeach
                    </select>
			</td>
        </tr>       
    </tbody></table>

        <table class="table table-striped" id="thegrid" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th width="12%">Emp Code</th>
                    <th width="20%">Emp Name</th>
                    <th width="20%">Project Name</th>
                    <th>Paid Days</th>                   
                    <th>Gross</th>
                    <th>Earning</th>
                    <th>Deduction</th>
                    <th>Net Amount</th>
                    <th>CTC</th>
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
	var pro =$('#project').val();  
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

        "ajax": "{{url('/salarylist')}}",
        "dom": "<'row'<'col-md-1'><'col-md-3'i><'col-md-6'f>> rt<'row'<'col-md-4'l><'col-md-8'p>>",
    
        "columnDefs": [{
                "data": "id",
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
                "targets": 0
            },
            {
                "render": function(data, type, row) {
                    return '<a href="{{ url('/empsalary') }}/' + row[0] + '">' + data +
                        '</a>';
                },
                "targets": 1
            },
        ]
    });   
	
	  $('#project').change( function() {
       theGrid.columns(3).search( this.value).draw();	   
    } );	
});

</script>
@endpush