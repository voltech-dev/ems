@extends('layouts.emp')

@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fe fe-layers mr-2 fs-14"></i>Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Attendance View</a></li>
        </ol>
    </div>
</div>
@endsection

@section('content')

<div class="p-6">
    <div class="ml-1">
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
        <div class="mt-1 text-gray-600 dark:text-gray-400 text-sm">
            <form action="{{URL::current()}}" id='att-view'>              
                <div class="form-row">
                <label for="date_from" class="col-sm-1 form-label">From</label>
                    <div class="col-md-2">                 
                        <input type="text" name="date_from" id="date_from" class="form-control"
                            value="{{request()->date_from}}" >
                    </div>
                    <label for="date_from" class="col-sm-1 form-label">To</label>
                    <div class="col-md-2">
                    
                        <input type="text" name="date_to" id="date_to" class="form-control"
                            value="{{request()->date_to}}" >

                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-info">
                            Search
                        </button>
                    </div>

                    <div class="col-md-2">
                    <button type="submit" id="clearBtn" class="btn">
                            Clear
                        </button>
                    </div>

                    
                </div>               
            </form>

          



            <h5><u>Leave Approvel</u></h5>

            <div class="form-group row">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Emp Name</th>
                                <th scope="col">Date From</th>
                                <th scope="col">Date To</th>
                                <th scope="col">Leave Type</th>
                                <th scope="col">Reason</th>  
                                <th scope="col">Action</th>
                                <th scope="col">Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($modelLeave as $model)
                            <tr>
                            <td>{{$loop->iteration}}</td>
                                <td>{{$model->employee->emp_name}}</td>                                
                                <td>{{ date('d-m-Y', strtotime($model->date_from)) }}</td>
                                <td>{{ $model->date_to ? date('d-m-Y', strtotime($model->date_to)):'' }}</td>
                                <td>{{$model->Leave_type}}</td>
                                <td>{{$model->reason}}</td>
                                <td>{{$model->action}}</td>
                                <td>{{ $model->col_date ? 'COL Date :'. date('d-m-Y', strtotime($model->col_date)) : ''}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
$(function() {
  
});
</script>
@endpush