<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Pasien\Entities\Pasien;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Registrasi\Entities\Registrasi;
// use Illuminate\Database\Eloquent\SoftDeletes;

class EmrKonsul extends Model
{
    use SoftDeletes;
    //
    // use SoftDeletes;

    // protected $table = 'emr';
    public function data_jawab_konsul()
    {
        return $this->hasMany(EmrKonsul::class,'konsul_dokter_id','id');
    }

    public function registrasi()
    {
        return $this->belongsTo(Registrasi::class, 'registrasi_id', 'id');
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id', 'id');
    }

    public function userVerif()
    {
        return $this->belongsTo(User::class, 'verifikator', 'id');
    }

    public function dokterPengirim()
    {
        return $this->belongsTo(Pegawai::class, 'dokter_pengirim', 'id');
    }

    public function dokterTujuan()
    {
        return $this->belongsTo(Pegawai::class, 'dokter_penjawab', 'id');
    }

}
