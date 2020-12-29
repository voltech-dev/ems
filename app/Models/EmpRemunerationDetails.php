<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  EmpRemunerationDetails extends Model
{
    use HasFactory;
    protected $tabel=' emp_remuneration_details';

    public function emp()
    {
        return $this->belongsTo('App\Models\EmpDetails', 'empid','id');
    }
}

