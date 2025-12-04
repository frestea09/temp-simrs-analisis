<?php

namespace Modules\Registrasi\Entities;
use Illuminate\Database\Eloquent\Model;
use Modules\Pasien\Entities\Pasien;
use Modules\Registrasi\Entities\Folio;
use Modules\Poli\Entities\Poli;

class Dokter extends Model
{
    protected $fillable = ['user_id','nama','poli_id'];

    public function pasien()
    {
        return $this->hasMany(Pasien::class);
    }

    public function folio()
    {
      return $this->hasMany(Folio::class);
    }

    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }
}
