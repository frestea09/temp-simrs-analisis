<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Kelas\Entities\Kelas;
use Modules\Kamar\Entities\Kamar;
use Modules\Bed\Entities\Bed;
use Modules\Pasien\Entities\Pasien;

use Modules\Registrasi\Entities\Registrasi;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Registrasi\Entities\Carabayar;
use Modules\Registrasi\Entities\Folio;


class Rawatinap extends Model{
    

    use SoftDeletes;
    public function pasien(){
        return $this->belongsTo(Pasien::class);
    }
    public function kelas(){
        return $this->belongsTo(Kelas::class);
    }
    public function kamar(){
        return $this->belongsTo(Kamar::class);
    }
    public function bed(){
        return $this->belongsTo(Bed::class);
    }

    // tambahan
    public function registrasi(){
        return $this->hasOne(Registrasi::class,'id','registrasi_id');
    }

    public function detail_pasien(){
        return $this->hasOne(Pasien::class,'id','pasien_ids');
    }

    public function detail_kelas(){
        return $this->hasOne(Kelas::class,'id','kelas_id');
    }

    public function dokter_ahli()
    {
        return $this->hasOne(Pegawai::class,'id','dokter_id');
    }

    public function cara_bayar()
    {
        return $this->hasOne(Carabayar::class,'id','carabayar_id');
    }

    public function folio()
    {
        return $this->hasMany(Folio::class,'registrasi_id','registrasi_id');
    }

    public function data_pasien()
    {
        return $this->hasOne(Pasien::class,'id','pasien_id');
    }

    public function biaya_diagnosa_awal()
    {
        return $this->hasOne(PaguPerawatan::class, 'id', 'pagu_perawatan_id');
    }
}
