<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpSalaryActual extends Model
{
    use HasFactory;
    protected $tabel = 'emp_salary_actuals';
    public $timestamps = false;

    public function employee()
    {
        return $this->belongsTo('App\Models\EmpDetails', 'empid','id');
    }
}
