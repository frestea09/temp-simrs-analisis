<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\PerawatanIcd10;
use App\PerawatanIcd9;

class Historipengunjung extends Model
{
    protected $table = 'histori_pengunjung';

    public function latest_icd10() {
        return $this->hasOne(PerawatanIcd10::class,'registrasi_id','registrasi_id')->limit(1)->latest();
    }

    public function first_icd10() {
        return $this->hasOne(PerawatanIcd10::class,'registrasi_id','registrasi_id');
    }

    public function icd10() {
        return $this->hasMany(PerawatanIcd10::class,'registrasi_id','registrasi_id');
    }

    public function icd9() {
        return $this->hasMany(PerawatanIcd9::class,'registrasi_id','registrasi_id');
    }

}
