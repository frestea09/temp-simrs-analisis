<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;

class Operasi extends Model
{
    //
    public function registrasi(){
        return $this->hasOne(Registrasi::class,'id','registrasi_id');
    }

}
