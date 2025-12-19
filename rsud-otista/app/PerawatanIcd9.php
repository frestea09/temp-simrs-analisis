<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Modules\Icd9\Entities\Icd9;
use Modules\Registrasi\Entities\Registrasi;

class PerawatanIcd9 extends Model
{
  public function icd9()
  {
      return $this->belongsTo(Icd9::class);
  }

  public function registrasi()
  {
      return $this->hasOne(Registrasi::class,'id','registrasi_id');
  }
}
