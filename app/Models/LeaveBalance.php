<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveBalance extends Model
{
    use HasFactory;
    protected $table ='leave_balance';
    public $timestamps = false;
    
    public function employee()
    {
        return $this->belongsTo('App\Models\EmpDetails', 'emp_id');
    }
}
