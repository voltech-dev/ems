@extends('layouts.app')
<style type="text/css">
.Table {
    display: table;
    width: 100%;
}

.Title {

    text-align: left;
    font-weight: bold;
    font-size: larger;
}

.Heading {
    display: table-row;
    font-weight: bold;
    text-align: center;
}

.Row {
    display: table-row;
}

.Cell {
    display: table-cell;
    border: solid;
    border-width: thin;
    padding-left: 5px;
    padding-right: 5px;
}

.left-panel1 {
    /*border-right: 1px solid #ccc;*/
    min-width: 200px;
    /*padding: 20px 16px 0 0;*/
    float: left;
}

.right-panel1 {

    /*padding: 10px 0  0 16px;*/
    float: right;
}

#scope1 {
    /*border-top: 1px solid #ccc;
		border-bottom: 1px solid #ccc;*/
    padding: 7px 0 4px 0;
    display: flex;
    justify-content: space-around;
}

.contribution .title {
    font-size: 15px;
    font-weight: 700;
    border-bottom: 1px solid #ccc;
    padding-bottom: 4px;
    margin-bottom: 6px;
}
</style>

@section('header')
<div class="grid grid-cols-1 md:grid-cols-2">
    <div class="page-leftheader">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Payroll</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Salary {{$model->employee->emp_name}}</a>
            </li>
        </ol>
    </div>
</div>
@endsection
<?php
error_reporting(0);

?>
@section('content')
<div class="p-6">
    <div class="ml-1">
        <div class="mt-1 text-gray-600 dark:text-gray-400 text-sm">
            <div id="payslip">
                <div id="scope1">

                    <div class="left-panel1">
                        <div class="title"><img src="{{url('/images/logo.png')}}" alt="Image" /> </div>

                    </div>
                    <div class="right-panel1">
                        <div class="Heading">Voltech Engineers Private Limited</div>
                        <div class="value">Voltech Eco Tower,</div>
                        <div class="value">#2/429,Mount Poonamallee Road</div>
                        <div class="value">Ayyappanthangal, Chennai-600056</div>
                        <div class="value">Ph.:+91-44-43978000, Fax:044-42867746</div>
                        <div class="value">Web:www.voltechgroup.com</div>
                    </div>

                </div>
                </br>
                <div id="scope">

                    <div class="scope-entry">
                        <div class="value">Payslip for the month of {{ date('F , Y', strtotime($model->month))}}
                        </div>

                    </div>
                </div>
                <div class="contentpay">
                    <div class="left-panel">
                        <div id="employee">
                            <div id="name"> <?= $model->employee->emp_name ?></div>
                        </div>
                        <div class="ytd">
                            <div class="title">Employee Details</div>
                            <div class="entry">
                                <div>Emp ID</div>
                                <div class="value"><?= $model->employee->emp_code ?></div>
                            </div>
                            <div class="entry">
                                <div>Designation</div>
                                <div class="value"><?= $model->employee->designation->designation_name ?></div>
                            </div>

                            <div class="entry">
                                <div>PF No.</div>
                                <div class="value"><?= $model->employee->statutory->epfno ?></div>
                            </div>
                            <div class="entry">
                                <div>ESI No.</div>
                                <div class="value"><?= $model->employee->statutory->esino ?></div>
                            </div>
                            <div class="entry">
                                <div>UAN</div>
                                <div class="value"><?= $model->employee->statutory->epfuanno ?></div>
                            </div>
                            <div class="entry">
                                <div>Doj</div>
                                <div class="value">{{ date('d/m/Y', strtotime($model->date_of_joining))}}
                                </div>
                            </div>
                            <div class="entry">
                                <div>Paid days</div>
                                <div class="value"><?=$model->paiddays?></div>
                            </div>

                        </div>

                        <div class="contributions">
                            <div class="title">Employer Contribution</div>
                            <?php if($model->pf_employer_contribution) {?>
                            <div class="entry">
                                <div>PF</div>
                                <div class="value"><?=$model->pf_employer_contribution?></div>
                            </div>
                            <?php } if($model->esi_employer_contribution) {?>
                            <div class="entry">
                                <div>ESI</div>
                                <div class="value"><?=$model->esi_employer_contribution?></div>
                            </div>

                            <?php }  if($gpa_amt !=0) { ?>
                            <div class="entry">
                                <div>GPA</div>
                                <div class="value"><?=$gpa_amt?></div>
                            </div>
                            <?php } if($gmc_amt !=0) { ?>
                            <div class="entry">
                                <div>GMC</div>
                                <div class="value"><?=$gmc_amt?></div>
                            </div>
                            <?php } ?>

                            <br>
                            <div class="entry"
                                style="padding: 5px 0 5px 0; background: rgba(0, 0, 0, 0.04);font-weight: 700;">
                                <div>CTC</div>
                                <div class="value"><?=$model->earned_ctc + $gpa_amt + $gmc_amt ?></div>
                            </div>

                        </div>

                    </div>
                    <div class="right-panel">
                        <div class="details">
                            <div class="contribution">
                                <div class="title">Components &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actual&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Earnings
                                </div>
                            </div>
                            <div class="salary">
                                <?php if($model->basic) {?>
                                <div class="entry">
                                    <div style="width:100px;">Base Pay</div>

                                    <div class="rate"><?=$actual->basic?> </div>
                                    <div class="amount"><?=$model->basic?></div>
                                </div>
                                <?php } if($model->hra) {?>
                                <div class="entry">
                                    <div style="width:100px;">HRA</div>

                                    <div class="rate"><?=$actual->hra?> </div>
                                    <div class="amount"><?=$model->hra?></div>
                                </div>
                                <?php } if($model->spl_allowance) {?>
                                <div class="entry">
                                    <div style="width:100px;">Spl. allowance</div>

                                    <div class="rate"><?=$actual->splallowance?></div>
                                    <div class="amount"><?=$model->spl_allowance?></div>
                                </div>
                                <?php }if($model->over_time) {?>
                                <div class="entry">
                                    <div style="width:100px;">Over Time</div>

                                    <div class="rate"></div>
                                    <div class="amount"><?=$model->over_time?></div>
                                </div>
                                <?php } if($model->medical_earning) {?>
                                <div class="entry">
                                    <div style="width:100px;">Medical</div>

                                    <div class="rate"><?=$actual->medical?></div>
                                    <div class="amount"><?=$model->medical_earning?></div>
                                </div>

                                <?php } if($model->conveyance_earning) {?>
                                <div class="entry">
                                    <div style="width:100px;">Conveyance</div>

                                    <div class="rate"><?=$actual->conveyance?></div>
                                    <div class="amount"><?=$model->conveyance_earning?></div>
                                </div>
                                <?php } if($model->education_earning) {?>
                                <div class="entry">
                                    <div style="width:100px;">Education</div>

                                    <div class="rate"><?=$actual->education?></div>
                                    <div class="amount"><?=$model->education_earning?></div>
                                </div>
                                <?php }?>
                            </div>

                            <div class="net_pay">
                                <div class="entry">
                                    <div>Gross Earnings</div>
                                    <div class="detail"></div>
                                    <div> <?=$actual->gross?></div>
                                    <div class="amount"><?=	$model->total_earning?></div>
                                </div>
                            </div>

                            <div class="contribution">
                                <div class="title" style="text-align:right">Deductions</div>
                            </div>
                            <div class="salary">
                                <?php if($model->pf) { ?>
                                <div class="entry">
                                    <div>EPF</div>
                                    <div class="detail"></div>
                                    <div class="rate"></div>
                                    <div class="amount"><?=$model->pf?></div>
                                </div>
                                <?php } if($model->insurance) {?>
                                <div class="entry">
                                    <div>Insurance</div>
                                    <div class="detail"></div>
                                    <div class="rate"></div>
                                    <div class="amount"><?=$model->insurance?></div>
                                </div>
                                <?php } if($model->professional_tax) {?>
                                <div class="entry">
                                    <div>Professional tax</div>
                                    <div class="detail"></div>
                                    <div class="rate"></div>
                                    <div class="amount"><?=$model->professional_tax?></div>
                                </div>
                                <?php } if($model->esi) {?>
                                <div class="entry">
                                    <div>ESI</div>
                                    <div class="detail"></div>
                                    <div class="rate"></div>
                                    <div class="amount"><?=$model->esi?></div>
                                </div>
                                <?php } if($model->advance) {?>
                                <div class="entry">
                                    <div>Advance</div>
                                    <div class="detail"></div>
                                    <div class="rate"></div>
                                    <div class="amount"><?=$model->advance?></div>
                                </div>
                                <?php } if($model->tes) {?>
                                <div class="entry">
                                    <div>TES</div>
                                    <div class="detail"></div>
                                    <div class="rate"></div>
                                    <div class="amount"><?=$model->tes?></div>
                                </div>
                                <?php } if($model->caution_deposit) {?>
                                <div class="entry">
                                    <div>Caution Deposit</div>
                                    <div class="detail"></div>
                                    <div class="rate"></div>
                                    <div class="amount"><?=$model->caution_deposit?></div>
                                </div>
                                <?php } if($model->mobile) {?>
                                <div class="entry">
                                    <div>Mobile</div>
                                    <div class="detail"></div>
                                    <div class="rate"></div>
                                    <div class="amount"><?=$model->mobile?></div>
                                </div>
                                <?php } if($model->loan) {?>
                                <div class="entry">
                                    <div>Loan</div>
                                    <div class="detail"></div>
                                    <div class="rate"></div>
                                    <div class="amount"><?=$model->loan?></div>
                                </div>
                                <?php } if($model->rent) {?>
                                <div class="entry">
                                    <div>Rent</div>
                                    <div class="detail"></div>
                                    <div class="rate"></div>
                                    <div class="amount"><?=$model->rent?></div>
                                </div>
                                <?php } if($model->tds) {?>
                                <div class="entry">
                                    <div>TDS</div>
                                    <div class="detail"></div>
                                    <div class="rate"></div>
                                    <div class="amount"><?=$model->tds?></div>
                                </div>
                                <?php } if($model->lwf) {?>
                                <div class="entry">
                                    <div>LWF</div>
                                    <div class="detail"></div>
                                    <div class="rate"></div>
                                    <div class="amount"><?=$model->lwf?></div>
                                </div>
                                <?php } if($model->other_deduction) {?>
                                <div class="entry">
                                    <div>Other deductions</div>
                                    <div class="detail"></div>
                                    <div class="rate"></div>
                                    <div class="amount"><?=$model->other_deduction?></div>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="net_pay">
                                <div class="entry">
                                    <div>Total Deduction</div>
                                    <div class="detail"></div>
                                    <div class="rate"></div>
                                    <div class="amount"><?=$model->total_deduction?></div>
                                </div>
                            </div>

                            <div class="contribution">
                                <div class="title" style="text-align:right">Allowance</div>
                            </div>
                            <div class="salary">
                                <?php if($model->conveyance_allowance) { ?>
                                <div class="entry">
                                    <div>Conveyance</div>
                                    <div class="detail"></div>
                                    <div class="rate"></div>
                                    <div class="amount"><?=$model->conveyance_allowance?></div>
                                </div>

                                <?php }if($model->laptop_allowance) { ?>
                                <div class="entry">
                                    <div>Laptop</div>
                                    <div class="detail"></div>
                                    <div class="rate"></div>
                                    <div class="amount"><?=$model->laptop_allowance?></div>
                                </div>

                                <?php }if($model->travel_allowance) { ?>
                                <div class="entry">
                                    <div>Travel</div>
                                    <div class="detail"></div>
                                    <div class="rate"></div>
                                    <div class="amount"><?=$model->travel_allowance?></div>
                                </div>

                                <?php }if($model->mobile_allowance) { ?>
                                <div class="entry">
                                    <div>Mobile</div>
                                    <div class="detail"></div>
                                    <div class="rate"></div>
                                    <div class="amount"><?=$model->mobile_allowance?></div>
                                </div>

                                <?php } ?>
                            </div>

                            <div class="net_pay">
                                <div class="entry">
                                    <div>Total allowance</div>
                                    <div class="detail"></div>
                                    <div class="rate"></div>
                                    <div class="amount">
                                        <?=$model->mobile_allowance +$model->travel_allowance + $model->laptop_allowance + $model->conveyance_allowance?>
                                    </div>
                                </div>
                            </div>

                            <div class="net_pay">
                                <div class="entry">
                                    <div>NET PAY</div>
                                    <div class="detail"></div>
                                    <div class="rate"></div>
                                    <div class="amount"><?=$model->net_amount?></div>
                                </div></br>
                                <div class="entry">
                                    <div>In words:</div>
                                    <div></div>
                                </div>
                            </div>
                            <p></p>

                        </div>
                    </div>
                    </br>
                </div>
                <div id="scope">
                    <div class="scope-entry">
                        <div class="">This is a system generated payslip. Hence signature not required.</div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


@endsection