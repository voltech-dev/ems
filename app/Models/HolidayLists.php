<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HolidayLists extends Model
{
    use HasFactory;
    protected $tabel='holiday_lists';
    public $timestamps = false;
}
