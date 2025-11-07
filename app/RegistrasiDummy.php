<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Poli\Entities\Poli;

class RegistrasiDummy extends Model
{
    //
    protected $table = 'registrasis_dummy';
    protected $fillable = ['id','request','kodebooking','flag','nomorkartu','jenis_registrasi','angkaantrian','nomorantrian','nik','no_rm','nama' ,'alamat' ,'tgllahir' ,'kelamin' ,'no_hp' ,'kode_cara_bayar' ,'no_rujukan' ,'tglperiksa' ,'kode_poli' ,'kode_dokter', 'status','jenisreferensi','jenisrequest','polieksekutif','jenisdaftar','estimasidilayani'];

    public function poli(){
        return $this->hasOne(Poli::class,'bpjs','kode_poli');
    }

    public function dokter(){
        return $this->hasOne(Pegawai::class,'kode_bpjs','kode_dokter');
    }

    public function dokters(){
        return $this->hasOne(Pegawai::class,'id','kode_dokter');
    }
}
