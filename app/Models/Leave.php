<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;
    protected $table ='emp_leave';

    public function employee()
    {
        return $this->belongsTo('App\Models\EmpDetails', 'emp_id');
    }
}
