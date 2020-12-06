@extends('layouts.project')

@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fe fe-layers mr-2 fs-14"></i>Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Leave Management</a></li>
        </ol>
    </div>
</div>
@endsection

@section('content')

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
            <form action="{{URL::current()}}" id='leave-view'>
                <div class="row">
                    <div class="col-md-3">
                        <label for="date_from" class="form-label">Employee</label>
                        <select class="form-control form-control-sm" name="employee" id="employee">
                            <option selected></option>
                            @foreach($modelEmp as $emp)
                            <option value='{{$emp->id}}' {{request()->employee == $emp->id ? 'selected':''}}>
                                {{$emp->emp_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="date_from" class="form-label">From</label>
                        <input type="text" name="date_from" id="date_from" class="form-control"
                            value="{{request()->date_from}}">
                    </div>
                    <div class="col-md-2">
                        <label for="date_from" class="form-label">To</label>
                        <input type="text" name="date_to" id="date_to" class="form-control"
                            value="{{request()->date_to}}">

                    </div>
                    <div class="col-md-2">
                        <label for="date_from" class="form-label">Status</label>
                        <select class="form-control " name="action" id="action">
                            <option selected></option>
                            <option value="Waiting for approvel" @if(request()->action == 'Waiting for approvel') selected @endif>Waiting for approvel</option>
                            <option value="Approved" @if(request()->action == 'Approved') selected @endif>Approved</option>
                              <option value="Rejected" @if(request()->action == 'Rejected') selected @endif>Rejected</option>
                        </select>
                    </div>
                </div>
                <div class="row pt-1">
                    <div class="col-md-4"></div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm btn-info">
                            Search
                        </button>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" id="clearBtn" class="btn btn-sm">
                            Clear
                        </button>
                    </div>
                </div>
            </form>


            <form action="{{url('/leaveapprove')}}" method="POST">
                @csrf

                <h5><u>Leave Approvel</u></h5>

                <div class="form-group row">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" name="select_all" value="all" id="select-all"></th>
                                    <th scope="col">Emp Name</th>
                                    <th scope="col">Date From</th>
                                    <th scope="col">Date To</th>
                                    <th scope="col">Leave Type</th>
                                    <th scope="col">Reason</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Remark</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($modelLeave as $model)
                                <tr>
                                    <td><input type="checkbox" class="SelectAllCheck" name="id[]"
                                            value="{{$model->id}}"></td>
                                    <td>{{$model->employee->emp_name}}</td>
                                    <td>{{ date('d-m-Y', strtotime($model->date_from)) }}</td>
                                    <td>{{ $model->date_to ? date('d-m-Y', strtotime($model->date_to)):'' }}</td>
                                    <td>{{$model->leave_type}}</td>
                                    <td>{{$model->reason}}</td>
                                    <td>{{$model->action}}</td>
                                    <td>{{ $model->col_date ? 'COL Date :'. date('d-m-Y', strtotime($model->col_date)) : ''}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="date_from" class="col-sm-1 form-label">Action</label>
                    <div class="col-sm-2">
                        <select class="form-control form-control-sm " name="approve">
                            <option></option>
                            <option value="Approved">Approved</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-info">
                            Submit
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

@endsection
@push('scripts')
<script>
$(function() {
    $('#date_from,#date_to').datepicker({
        autoclose: true,
        dateFormat: 'dd-mm-yy'
    });
    $("#clearBtn").click(function() {
        $('#date_to').val();
        $('#date_from').val();
        $("#employee").prop('selectedIndex', -1)
        $("#leave-view").submit();
    });

    $('#select-all').on('click', function() {
        $('.SelectAllCheck').prop('checked', this.checked);
    });
    $('#employee').select2();
});
</script>
@endpush