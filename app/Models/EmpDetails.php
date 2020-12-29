<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpDetails extends Model
{
    use HasFactory;
    protected $tabel = 'emp_details';

    public function project()
    {
        return $this->belongsTo('App\Models\ProjectDetails', 'project_id');
    }

    public function designation()
    {
        return $this->belongsTo('App\Models\Designation', 'designation_id');
    }

    public function locations()
    {
        return $this->belongsTo('App\Models\Locations', 'location_id');
    }
    
    public function rem()
{
    return $this->belongsTo('App\Models\EmpRemunerationDetails', 'id','empid');
}
public function statutory()
{
    return $this->belongsTo('App\Models\EmpStatutorydetails', 'id','empid');
}
public function bank()
{
    return $this->belongsTo('App\Models\EmpBankdetails', 'id','empid');
}
public function status()
{
    return $this->belongsTo('App\Models\Statuses', 'status_id');
}


    public function remuneration()
    {
        return $this->belongsTo('App\Models\EmpRemunerationDetails', 'id','empid');
    }
}
