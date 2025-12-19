<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Kamar\Entities\Kamar;
use Modules\Poli\Entities\Poli;
use Modules\Registrasi\Entities\Registrasi;

class ServiceNotif extends Model
{
  public function poli()
  {
    return $this->belongsTo(Poli::class, 'poli_id', 'id');
  }

  public function kamar()
  {
    return $this->belongsTo(Kamar::class, 'kamar_id', 'id');
  }

  public function registrasi()
  {
      return $this->belongsTo(Registrasi::class,'registrasi_id','id');
  }
}
