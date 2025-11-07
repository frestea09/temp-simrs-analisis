<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Pasien\Entities\Pasien;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Registrasi\Entities\Registrasi;

class HasilPemeriksaan extends Model
{
    protected $table = 'hasil_pemeriksaan';
    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'penanggungjawab', 'id');
    }

    public function registrasi(){
        return $this->belongsTo(Registrasi::class, 'registrasi_id', 'id');
    }
}
