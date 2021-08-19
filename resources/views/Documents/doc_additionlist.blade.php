@extends('layouts.app')
@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Documnet Type Details</a></li>

        </ol>
    </div>
</div>
<br>
<div class="col text-right"> <button onclick="location.href='{{url('/Documents/documentcreation')}}'"
        class="btn-primary">Create Document</button>
</div>
@endsection
@section('content')
<div class="ml-12">
    <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
        <div class="row">
            <div class="col">
                <table class="table table-striped" id="thegrid" width="100%">
                    <thead>
                        <tr>
                            <th>SI</th>
                            <th>Document Type Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($documents as $doc)
                            <tr>
                                <td>{{++$i}}</td>
                                <td><a href="{{ url('/Documents/documentedit/'.$doc->id) }}">{{$doc->doc_type_name}}</td>
                                <td>
                                    <span class="dropdown">
                                        <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                        </a>
                                        <span class="dropdown-menu dropdown-menu-right">
                                            <a onclick="return confirm('Are you sure?')" href="{{url('/Documents/documentdelete/'.$doc->id)}}"
                                                class="dropdown-item"><i class="fa fa-trash"> Delete</i></a>
                                        </span>
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
                {!! $documents->links('layouts.pagination') !!}
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
        "bPaginate": false,
        "scrollX": false,
        "scrollY": false,
    });
});
</script>
@endpush