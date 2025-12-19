<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Pasien\Entities\Pasien;

class HistorikunjunganIGD extends Model
{
    protected $table = 'histori_kunjungan_igd';

    public function registrasi(){
        return $this->hasOne(Registrasi::class,'id', 'registrasi_id');
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

}
