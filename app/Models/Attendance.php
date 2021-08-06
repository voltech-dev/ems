<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmpDetails;

class Attendance extends Model
{
    use HasFactory;
    protected $table ='emp_attendance';
    public function employee()
    {
        return $this->belongsTo('App\Models\EmpDetails', 'emp_id');
    }
   
}
