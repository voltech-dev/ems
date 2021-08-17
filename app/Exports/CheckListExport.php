<?php
namespace App\Exports;
use App\Models\EmpDetails;
use App\Models\Doc_type;
use App\Models\ProjectDetails;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class CheckListExport implements FromView
{
    public function view(): View
    {
        $emp= EmpDetails::all();
        $doc = Doc_type::all();
        $project = ProjectDetails::all();
        // return view('exports.invoices', [
        //     'invoices' => Invoice::all()
        // ]);
       // $emp = CheckListExport::all();
        return view('EmpDetails.chklist',['model'=>$doc,'emp'=>$emp]);
    }
}
