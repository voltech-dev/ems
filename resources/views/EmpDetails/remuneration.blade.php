@extends('layouts.app')
<style>
li a:hover {
    background: #006d6b;
}
</style>
@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Remuneration</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Create</a></li>
        </ol>
    </div>
    <br />
    <!-- <div class="col">
        <span class="page-title">Applicant</span> &#187; Create
    </div>-->
</div>
@endsection
<?php
$projects = App\Models\ProjectDetails::all();
$location = App\Models\Locations::all();
$status =  App\Models\Statuses::all();
$auth =  App\Models\Authorities::all();
$salary_struct =  App\Models\EmpStaffPayScales::all();

error_reporting(0);

?>

@section('content')


<div class="row col" style="margin-left: 5px;">
    <ul class="nav">
        <li class="nav-item" style="background-color:#00a09d;border:1px solid white">
            <a style="width:80px;color:white;text-align:center" class="nav-link"
                href="{{ route('EmpDetails.index')}}"><b>List</b></a>
        </li>
        <li class="nav-item" style="background-color:#00a09d;border:1px solid white">
            <a style="width:180px;color:white;text-align:center" class="nav-link"
                href="{{ route('EmpDetails.edit',$model->id)}}"><b>Employee </b></a>
        </li>

        <li class="nav-item " style="background: #ffffff;border:1px ">
        <a style="width:180px;color:#367fa9;text-align:center" class="nav-link"
                href="{{ url('/EmpDetails/remuneration/'. $model->id)}}"><b>Remuneration</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:180px;color:white;text-align:center" class="nav-link" href="#"><b>Statutory</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:100px;color:white;text-align:center" class="nav-link" href="#"><b>Bank</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:180px;color:white;text-align:center" class="nav-link" href="#"><b>Education</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:180px;color:white;text-align:center" class="nav-link" href="#"><b>Cerificate</b></a>
        </li>

    </ul>
</div>
<br>
<div class="card">
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
                <form action="{{ url('/EmpDetails/remunerationstore') }}" method="POST">
                    {{ csrf_field() }}

                    <div class="card-header" style="background-color:#BBDEFB;color: #000;font-size: 16px;">
                        <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;
                        Remuneration Details
                    </div>
                    <br>
                    <div class="form-group row">
                        <label for="Salary" class="col-sm-2 form-label">Salary Structure</label>
                        <div class=" col-md-3">
                            <input type="hidden" name="empid" id="empid" class="form-control" value="{{$model->id}}">
                            <select class="form-control form-control-sm" name="salary_structure" id="salary_structure">
                                <option></option>
                                @foreach($salary_struct as $struct)
                                <option value="{{$struct->salarystructure}}"
                                    {{ old('salary_structure', $struct->salarystructure) == $struct->id ? 'selected' : '' }}>
                                    {{ucfirst($struct->salarystructure)}}</option>
                                @endforeach
                            </select>
                        </div>

                        <label for="esi_applicability" class="col-sm-2 form-label">Esi Applicability</label>
                        <div class=" col-md-3">
                            <select class="form-control form-control-sm" name="esi_applicability">
                                <option></option>
                                <option value="Yes"> Yes</option>
                                <option value="No">No</option>
                            </select>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="pf_applicablity" class="col-sm-2 form-label">Pf Applicablity</label>
                        <div class=" col-md-3">
                            <select class="form-control form-control-sm" name="pf_applicablity">
                                <option></option>
                                <option value="Yes"> Yes</option>
                                <option value="No"> No</option>
                            </select>
                        </div>

                        <label for="restrict_pf" class="col-sm-2 form-label">Restrict Pf</label>
                        <div class=" col-md-3">

                            <select class="form-control form-control-sm" name="restrict_pf">
                                <option></option>
                                <option value="Yes"> Yes</option>
                                <option value="No"> No</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">

                        <label for="basic" class="col-sm-2 form-label"> Basic</label>
                        <div class=" col-md-3">
                            <input type="text" name="basic" id="basic" class="form-control" value="">
                        </div>

                        <label for="hra" class="col-sm-2 form-label">Hra</label>
                        <div class=" col-md-3">
                            <input type="text" name="hra" id="hra" class="form-control" value="">
                        </div>
                    </div>

                    <div class="form-group row">

                        <label for="splallowance" class="col-sm-2 form-label">Splallowance</label>
                        <div class=" col-md-3">
                            <input type="text" name="splallowance" id="splallowance" class="form-control" value="">
                        </div>

                        <label for="dearness_allowance" class="col-sm-2 form-label">Dearness_allowance</label>
                        <div class=" col-md-3">
                            <input type="text" name="dearness_allowance" id="dearness_allowance" class="form-control"
                                value="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="conveyance" class="col-sm-2 form-label">Conveyance</label>
                        <div class=" col-md-3">
                            <input type="text" name="conveyance" id="conveyance" class="form-control" value="">
                        </div>

                        <label for="lta" class="col-sm-2 form-label">Lta</label>
                        <div class=" col-md-3">
                            <input type="text" name="lta" id="lta" class="form-control" value="">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="medical" class="col-sm-2 form-label">Medical</label>
                        <div class=" col-md-3">
                            <input type="text" name="medical" id="medical" class="form-control" value="">
                        </div>
                        <label for="gross_salary" class="col-sm-2 form-label">Gross Salary</label>
                        <div class=" col-md-3">
                            <input type="text" name="gross_salary" id="gross_salary" class="form-control" value="">
                        </div>
                    </div>

                    <div class="form-row">

                        <div class="col-md-1"></div>
                        <div class="col-md-2">
                            <a class="btn btn-dark" href="{{ url('/EmpDetails/'.$model->id.'/edit') }}"><i
                                    class="glyphicon glyphicon-chevron-left"></i> Back</a>
                        </div>

                        <div class="col-md-1"></div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-plus"></i> Next
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@push('scripts')
<script>
var empm_type;
var ssaltype = $('#salary_structure').val();

$('#basic').prop("readonly", true);
$('#hra').prop("readonly", true);
$('#splallowance').prop("readonly", true);
$('#conveyance').prop("readonly", true);
$('#lta').prop("readonly", true);
$('#medical').prop("readonly", true);




$('#gross_salary').keyup(function(event) {
    var amt = $('#gross_salary').val();
    var ssaltype = $('#salary_structure').val();
    $.ajax({
        type: "GET",
        //url: 'salarystructure',
        url: "{{ url('/salarystructure') }}",
        data: {
            sla_structure: ssaltype,
            empmtype: 'Staff',
            amount: amt
        },
        dataType: 'json',

        success: function(data) {


            $('#basic').val(data.basic);
            $('#hra').val(data.hra);
            $('#conveyance').val(data.ca);
            $('#splallowance').val(data.spl);

        },
        error: function(exception) {
            alert('Something Error');
        }
    });
});



$('#salary_structure').change(function(event) {
    var ss = $('#salary_structure').val();

    $('#basic').val('');
    $('#hra').val('');
    $('#gross_salary').val('');
    $('#splallowance').val('');
    $('#conveyance').val('');
    $('#lta').val('');
    $('#medical').val('');


    if (ss == 'Modern') {

        $('#basic').prop("readonly", true);
        $('#hra').prop("readonly", true);
        $('#splallowance').prop("readonly", true);
        $('#conveyance').prop("readonly", true);
        $('#lta').prop("readonly", true);
        $('#medical').prop("readonly", true);

    }


});
</script>
@endpush