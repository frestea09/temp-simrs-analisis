<?php

namespace App\AndroidSaderek;

use Illuminate\Database\Eloquent\Model;
use App\AndroidSaderek\screeningPasien;
use App\AndroidSaderek\Poli;

class RegistrasiDummy extends Model
{
    protected $table = 'saderek_registrasis_dummy';
    protected $fillable = ['id','uuid','nomorkartu','nomorantrian','nik','no_rm','nama' ,'alamat' ,'tgllahir' ,'kelamin' ,'no_hp' ,'kode_cara_bayar' ,'no_rujukan' ,'tglperiksa' ,'kode_poli' ,'kode_dokter', 'status','jenisreferensi','jenisrequest','polieksekutif','jenisdaftar','estimasidilayani','terinfeksi_covid'];

    public function data_screening(){
        return $this->hasMany(screeningPasien::class,'reg_id','id');
    }

    public function data_poli(){
        return $this->hasOne(Poli::class,'id','kode_poli');
    }
}
