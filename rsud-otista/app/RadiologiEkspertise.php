<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Folio;
use Modules\Registrasi\Entities\Registrasi;

class RadiologiEkspertise extends Model
{
    //
    public function registrasi(){
        return $this->hasOne(Registrasi::class,'id','registrasi_id');
    }

    public function folio(){
        return $this->hasOne(Folio::class,'id','folio_id');
    }

}
