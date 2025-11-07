<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Kelas\Entities\Kelas;
use Modules\Kamar\Entities\Kamar;
use Modules\Bed\Entities\Bed;
use App\PerawatanIcd10;

class HistoriRawatInap extends Model
{
    protected $table = 'histori_rawatinap';

    public function latest_icd10() {
        return $this->hasOne(PerawatanIcd10::class,'registrasi_id','registrasi_id')->latest();
    }
    public function registrasi(){
        return $this->belongsTo(Registrasi::class,'registrasi_id','id');
    }
    public function kelas(){
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }
    public function kamar(){
        return $this->belongsTo(Kamar::class, 'kamar_id', 'id');
    }
    public function bed(){
        return $this->belongsTo(Bed::class, 'bed_id', 'id');
    }

}
