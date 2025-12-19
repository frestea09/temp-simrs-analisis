<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Icd10\Entities\Icd10;
use Modules\Registrasi\Entities\Registrasi;

class JknIcd10 extends Model
{
    public function icd10s()
    {
        return $this->belongsTo(Icd10::class, 'icd10','nomor');
    }

    public function registrasi()
    {
        return $this->hasOne(Registrasi::class,'id','registrasi_id');
    }
}
