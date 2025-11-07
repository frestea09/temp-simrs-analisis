<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Modules\Icd10\Entities\Icd10;
use Modules\Registrasi\Entities\Registrasi;

class PerawatanIcd10 extends Model
{
    public function icd10()
    {
        return $this->belongsTo(Icd10::class, 'nomor');
    }

    public function registrasi()
    {
        return $this->hasOne(Registrasi::class,'id','registrasi_id');
    }
}
