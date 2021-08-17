<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doc_type extends Model
{
    use HasFactory;
    protected $tabel='doc_types';
    public $timestamps = false;
    protected $fillable = ['doc_type_name'];
    public function doctypes()
    {
        return $this->hasOne(Documents::class,'document_type','doc_type_name');
    }

    public function getDocument($Eid,$docType){        
        $doc = Documents::where(['empid'=>$Eid,'document_type'=>$docType])->exists();
        return $doc;   
    }
    public function getDocuments($Eid,$docType){        
      // echo $Eid;
      //  echo $docType;
        $doc = Documents::where(['empid'=>$Eid,'document_type'=>$docType])->exists();
       // echo $doc->document_type;
        return $doc;  
     //  dd($doc);
    }
}
