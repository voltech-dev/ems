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
    <!-- <button onclick="location.href='{{url('/checklist_edit/'.$emp_id)}}'"
        class="btn-success">Edit</button> -->
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
        <div class="pt-3">
            <h3> On-boarding Compliance </h3>
        </div>
        <input type="hidden" name="emp_id" value="{{$emp_id}}">

        <div class="form-group">
            <table class="table table-bordered text-nowrap" id="example1">
                <thead>
<tr>
    <th width="5%">SI</th>
    <th width="75%">Document Type</th>
    <th>Status</th>
    <th>Status</th>
</tr>
</thead>
                <tbody>
                    
                    @foreach($docs as $doc)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$doc->doc_type_name}}</td>
                        @if($doc->getDocument($emp_id,$doc->doc_type_name))
                        <td> <input type="checkbox" checked disabled style="outline:1px solid #705ec8;"> Yes </td>
                        @else 
                        <td> <input type="checkbox" disabled> Yes </td>
                        @endif
                        @if($doc->getDocument($emp_id,$doc->doc_type_name))
                        <td> <input type="checkbox" disabled> NO </td>
                        @else 
                        <td> <input type="checkbox" checked disabled style="outline:1px solid #705ec8;"> NO </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
       




    </div>
    <br><br><br>
</div>


@endsection
@push('scripts')
<script type="text/javascript">

</script>
@endpush