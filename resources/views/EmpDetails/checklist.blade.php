@extends('layouts.app')

@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Emp Details</a></li>
            <li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Check List </a></li>
        </ol>
    </div>
</div>
<br>

<div class="col text-right"> <button onclick="location.href='{{url('/checklist_edit/'.$emp_id)}}'"
        class="btn-success">Edit</button>
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
        <div class="pt-3">
            <h3> On-boarding Compliance </h3>
        </div>
        <input type="hidden" name="emp_id" value="{{$emp_id}}">

        <div class="form-group">
            <table class="table table-bordered text-nowrap" id="example1">
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Interview Evaluation Form</td>
                        <td><input type="radio" id="yes" name="evaluation" value="yes"
                                {{($chk->evaluation == 'yes') ? 'checked':''}}> Yes </td>
                        <td><input type="radio" id="no" name="evaluation" value="no"
                                {{($chk->evaluation == 'no') ? 'checked':''}}> No</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Updated Resume</td>
                        <td><input type="radio" id="yes" name="resume" value="yes"
                                {{($chk->resume == 'yes') ? 'checked':''}}> Yes </td>
                        <td><input type="radio" id="no" name="resume" value="no"
                                {{($chk->resume == 'no') ? 'checked':''}}> No</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Employee Application Form</td>
                        <td><input type="radio" id="yes" name="application" value="yes"
                                {{($chk->application == 'yes') ? 'checked':''}}> Yes </td>
                        <td><input type="radio" id="no" name="application" value="no"
                                {{($chk->application == 'no') ? 'checked':''}}> No</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Relieving / Application Form</td>
                        <td><input type="radio" id="yes" name="relieving" value="yes"
                                {{($chk->relieving == 'yes') ? 'checked':''}}> Yes </td>
                        <td><input type="radio" id="no" name="relieving" value="no"
                                {{($chk->relieving == 'no') ? 'checked':''}}> No</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Degree Certificate & Marksheet</td>
                        <td><input type="radio" id="yes" name="edu" value="yes" {{($chk->edu == 'yes') ? 'checked':''}}>
                            Yes </td>
                        <td><input type="radio" id="no" name="edu" value="no" {{($chk->edu == 'no') ? 'checked':''}}> No
                        </td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>Salary Slip Last 3 Months</td>
                        <td><input type="radio" id="yes" name="payslip" value="yes"
                                {{($chk->payslip == 'yes') ? 'checked':''}}> Yes </td>
                        <td><input type="radio" id="no" name="payslip" value="no"
                                {{($chk->payslip == 'no') ? 'checked':''}}> No</td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>Aadhar Card</td>
                        <td><input type="radio" id="yes" name="adhar" value="yes"
                                {{($chk->adhar == 'yes') ? 'checked':''}}> Yes </td>
                        <td><input type="radio" id="no" name="adhar" value="no"
                                {{($chk->adhar == 'no') ? 'checked':''}}> No</td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td>PAN Card</td>
                        <td><input type="radio" id="yes" name="pan" value="yes" {{($chk->pan == 'yes') ? 'checked':''}}>
                            Yes </td>
                        <td><input type="radio" id="no" name="pan" value="no" {{($chk->pan == 'no') ? 'checked':''}}> No
                        </td>
                    </tr>
                    <tr>
                        <td>9</td>
                        <td>EPF / ESI Account Details</td>
                        <td><input type="radio" id="yes" name="epf" value="yes" {{($chk->epf == 'yes') ? 'checked':''}}>
                            Yes </td>
                        <td><input type="radio" id="no" name="epf" value="no" {{($chk->epf == 'no') ? 'checked':''}}> No
                        </td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td>Bank Passbook</td>
                        <td><input type="radio" id="yes" name="passbook" value="yes"
                                {{($chk->passbook == 'yes') ? 'checked':''}}> Yes </td>
                        <td><input type="radio" id="no" name="passbook" value="no"
                                {{($chk->passbook == 'no') ? 'checked':''}}> No</td>
                    </tr>
                    <tr>
                        <td>11</td>
                        <td>Cancelled Cheque</td>
                        <td><input type="radio" id="yes" name="cheque" value="yes"
                                {{($chk->cheque == 'yes') ? 'checked':''}}> Yes </td>
                        <td><input type="radio" id="no" name="cheque" value="no"
                                {{($chk->cheque == 'no') ? 'checked':''}}> No</td>
                    </tr>
                    <tr>
                        <td>12</td>
                        <td>Passport Size Photo</td>
                        <td><input type="radio" id="yes" name="passport" value="yes"
                                {{($chk->passport == 'yes') ? 'checked':''}}> Yes </td>
                        <td><input type="radio" id="no" name="passport" value="no"
                                {{($chk->passport == 'no') ? 'checked':''}}> No</td>
                    </tr>
                    <tr>
                        <td>13</td>
                        <td>MIS Form</td>
                        <td><input type="radio" id="yes" name="mis" value="yes" {{($chk->mis == 'yes') ? 'checked':''}}>
                            Yes </td>
                        <td><input type="radio" id="no" name="mis" value="no" {{($chk->mis == 'no') ? 'checked':''}}> No
                        </td>
                    </tr>
                    <tr>
                        <td>14</td>
                        <td>Police Clearance Certificate(PCC)</td>
                        <td><input type="radio" id="yes" name="pcc" value="yes" {{($chk->pcc == 'yes') ? 'checked':''}}>
                            Yes </td>
                        <td><input type="radio" id="no" name="pcc" value="no" {{($chk->pcc == 'no') ? 'checked':''}}> No
                        </td>
                    </tr>
                    <tr>
                        <td>15</td>
                        <td>Acceptable Usage Policy(AUP) - Signed Copy</td>
                        <td><input type="radio" id="yes" name="aup" value="yes" {{($chk->aup == 'yes') ? 'checked':''}}>
                            Yes </td>
                        <td><input type="radio" id="no" name="aup" value="no" {{($chk->aup == 'no') ? 'checked':''}}> No
                        </td>
                    </tr>
                    <tr>
                        <td>16</td>
                        <td>Non Disclosure Agreement(NDA) - Signed Copy</td>
                        <td><input type="radio" id="yes" name="nda" value="yes" {{($chk->nda == 'yes') ? 'checked':''}}>
                            Yes </td>
                        <td><input type="radio" id="no" name="nda" value="no" {{($chk->nda == 'no') ? 'checked':''}}> No
                        </td>
                    </tr>
                    <tr>
                        <td>17</td>
                        <td>Signed Offer Letter</td>
                        <td><input type="radio" id="yes" name="sol" value="yes" {{($chk->sol == 'yes') ? 'checked':''}}>
                            Yes </td>
                        <td><input type="radio" id="no" name="sol" value="no" {{($chk->sol == 'no') ? 'checked':''}}> No
                        </td>
                    </tr>
                    <tr>
                        <td>18</td>
                        <td>BGV Report</td>
                        <td><input type="radio" id="yes" name="report" value="yes"
                                {{($chk->report == 'yes') ? 'checked':''}}> Yes </td>
                        <td><input type="radio" id="no" name="report" value="no"
                                {{($chk->report == 'no') ? 'checked':''}}> No</td>
                    </tr>
                    <tr>
                        <td>19</td>
                        <td>ID Card</td>
                        <td><input type="radio" id="yes" name="id" value="yes" {{($chk->id_card == 'yes') ? 'checked':''}}>
                            Yes </td>
                        <td><input type="radio" id="no" name="id" value="no" {{($chk->id_card == 'no') ? 'checked':''}}>
                            No</td>
                    </tr>
                    <tr>
                        <td>20</td>
                        <td>CTC Structured Approved from Client</td>
                        <td><input type="radio" id="yes" name="ctc" value="yes" {{($chk->ctc == 'yes') ? 'checked':''}}>
                            Yes </td>
                        <td><input type="radio" id="no" name="ctc" value="no" {{($chk->ctc == 'no') ? 'checked':''}}> No
                        </td>
                    </tr>
                    <tr>
                        <td>21</td>
                        <td>Experience Certificate</td>
                        <td><input type="radio" id="yes" name="exp" value="yes" {{($chk->exp == 'yes') ? 'checked':''}}>
                            Yes </td>
                        <td><input type="radio" id="no" name="exp" value="no" {{($chk->exp == 'no') ? 'checked':''}}> No
                        </td>
                    </tr>
                    <!-- <tr>
                        <td>22</td>
                        <td>EPF / ESI Account Details</td> 
                        <td><input type="radio" id="yes" name="epf" value="yes" {{($chk->epf == 'yes') ? 'checked':''}}>
                            Yes </td>
                        <td><input type="radio" id="no" name="epf" value="no" {{($chk->epf == 'no') ? 'checked':''}}> No
                        </td>
                    </tr> -->
                </tbody>
            </table>
        </div>
        <!-- <div class="row"><div class="col-md-4"> Updated Resume</div> <div class="col-md-1">  <input type="radio" id="yes" name="resume" value="yes" {{($chk->resume == 'yes') ? 'checked':''}}> Yes </div> <div class="col-md-1"><input type="radio" id="no" name="resume" value="no" {{($chk->resume == 'no') ? 'checked':''}}>  No</div> </div>
			<div class="row"> <div class="col-md-4">Evaluation Form </div> <div class="col-md-1"> <input type="radio" id="yes" name="evaluation" value="yes" {{($chk->evaluation == 'yes') ? 'checked':''}}> Yes </div> <div class="col-md-1"><input type="radio" id="no" name="evaluation" value="no" {{($chk->evaluation == 'no') ? 'checked':''}}>  No</div> </div> -->
        <!-- <div class="row"><div class="col-md-4">Application Form </div> <div class="col-md-1"> <input type="radio" id="yes" name="application" value="yes" {{($chk->application == 'yes') ? 'checked':''}}> Yes </div> <div class="col-md-1"><input type="radio" id="no" name="application" value="no" {{($chk->application == 'no') ? 'checked':''}}>  No</div> </div> -->
        <!-- <div class="row"><div class="col-md-4">CTC Structure approval form client </div> <div class="col-md-1"> <input type="radio" id="yes" name="ctc" value="yes" {{($chk->ctc == 'yes') ? 'checked':''}}> Yes </div> <div class="col-md-1"><input type="radio" id="no" name="ctc" value="no" {{($chk->ctc == 'no') ? 'checked':''}}>  No</div> </div> -->
        <!-- <div class="row"> <div class="col-md-4">Educational Certificates </div> <div class="col-md-1"> <input type="radio" id="yes" name="edu" value="yes" {{($chk->edu == 'yes') ? 'checked':''}}> Yes </div> <div class="col-md-1"><input type="radio" id="no" name="edu" value="no" {{($chk->edu == 'no') ? 'checked':''}}>  No</div> </div> -->
        <!-- <div class="row"><div class="col-md-4">Experience Certificate </div> <div class="col-md-1"> <input type="radio" id="yes" name="exp" value="yes" {{($chk->exp == 'yes') ? 'checked':''}}> Yes </div> <div class="col-md-1"><input type="radio" id="no" name="exp" value="no" {{($chk->exp == 'no') ? 'checked':''}}>  No</div> </div> -->
        <!-- <div class="row"> <div class="col-md-4">Relieving Certificate </div> <div class="col-md-1"> <input type="radio" id="yes" name="relieving" value="yes" {{($chk->relieving == 'yes') ? 'checked':''}}> Yes </div> <div class="col-md-1"><input type="radio" id="no" name="relieving" value="no" {{($chk->relieving == 'no') ? 'checked':''}}>  No</div> </div> -->
        <!-- <div class="row"> <div class="col-md-4">Payslips ( Last 3 months) </div> <div class="col-md-1"> <input type="radio" id="yes" name="payslip" value="yes" {{($chk->payslip == 'yes') ? 'checked':''}}> Yes </div> <div class="col-md-1"><input type="radio" id="no" name="payslip" value="no" {{($chk->payslip == 'no') ? 'checked':''}}>  No</div> </div> -->
        <!-- <div class="row"> <div class="col-md-4">Aadhar Card </div> <div class="col-md-1"> <input type="radio" id="yes" name="adhar" value="yes" {{($chk->adhar == 'yes') ? 'checked':''}}> Yes </div> <div class="col-md-1"><input type="radio" id="no" name="adhar" value="no" {{($chk->adhar == 'no') ? 'checked':''}}>  No</div> </div> -->
        <!-- <div class="row"> <div class="col-md-4">PAN Card </div> <div class="col-md-1"> <input type="radio" id="yes" name="pan" value="yes"{{($chk->pan == 'yes') ? 'checked':''}}> Yes </div> <div class="col-md-1"><input type="radio" id="no" name="pan" value="no" {{($chk->pan == 'no') ? 'checked':''}}>  No</div> </div> -->
        <!-- <div class="row"> <div class="col-md-4">Bank Passbook </div> <div class="col-md-1"> <input type="radio" id="yes" name="passbook" value="yes" {{($chk->passbook == 'yes') ? 'checked':''}}> Yes </div> <div class="col-md-1"><input type="radio" id="no" name="passbook" value="no" {{($chk->passbook == 'no') ? 'checked':''}}>  No</div> </div>
			<div class="row"> <div class="col-md-4">Cancelled Cheque </div> <div class="col-md-1"> <input type="radio" id="yes" name="cheque" value="yes" {{($chk->cheque == 'yes') ? 'checked':''}}> Yes </div> <div class="col-md-1"><input type="radio" id="no" name="cheque" value="no" {{($chk->cheque == 'no') ? 'checked':''}}>  No</div> </div>
			<div class="row"> <div class="col-md-4">Scanned Passport size photo </div> <div class="col-md-1"> <input type="radio" id="yes" name="passport" value="yes"{{($chk->passport == 'yes') ? 'checked':''}}> Yes </div> <div class="col-md-1"><input type="radio" id="no" name="passport" value="no" {{($chk->passport == 'no') ? 'checked':''}}>  No</div> </div> -->


    </div>
    <br><br><br>
</div>


@endsection
@push('scripts')
<script type="text/javascript">

</script>
@endpush