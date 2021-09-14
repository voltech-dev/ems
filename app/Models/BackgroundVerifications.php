<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackgroundVerifications extends Model
{
    use HasFactory;
    protected $tabel='background_verifications';
    protected $fillable = ['empid','document_sent','educational_check','employment_check','address_check','overall_check','report'];
}
