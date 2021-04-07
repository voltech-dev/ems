@extends('layouts.app')

@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Leave Balance</a></li>

        </ol>
    </div>
</div>
@endsection

@section('content')
@if ($errors->any())
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="mt-1 text-gray-600 dark:text-gray-400 text-sm" style="min-height:350px">
    <form action="{{ url('/lbedit',$model->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="form-group row">               
                <label for="emp_code" class="col-sm-1 form-label">Emp Code </label>
                <div class=" col-md-3">
                   {{$model->employee->emp_code }}
                </div>

                <label for="emp_name" class="col-sm-2 form-label">Emp Name </label>
                <div class=" col-md-3">
                {{$model->employee->emp_name }}
                </div>
            </div>

            <div class="form-group row">               
                <label for="emp_code" class="col-sm-2 form-label">Balance Leave </label>
                <div class=" col-md-2">
                <input type="text" name="balance_leave" id="balance_leave" class="form-control form-control-sm"
                                value="{{$model->days}}" required>
                </div>
                <div class="col-md-2">
                            <button type="submit" class="btn btn-danger">
                                 Update
                            </button>
                        </div>
               
            </div>
        </div>
</div>
@endsection

@push('scripts')

</script>
@endpush