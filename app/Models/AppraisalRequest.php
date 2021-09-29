<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmpDetails;

class AppraisalRequest extends Model
{
    use HasFactory;
    protected $table ='appraisal_request';     
    protected $fillable = ['empid','project_id','status']; 
}
