<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpDetails extends Model
{
    use HasFactory;
    protected $tabel='emp_details';

    public function project()
    {
        return $this->belongsTo('App\Models\ProjectDetails', 'project_id');
    }

    public function designation()
    {
        return $this->belongsTo('App\Models\Designation', 'designation_id');
    }

    public function location()
    {
        return $this->belongsTo('App\Models\Locations', 'location_id');
    }
    
    public function rem()
{
    return $this->belongsTo('App\Models\EmpRemunerationDetails', 'empid');
}
}

