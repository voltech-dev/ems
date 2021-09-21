<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpSalary extends Model
{
    use HasFactory;
    protected $tabel = 'emp_salaries';

    public function employee()
    {
        return $this->belongsTo('App\Models\EmpDetails', 'empid','id');
    }
} 
