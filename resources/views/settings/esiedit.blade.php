@extends('layouts.app')
@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Settings</a></li>
            <li class="breadcrumb-item"><a href="#">ESI</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Create</a></li>
        </ol>
    </div>
    <br/>
    <!-- <div class="col">
        <span class="page-title">Applicant</span> &#187; Create
    </div>-->
</div>
@endsection
<?php
use Carbon\Carbon;
error_reporting(0);
$project = App\Models\ProjectDetails::all();
//$esi = App\Models\Esidetails::all();
?>
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
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif

            @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
            @endif
            <div class="ml-12">

            <form action="{{ url('/esieditstore/'.$esi->id) }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label for="date" class="col-sm-2 form-label">Employee ESI %</label>
                        <div class=" col-md-3">
                            <input type="text" name="employee_esi" id="employee_esi" class="form-control" value="{{$esi->employee_esi}}" required>
                        </div>
                        <label for="date" class="col-sm-2 form-label">Employer ESI %</label>
                        <div class=" col-md-3">
                            <input type="text" name="employer_esi" id="employer_esi" class="form-control" value="{{$esi->employer_esi}}" required>
                        </div>       
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-success" id="setnewmonth">
                                <i class="fa fa-plus"></i> Save
                            </button>
                        </div>                
                    </div>
                </form>
            </div>
            <br>
        </div>
    </div>
</div>
</div>
</div>
</div>
@endsection
@push('scripts')
<script>
$('#date').datepicker({
    autoclose: true,
    zIndex: 2048,
    dateFormat: 'dd-mm-yy',
});
</script>
@endpush