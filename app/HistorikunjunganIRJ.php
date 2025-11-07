<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Modules\Pasien\Entities\Pasien;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Poli\Entities\Poli;
use App\Emr;
use App\EmrInapPemeriksaan;

class HistorikunjunganIRJ extends Model
{
    protected $table = 'histori_kunjungan_irj';
    protected $fillable = ['id', 'registrasi_id', 'pasien_id', 'dokter_id', 'poli_id', 'created_at', 'updated_at'];

    public function poli(){
        return $this->belongsTo(Poli::class);
    }

    public function pasien(){
        return $this->belongsTo(Pasien::class, 'pasien_id', 'id');
    }
    public function registrasi(){
        return $this->hasOne(Registrasi::class,'id','registrasi_id');
    }

    public function emrPemeriksaan(){
        return $this->belongsTo(EmrInapPemeriksaan::class, 'registrasi_id', 'registrasi_id');
    }

    public function cppt(){
        return $this->belongsTo(Emr::class, 'registrasi_id', 'registrasi_id');
    }

    public function resep(){
        return $this->hasOne(ResepNote::class, 'registrasi_id', 'registrasi_id');
    }
}
