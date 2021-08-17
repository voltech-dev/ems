
@extends('layouts.app')
@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Emp Details</a></li>
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Check List </a></li>
        </ol>
    </div>
</div>
<br>

<div class="col text-right">
<button onclick="location.href='{{url('/checklistexports')}}'"
            class="btn-success">Export</button>
    <!-- <button class="btn-success dataExport" data-type="excel">Export</button> -->
            <!-- <button type="button" class="btn btn-primary btn-lg dropdown-toggle" data-toggle="dropdown">Export <span class="caret"></span></button>
	<ul class="dropdown-menu" role="menu">
		<li><a class="dataExport" data-type="csv">CSV</a></li>
		<li><a class="dataExport" data-type="excel">XLS</a></li>          
		<li><a class="dataExport" data-type="txt">TXT</a></li>			 			  
	</ul> -->
</div>

@endsection
<?php
error_reporting(0);
$projects = App\Models\ProjectDetails::all();
?>
@section('content')
<div class="ml-1">

    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div style="line-height:2; font-size:16px">

        <div class="form-group row">
            <div class="table-responsive">
                <table class="table table-bordered text-nowrap table-hover" id="checklist" width="100%"
                    style="font-size: 0.575rem; padding:0px;">
                    <thead>
                        <tr>
                            <th style="font-size: 0.575rem; padding: 5px; text-align: center">SI</th>
                            <th style="font-size: 0.575rem; padding: 5px; text-align: center">Emp Code</th>
                            <th style="font-size: 0.575rem; padding: 5px; text-align: center">Emp Name</th>
                            <th style="font-size: 0.575rem; padding: 5px; text-align: center">Proj Site</th>
                            @foreach($model as $docu)
                            <th style="font-size: 0.575rem; padding: 5px; text-align: center">{{$docu->doc_type_name}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($emp as $empl)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$empl->emp_code}}</td>
                            <td>{{$empl->emp_name}}</td>
                            <td>{{$empl->project->project_name}}</td>
                            @foreach($model as $docu)
                            @if($docu->getDocuments($empl->id,$docu->doc_type_name))
                            <td>Y</td>
                            @else
                            <td>N</td>
                            @endif
                            @endforeach
                        </tr>  
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br><br><br>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
	$(".dataExport").click(function() {
		var exportType = $(this).data('type');		
		$('#checklist').tableExport({
			type : exportType,			
			escape : 'false',
			ignoreColumn: []
		});		
	});
});
</script>
@endpush