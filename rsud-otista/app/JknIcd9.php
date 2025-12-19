<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Icd9\Entities\Icd9;
use Modules\Registrasi\Entities\Registrasi;

class JknIcd9 extends Model
{
    public function icd9s()
  {
      return $this->belongsTo(Icd9::class, 'icd9', 'nomor');
  }

  public function registrasi()
  {
      return $this->hasOne(Registrasi::class,'id','registrasi_id');
  }
}
