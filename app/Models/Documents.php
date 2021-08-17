<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  Documents extends Model
{
    use HasFactory;
    protected $tabel='documents';
    public function documenttype()
    {
        return $this->hasOne('App\Models\Documents','document_type');
    }
   
}
 