@extends('layouts.project')
@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-rightheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Emp Appraisal Details</a>
            </li>
        </ol>
    </div>
</div>
<br/>
<div class="col text-right"> 
     <!--<button onclick="location.href='{{url('/export')}}'"
            class="btn-success">Export</button> -->
            <!-- <button onclick="location.href='{{url('/appraisal_create')}}'"
            class="btn-primary">Create</button> -->

    </div>
@endsection
@section('content')
<div class="ml-12">
    <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
        <table class="table table-striped" id="thegrid" width="100%">
            <thead>
                <tr>
                    <th>SI.no</th>
                    <th>Emp Code</th>
                    <th>Emp Name</th>
                    <th>Email</th>
                    <th>Designation</th>
                    <th>Location</th>
                    <th>Overall Rating</th>
                </tr>
            </thead>
            <tbody>
                @foreach($emp as $emps)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td><a href="{{url('/appraisalview/'.$emps->id)}}">{{$emps->emp_code}}</a></td>
                    <td>{{$emps->emp_name}}</td>
                    <td>{{$emps->mail}}</td>
                    <td>{{$emps->designation->designation_name}}</td>
                    <td>{{$emps->locations->location}}</td>
                    <td>{{$emps->rating($emps->id)}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {!! $emp->links() !!}
    </div>
</div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
var theGrid = null;
$(document).ready(function() {
    theGrid = $('#thegrid').DataTable({

    });

    $('#select-all').on('click', function() {
        $('.SelectAllCheck').prop('checked', this.checked);
    });
});
</script>
@endpush