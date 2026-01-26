<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrasiDummy extends Model
{
    //
    protected $table = 'registrasis_dummy';
    protected $fillable = ['id','registrasi_id','nomorkartu','nomorantrian','nik','no_rm','nama' ,'alamat' ,'tgllahir' ,'kelamin' ,'no_hp' ,'kode_cara_bayar' ,'no_rujukan' ,'tglperiksa' ,'kode_poli' ,'kode_dokter', 'status','jenisreferensi','jenisrequest','polieksekutif','jenisdaftar','estimasidilayani','dokter_id'];


    public function registrasi()
	{
		return $this->hasOne(Registrasi::class,'id','registrasi_id');
	}
}
