<?php
namespace App\Exports;
use App\Models\EmpDetails;
use App\Models\LeaveBalance;
use App\Models\ProjectDetails;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class LeaveBalanceExport implements FromView
{
    public function view(): View
    {
        return view('empdetails.leavebalanceexport', ['model' => LeaveBalance::all()]);
      //  return view('empdetails.leavebalance',['model'=>LeaveBalance::all()]);

    }
}
