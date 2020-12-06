@extends('layouts.emp')

@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fe fe-layers mr-2 fs-14"></i>Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Leave Form</a></li>
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
            <form action="{{ url('/leavestore')}}" method="POST">
            @csrf
            <input type="hidden" name="empid" id="empid" class="form-control" value="{{$model->id}}">
            <input type="hidden" name="projectid" id="projectid" class="form-control" value="{{$model->project_id}}">
                <div class="form-group row">
                    <label for="date_from" class="col-sm-2 form-label">Leave From</label>
                    <div class="col-md-2">
                        <input type="text" name="date_from" id="date_from" class="form-control" value="">
                    </div>
                    <label for="date_to" class="col-sm-1 form-label">Leave To</label>
                    <div class="col-md-2">
                        <input type="text" name="date_to" id="date_to" class="form-control" value="">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="reason" class="col-sm-2 form-label">Reason</label>
                    <div class="col-md-8">
                        <input type="text" name="reason" id="reason" class="form-control" value="">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="leave_type" class="col-sm-2 form-label">Leave Type</label>
                    <div class="col-md-8">
                        <div class="form-check form-check-inline pr-5">
                            <input class="form-check-input" type="radio" name="leave_type" id="leave_type1" value="pl">
                            <label class="form-check-label" for="inlineRadio1">Paid Leave</label>
                        </div>
                        <div class="form-check form-check-inline pr-5">
                            <input class="form-check-input" type="radio" name="leave_type" id="leave_type2" value="upl">
                            <label class="form-check-label" for="inlineRadio2">Unpaid Leave</label>
                        </div>      
                        <div class="form-check form-check-inline pr-5">
                            <input class="form-check-input" type="radio" name="leave_type" id="leave_type4" value="col">
                            <label class="form-check-label" for="inlineRadio3">COL </label>
                        </div>                       
                    </div>
                </div>

                <div class="form-group row" id="coldate" style="display:none">
                    <label for="col_date" class="col-sm-2 form-label">COL Date</label>
                    <div class="col-md-2">
                        <input type="text" name="col_date" id="col_date" class="form-control" value="">
                    </div>
                </div>

                <div class="form-row">
                <div class="col-md-2"></div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-info">
                            save
                        </button>
                    </div>

                    <div class="col-md-2">
                        <a class="btn btn-dark" href="{{ url('/') }}"><i class="glyphicon glyphicon-chevron-left"></i>
                            Back</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
$(function() {
    $('#date_from,#date_to,#col_date').datepicker({
        autoclose: true,
        dateFormat: 'dd-mm-yy',
        minDate: -30,
        maxDate: 30
    });

    $("#clearBtn").click(function() {
        $('#date_to').val("");
        $('#date_from').val("");
        $("#att-view").submit();
    });
    $('input[type=radio][name=leave_type]').on('change', function() {
        switch ($(this).val()) {
            case 'col':
                $("#coldate").show();
                break;
            default:
                $("#coldate").hide();
        }
    });
});
</script>
@endpush