<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;

class AntrianRadiologi extends Model
{
    protected $table = 'antrian_radiologis';

    public function registrasi()
    {
        return $this->belongsTo(Registrasi::class, 'registrasi_id', 'id');
    }
    public function getPasienAttribute()
    {
        return $this->registrasi ? $this->registrasi->pasien : null;
    }

}
