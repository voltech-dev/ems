<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personaldetails extends Model
{
    use HasFactory;
    protected $table ='personal_details';   
    protected $fillable = ['empid','name_1','relationship_1','dob_1','name_2','relationship_2','dob_2','name_3','relationship_3','dob_3'];  
}
