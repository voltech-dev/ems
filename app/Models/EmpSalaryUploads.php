<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  EmpSalaryUploads extends Model
{
    use HasFactory;
    protected $tabel='emp_salary_uploads';

    public function emp()
    {
        return $this->belongsTo('App\Models\EmpDetails', 'empid','id');
    }
}
