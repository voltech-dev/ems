@extends('layouts.app')

@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Project Details</a></li>

        </ol>
    </div>
</div>
<br>
<div class="col text-right"> <button onclick="location.href='{{url('/Project/projectcreation')}}'"
        class="btn-primary">Create Project</button>
</div>
@endsection
@section('content')
@if ($message = Session::get('success'))

<div class="alert alert-success">

    <p>{{ $message }}</p>

</div>

@endif
<div class="ml-12">
    <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-striped" id="thegrid">
                        <thead>
                            <tr>
                                <th>SI</th>
                                <th>Project Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($project as $proj)
                            <tr>
                                <td>{{++$i}}</td>
                                <td><a href="{{ url('/Project/projectedit/'.$proj->id) }}">{{$proj->project_name}}</td>
                                <td>
                                    <span class="dropdown">
                                        <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                        </a>
                                        <span class="dropdown-menu dropdown-menu-right">
                                            <a onclick="return confirm('Are you sure?')" href="{{url('/Project/projectdelete/'.$proj->id)}}"
                                                class="dropdown-item"><i class="fa fa-trash"> Delete</i></a>
                                        </span>
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $project->links('layouts.pagination') !!}
                </div>
            </div>
        </div>

    </div>
</div>
</div>
@endsection
@push('scripts')
<script>
$(document).ready(function() {
    theGrid = $('#thegrid').DataTable({
        "bPaginate": false,
        "scrollX": false,
        "scrollY": false,
    });
});
</script>
@endpush