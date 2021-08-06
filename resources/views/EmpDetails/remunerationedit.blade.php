@extends('layouts.app')
<style>
li a:hover {
    background: #006d6b;
}
</style>
<?php
$projects = App\Models\ProjectDetails::all();
$location = App\Models\Locations::all();
$status =  App\Models\Statuses::all();
$auth =  App\Models\Authorities::all();
$salary_struct =  App\Models\EmpStaffPayScales::all();
$rem = App\Models\EmpRemunerationDetails::where(['empid'=>$model->id])->first();
$esis = App\Models\Esidetails::first();              
$pfs = App\Models\Providentfunddetails::first();

$pt = $rem->professional_tax;
$insurance = $rem->insurance;
$pf_calc = $rem->gross_salary - $rem->hra;
if($rem->gross_salary< 21000 && $pf_calc>15000){
    $pf = 1800;
    $employer_pf = 1950;
    $esi = round($rem->gross_salary *$esis->employee_esi/100);  
    $employer_esi = round($rem->gross_salary * $esis->employer_esi/100);
}elseif($rem->gross_salary>21000 && $pf_calc>15000){
    $pf = 1800;
    $employer_pf = 1950;
    $esi = 0; 
    $employer_esi = 0;
}else{
    $pf = round($pf_calc *$pfs->employee_pf/100);  
    $esi = round($rem->gross_salary *$esis->employee_esi/100);
    $employer_pf = round($rem->gross_salary * $pfs->employer_pf/100);
    $employer_esi = round($rem->gross_salary * $esis->employer_esi/100);
}

$netsalary = round($rem->gross_salary - $pf - $esi - $pt);
$ctc = round($rem->gross_salary + $employer_pf + $employer_esi + $insurance);

error_reporting(0);
?>
@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Remuneration</a></li>
            <li class="breadcrumb-item"><a href="#">{{$model->emp_name}}</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Edit</a></li>
        </ol>
    </div>
</div>
@endsection


@section('content')

<div class="row col" style="margin-left: 5px;">
    <ul class="nav">
        <li class="nav-item" style="background-color:#00a09d;border:1px solid white">
            <a style="width:80px;color:white;text-align:center" class="nav-link"
                href="{{ route('empdetails.index')}}"><b>List</b></a>
        </li>
        <li class="nav-item" style="background-color:#00a09d;border:1px solid white">
            <a style="width:120px;color:white;text-align:center" class="nav-link"
                href="{{ route('empdetails.edit',$model->id)}}"><b>Employee </b></a>
        </li>
        <li class="nav-item " style="background: #ffffff;border:1px ">
            <a style="width:150px;color:#367fa9;text-align:center" class="nav-link"
                href="{{ url('/remunerationedit/' . $model->id)}}"><b>Remuneration</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:120px;color:white;text-align:center" class="nav-link"
                href="{{ url('/statutoryedit/' . $model->id)}}"><b>Statutory</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:50px;color:white;text-align:center" class="nav-link"
                href="{{ url('/bankedit/' . $model->id)}}"><b>Bank</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:100px;color:white;text-align:center" class="nav-link"
                href="{{ url('/educationedit/' . $model->id)}}"><b>Education</b></a>
        </li>
        <!-- <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:180px;color:white;text-align:center" class="nav-link"
            href="{{ url('/certificateedit/' . $model->id)}}"><b>Cerificate</b></a>
        </li> -->
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:100px;color:white;text-align:center" class="nav-link"
                href="{{ url('/empfileedit/' . $model->id)}}"><b>Document</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:100px;color:white;text-align:center" class="nav-link"
                href="{{ url('/personaldetails_edit/' . $model->id)}}"><b>Personal</b></a>
        </li>
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:80px;color:white;text-align:center" class="nav-link"
                href="{{ url('/bgv_edit/' . $model->id)}}"><b>BGV</b></a>
        </li>
        <!-- <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:100px;color:white;text-align:center" class="nav-link"
                href="{{ url('/grievance_edit/' . $model->id)}}"><b>Grievance</b></a>
        </li> -->
        <li class="nav-item " style="background-color:#00a09d;border:1px solid white">
            <a style="width:80px;color:white;text-align:center" class="nav-link"
                href="{{ url('/exit_edit/' . $model->id)}}"><b>Exit</b></a>
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
                <form action="{{ url('/remunerationeditstore') }}" method="POST">
                    {{ csrf_field() }}


                    <div class="card-header" style="background-color:#BBDEFB;color: #000;font-size: 16px;">
                        <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;
                        Remuneration Details
                    </div>
                    <br>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="Salary" class="col-sm-2 form-label">Salary Structure</label>
                            <div class=" col-md-3">
                                <input type="hidden" name="empid" id="empid" class="form-control"
                                    value="{{$model->id}}">
                                <select class="form-control form-control-sm" name="salary_structure"
                                    id="salary_structure">
                                    <option></option>
                                    @foreach($salary_struct as $struct)
                                    <option value="{{$struct->salarystructure}}"
                                        {{ old('salary_structure', $rem->salary_structure) == $struct->salarystructure ? 'selected' : '' }}>
                                        {{ucfirst($struct->salarystructure)}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <label for="esi_applicability" class="col-sm-2 form-label">ESI Applicability</label>
                            <div class=" col-md-3">
                                <select class="form-control form-control-sm" name="esi_applicability">
                                    <option></option>
                                    <option value="Yes" {{$rem->esi_applicability== Yes ?'selected':''}}> Yes
                                    </option>
                                    <option value="No" {{$rem->esi_applicability== No ?'selected':''}}> No
                                    </option>
                                </select>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="pf_applicablity" class="col-sm-2 form-label">PF Applicablity</label>
                            <div class=" col-md-3">
                                <select class="form-control form-control-sm" name="pf_applicablity">
                                    <option></option>
                                    <option value="Yes" {{$rem->pf_applicablity== Yes ?'selected':''}}> Yes
                                    </option>
                                    <option value="No" {{$rem->pf_applicablity== No ?'selected':''}}> No
                                    </option>
                                </select>
                            </div>

                            <label for="restrict_pf" class="col-sm-2 form-label">Restrict PF</label>
                            <div class=" col-md-3">

                                <select class="form-control form-control-sm" name="restrict_pf">
                                    <option></option>
                                    <option value="Yes" {{$rem->restrict_pf== Yes ?'selected':''}}> Yes</option>
                                    <option value="No" {{$rem->restrict_pf== No ?'selected':''}}> No</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">

                            <label for="basic" class="col-sm-2 form-label"> Basic</label>
                            <div class=" col-md-3">
                                <input type="text" name="basic" id="basic" class="form-control" value="{{$rem->basic}}">
                            </div>

                            <label for="hra" class="col-sm-2 form-label">HRA</label>
                            <div class=" col-md-3">
                                <input type="text" name="hra" id="hra" class="form-control" value="{{$rem->hra}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="conveyance" class="col-sm-2 form-label">Conveyance</label>
                            <div class=" col-md-3">
                                <input type="text" name="conveyance" id="conveyance" class="form-control"
                                    value="{{$rem->conveyance}}">
                            </div>

                            <label for="medical" class="col-sm-2 form-label">Med.Allowance</label>
                            <div class=" col-md-3">
                                <input type="text" name="medical" id="medical" class="form-control"
                                    value="{{$rem->medical}}">
                            </div>
                        </div>

                        <div class="form-group row">

                            <label for="lta" class="col-sm-2 form-label">Edu.Allowance</label>
                            <div class=" col-md-3">
                                <input type="text" name="education" id="education" class="form-control"
                                    value="{{$rem->education}}">
                            </div>

                            <label for="splallowance" class="col-sm-2 form-label">Spl.Allowance</label>
                            <div class=" col-md-3">
                                <input type="text" name="splallowance" id="splallowance" class="form-control"
                                    value="{{$rem->splallowance}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pt" class="col-sm-2 form-label">Professional Tax</label>
                            <div class=" col-md-3">
                                <input type="text" name="pt" id="pt" class="form-control"
                                    value="{{$rem->professional_tax}}" required>
                            </div>
                            <label for="insurance" class="col-sm-2 form-label">Insurance</label>
                            <div class=" col-md-3">
                                <input type="text" name="insurance" id="insurance" class="form-control"
                                    value="{{$rem->insurance}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="gross_salary" class="col-sm-2 form-label">Gross Salary</label>
                            <div class=" col-md-3">
                                <input type="text" name="gross_salary" id="gross_salary" class="form-control"
                                    value="{{$rem->gross_salary}}">
                            </div>
                            <label for="netsalary" class="col-sm-2 form-label">Net Salary</label>
                            <div class=" col-md-3">
                                <input type="text" name="netsalary" id="netsalary" class="form-control"
                                    value="@if($rem->net_salary =='' || $rem->net_salary == 0){{$netsalary}}@else{{$rem->net_salary}}@endif"
                                    readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ctc" class="col-sm-2 form-label">CTC</label>
                            <div class=" col-md-3">
                                <input type="text" name="ctc" id="ctc" class="form-control"
                                    value="{{$rem->ctc?$rem->ctc:$ctc}}" readonly>
                            </div>
                            <div class=" col-md-3">
                                <input type="hidden" name="pf" id="pf" class="form-control" value="">
                                <input type="hidden" name="esi" id="esi" class="form-control" value="">

                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-1"></div>
                            <div class="col-md-2">
                                <a class="btn btn-dark" href="{{  url('/empdetails/'.$model->id.'/edit') }}"><i
                                        class="glyphicon glyphicon-chevron-left"></i> Back</a>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-plus"></i> Next
                                </button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @endsection
    @push('scripts')
    <script>
    var ssaltype = $('#salary_structure').val();

    $('#basic').prop("readonly", true);
    $('#hra').prop("readonly", true);
    $('#splallowance').prop("readonly", true);
    $('#conveyance').prop("readonly", true);
    $('#medical').prop("readonly", true);

    if (ssaltype == 'Modern') {
        $('#basic').prop("readonly", true);
        $('#hra').prop("readonly", true);
        $('#splallowance').prop("readonly", true);
        $('#conveyance').prop("readonly", true);
        $('#education').prop("readonly", true);
        $('#medical').prop("readonly", true);
        $('#gross_salary').prop("readonly", false);
    } else {
        $('#basic').prop("readonly", false);
        $('#hra').prop("readonly", false);
        $('#splallowance').prop("readonly", false);
        $('#conveyance').prop("readonly", false);
        $('#education').prop("readonly", false);
        $('#medical').prop("readonly", false);
        $('#gross_salary').prop("readonly", true);
    }

    $('#gross_salary').keyup(function(event) {
        var amt = $('#gross_salary').val();      
        var ssaltype = $('#salary_structure').val();       
        var pt = $('#pt').val();       
        var insurance = $('#insurance').val();
        $.ajax({
            type: "GET",
            url: "{{ url('/salarystructure') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                sla_structure: ssaltype,
                amount: amt,
                pt: pt,
                insurance: insurance,
            },
            dataType: 'json',

            success: function(data) {
                $('#basic').val(data.basic);
                $('#hra').val(data.hra);
                $('#conveyance').val(data.ca);
                $('#splallowance').val(data.spl);
                $('#pf').val(data.pf);
                $('#esi').val(data.esi);
                $('#netsalary').val(data.netsalary);
                $('#ctc').val(data.ctc);
            },
            error: function(exception) {
                //    alert('Something Error');
            },
        });
    });

    $('#salary_structure').change(function(event) {
        var ss = $('#salary_structure').val();
        $('#basic').val('');
        $('#hra').val('');
        $('#gross_salary').val('');
        $('#splallowance').val('');
        $('#conveyance').val('');
        $('#education').val('');
        $('#medical').val('');

        if (ss == 'Modern') {
            $('#basic').prop("readonly", true);
            $('#hra').prop("readonly", true);
            $('#splallowance').prop("readonly", true);
            $('#conveyance').prop("readonly", true);
            $('#medical').prop("readonly", true);
            $('#education').prop("readonly", true);
            $('#gross_salary').prop("readonly", false);
        } else {
            $('#basic').prop("readonly", false);
            $('#hra').prop("readonly", false);
            $('#splallowance').prop("readonly", false);
            $('#conveyance').prop("readonly", false);
            $('#education').prop("readonly", false);
            $('#medical').prop("readonly", false);
            $('#gross_salary').prop("readonly", true);
        }

        $('#basic,#hra,#conveyance,#splallowance,#education,#medical').keyup(function(event) {
            var data = +$('#basic').val() + +$('#hra').val() + +$('#conveyance').val() + +$(
                    '#splallowance').val() + +$('#education').val() + +$('#medical').val() + +$('#pt')
                .val();
            $('#gross_salary').val(data);
        });
    });
    </script>
    @endpush