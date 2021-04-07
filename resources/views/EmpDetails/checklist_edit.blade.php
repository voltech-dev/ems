@extends('layouts.app')

@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Emp Details</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Check List </a></li>
        </ol>
    </div>
</div>
@endsection
<?php
error_reporting(0);
$projects = App\Models\ProjectDetails::all();
?>
@section('content')
<div class="ml-1">
    
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif		
		<div style="line-height:2; font-size:16px">
		<div > <h4> Check List </h4> </div>
		 <form action="{{ url('/chklststore') }}" method="POST">
		  @csrf
		 <input type="hidden" name="emp_id" value="{{$emp_id}}">
			<div class="row"><div class="col-md-4"> Updated Resume</div> <div class="col-md-1">  <input type="radio" id="yes" name="resume" value="yes" {{($chk->resume == 'yes') ? 'checked':''}}> Yes </div> <div class="col-md-1"><input type="radio" id="no" name="resume" value="no" {{($chk->resume == 'no') ? 'checked':''}}>  No</div> </div>
			<div class="row"> <div class="col-md-4">Evaluation Form </div> <div class="col-md-1"> <input type="radio" id="yes" name="evaluation" value="yes" {{($chk->evaluation == 'yes') ? 'checked':''}}> Yes </div> <div class="col-md-1"><input type="radio" id="no" name="evaluation" value="no" {{($chk->evaluation == 'no') ? 'checked':''}}>  No</div> </div>
			<div class="row"><div class="col-md-4">Application Form </div> <div class="col-md-1"> <input type="radio" id="yes" name="application" value="yes" {{($chk->application == 'yes') ? 'checked':''}}> Yes </div> <div class="col-md-1"><input type="radio" id="no" name="application" value="no" {{($chk->application == 'no') ? 'checked':''}}>  No</div> </div>
			<div class="row"><div class="col-md-4">CTC Structure approval form client </div> <div class="col-md-1"> <input type="radio" id="yes" name="ctc" value="yes" {{($chk->ctc == 'yes') ? 'checked':''}}> Yes </div> <div class="col-md-1"><input type="radio" id="no" name="ctc" value="no" {{($chk->ctc == 'no') ? 'checked':''}}>  No</div> </div>
			<div class="row"> <div class="col-md-4">Educational Certificates </div> <div class="col-md-1"> <input type="radio" id="yes" name="edu" value="yes" {{($chk->edu == 'yes') ? 'checked':''}}> Yes </div> <div class="col-md-1"><input type="radio" id="no" name="edu" value="no" {{($chk->edu == 'no') ? 'checked':''}}>  No</div> </div>
			<div class="row"><div class="col-md-4">Experience Certificate </div> <div class="col-md-1"> <input type="radio" id="yes" name="exp" value="yes" {{($chk->exp == 'yes') ? 'checked':''}}> Yes </div> <div class="col-md-1"><input type="radio" id="no" name="exp" value="no" {{($chk->exp == 'no') ? 'checked':''}}>  No</div> </div>
			<div class="row"> <div class="col-md-4">Relieving Certificate </div> <div class="col-md-1"> <input type="radio" id="yes" name="relieving" value="yes" {{($chk->relieving == 'yes') ? 'checked':''}}> Yes </div> <div class="col-md-1"><input type="radio" id="no" name="relieving" value="no" {{($chk->relieving == 'no') ? 'checked':''}}>  No</div> </div>
			<div class="row"> <div class="col-md-4">Payslips ( Last 3 months) </div> <div class="col-md-1"> <input type="radio" id="yes" name="payslip" value="yes" {{($chk->payslip == 'yes') ? 'checked':''}}> Yes </div> <div class="col-md-1"><input type="radio" id="no" name="payslip" value="no" {{($chk->payslip == 'no') ? 'checked':''}}>  No</div> </div>
			<div class="row"> <div class="col-md-4">Aadhar Card </div> <div class="col-md-1"> <input type="radio" id="yes" name="adhar" value="yes" {{($chk->adhar == 'yes') ? 'checked':''}}> Yes </div> <div class="col-md-1"><input type="radio" id="no" name="adhar" value="no" {{($chk->adhar == 'no') ? 'checked':''}}>  No</div> </div>
			<div class="row"> <div class="col-md-4">PAN Card </div> <div class="col-md-1"> <input type="radio" id="yes" name="pan" value="yes"{{($chk->pan == 'yes') ? 'checked':''}}> Yes </div> <div class="col-md-1"><input type="radio" id="no" name="pan" value="no" {{($chk->pan == 'no') ? 'checked':''}}>  No</div> </div>
			<div class="row"> <div class="col-md-4">Bank Passbook </div> <div class="col-md-1"> <input type="radio" id="yes" name="passbook" value="yes" {{($chk->passbook == 'yes') ? 'checked':''}}> Yes </div> <div class="col-md-1"><input type="radio" id="no" name="passbook" value="no" {{($chk->passbook == 'no') ? 'checked':''}}>  No</div> </div>
			<div class="row"> <div class="col-md-4">Cancelled Cheque </div> <div class="col-md-1"> <input type="radio" id="yes" name="cheque" value="yes" {{($chk->cheque == 'yes') ? 'checked':''}}> Yes </div> <div class="col-md-1"><input type="radio" id="no" name="cheque" value="no" {{($chk->cheque == 'no') ? 'checked':''}}>  No</div> </div>
			<div class="row"> <div class="col-md-4">Scanned Passport size photo </div> <div class="col-md-1"> <input type="radio" id="yes" name="passport" value="yes"{{($chk->passport == 'yes') ? 'checked':''}}> Yes </div> <div class="col-md-1"><input type="radio" id="no" name="passport" value="no" {{($chk->passport == 'no') ? 'checked':''}}>  No</div> </div>
			 <div class="form-row">
                    <div class="col-md-3"></div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success">
                             Submit
                        </button>
                    </div>
                    <div class="col-md-1"></div>
                    <!--<div class="col-md-2">
                        <a class="btn btn-dark" href="{{ url('/attendance-view') }}"><i
                                class="glyphicon glyphicon-chevron-left"></i>
                            Back</a>
                    </div>-->
                </div>
		</form>
		</div>
		<br><br><br>
    </div>


@endsection
@push('scripts')
<script type="text/javascript">

</script>
@endpush