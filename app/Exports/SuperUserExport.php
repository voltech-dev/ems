<?php
namespace App\Exports;
use App\Models\User;
use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SuperUserExport implements WithHeadings, WithTitle, ShouldAutoSize, WithEvents, FromCollection
{
    public function headings(): array
    {
        return [
            ['Employee Name', 'Date', 'In Time', 'Out Time','Status','Remarks']
        ];
    }
    public function title(): string
    {
        return 'Cases';
    }

    
}