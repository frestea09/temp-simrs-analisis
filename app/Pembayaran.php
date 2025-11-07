<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Modules\Pasien\Entities\Pasien;
use Modules\Registrasi\Entities\Registrasi;
use App\User;
use App\MetodeBayar;

class Pembayaran extends Model
{
  public function pasien()
  {
      return $this->belongsTo(Pasien::class);
  }
  public function user()
  {
      return $this->belongsTo(User::class);
  }
  public function metode()
  {
      return $this->hasOne(MetodeBayar::class,'id','metode_bayar_id');
  }
  public function registrasi()
  {
      return $this->hasMany(Registrasi::class);
  }

  public function registrasis(){
    return $this->hasOne(Registrasi::class,'id','registrasi_id');
}
}
