<?php
namespace App\Exports;

use App\Models\EmpDetails;
use App\Models\Attendance;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProjectAttExport implements FromView
{
    public function view(): View
    {        
        $emp = EmpDetails::where(['project_id' => auth()->user()->project_id])->get();
        $attendance = Attendance::where(function ($query) use ($request) {

            $date_from = $request->has('date_from') ? $request->get('date_from') : null;
            $date_to = $request->has('date_to') ? $request->get('date_to') : null;
            if (isset($date_from) && isset($date_to)) {
                $query->whereBetween('date', [date('Y-m-d', strtotime($date_from)), date('Y-m-d', strtotime($date_to))]);

            }
            if (isset($request->employee)) {
                $query->where(['emp_id' => $request->employee]);
            }
            if (isset($request->status)) {
                $query->where(['status' => $request->status]);
            }
            $query->where(['project_id' => auth()->user()->project_id]);
        })->get();
        return view('employee.attendance-export', [
            'model' => $attendance,
            'modelEmp' => $emp,
        ]);
    }
}
?>