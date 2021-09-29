<?php
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Attendance;
use App\Models\Leave;
error_reporting(0);
$day=$day;
$y = $y;
for($d=1; $d<=31; $d++)
{
    $time=mktime(12, 0, 0, $day, $d, $y);          
    if (date('m', $time)==$day)       
    $list[] = date('d', $time);
}
$first = current($list);
$last = end($list); 
$firstdate = $y."-".$day."-".$first;
$lastdate = $y."-".$day."-".$last;    
?>
<table class="table table-bordered text-nowrap table-hover" id="tblData" width="100%"
                style="font-size: 0.575rem; padding:0px;">
                <thead>
                    <tr>                       
                        <th>SI</th>
                        <th>Emp Code</th>
                        <th>Employee</th>
                        <th>Project</th>
                        <?php 
                            for($d=1; $d<=$last; $d++)
                            {
                            $time=mktime(12, 0, 0, $day, $d, $y);          
                            if (date('m', $time)==$day)   
                        ?>
                        <th><?php echo date('d', $time);?></th>
                        <?php
                        }
                        ?>
                        <th>Month Days</th>
                        <th>No of Days Present</th>
                        <th>No of Days Absent</th>
                        <th>No of Days Paid Leave</th>
                        <th>C.off</th>
                        <th>Holidays</th>
                        <th>Total Paid Days</th>
                        <th>Lop</th>
                        <th>Leave Balance Per Month</th>
                        <th>Total Leave Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($model as $models)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$models->emp_code}}</td>
                        <td>{{$models->emp_name}}</td>
                        <td>{{$models->project->project_name}}</td>
                        @for($i = 1; $i <= $last; $i++) <?php
                            $make_date = $y."-".$month."-".$i;         
                            if(Attendance::where(['emp_id'=>$models->id,'date'=> $make_date,'status'=>"Present"])->exists()) { 
                                $attendance_for_day ="P";
                            }elseif(Attendance::where(['emp_id'=>$models->id,'date'=> $make_date,'status'=>"Half-Day"])->exists()) {
                                $attendance_for_day ="H/D";
                            }elseif($var = Attendance::where(['emp_id'=>$models->id,'date'=> $make_date,'status'=>"Absent"])->exists()) {
                                $attendance_for_day ="A"; 
                            }elseif(Attendance::where(['emp_id'=>$models->id,'date'=> $make_date,'status'=>"Waiting for Punch"])->exists()) {
                                $attendance_for_day ="W";
                            }elseif(Attendance::where(['emp_id'=>$models->id,'date'=> $make_date,'status'=>"W.O"])->exists()) {
                                $attendance_for_day ="W.O";
                            }elseif(Attendance::where(['emp_id'=>$models->id,'date'=> $make_date,'status'=>"Holiday"])->exists()) {
                                $attendance_for_day ="H";
                            }else{
                                $attendance_for_day ="-"; 
                            }              
                        ?> <td>{{$attendance_for_day}}</td>
                            @endfor

                            <td class="missed-col"><?php echo end($list);?></td>
                            <td class="missed-col">{{$models->present($models->id,$day,$y)}}</td>
                            <td class="missed-col">{{$models->absent($models->id,$day,$y)}}</td>
                            <td class="missed-col">{{$models->paidleave($models->id,$day,$y)}}</td>
                            <td class="missed-col">{{$models->compoff($models->id,$day,$y)}}</td>
                            <td class="missed-col">{{$models->holidays($models->project_id,$day,$y)}}</td>
                            <td class="missed-col">
                                {{$models->present($models->id,$day,$y)+$models->paidleave($models->id,$day,$y)+$models->compoff($models->id,$day,$y)+$models->holidays($models->project_id,$day,$y)-$models->weakoffleave($models->id,$day,$y)-$models->unpaidleave($models->id,$day,$y)}}
                            </td>
                            <td class="missed-col">
                                {{$models->lop($models->id,$day,$y)-$models->present($models->id,$day,$y)-$models->paidleave($models->id,$day,$y)-$models->compoff($models->id,$day,$y)-$models->holidays($models->project_id,$day,$y)-$models->weakoffleave($models->id,$day,$y)-$models->unpaidleave($models->id,$day,$y)-$models->leavemonthpermit($models->id,$day,$y)}}
                            </td>
                            <td class="missed-col">{{$models->leavemonthpermit($models->id,$day,$y)}}</td>
                            <td class="missed-col">{{$models->leavebalance($models->id)}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>