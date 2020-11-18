<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpDetails extends Model
{
    use HasFactory;
    protected $tabel='emp_details';
    
    public function rem()
{
    return $this->belongsTo('App\Models\EmpRemunerationDetails', 'empid');
}
}

