<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;

class EmrInapPemeriksaan extends Model
{

  public function registrasi()
  {
      return $this->belongsTo(Registrasi::class, 'registrasi_id', 'id')->withTrashed();
  }

  public function user(){
    return $this->hasOne(User::class, 'id', 'user_id');
}
}
