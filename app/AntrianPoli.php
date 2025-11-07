<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Modules\Poli\Entities\Poli;
use App\RegistrasiAntrian;
use Modules\Registrasi\Entities\Registrasi;

class AntrianPoli extends Model {
	protected $table    = 'antrian_poli';

	protected $fillable = ['nomor', 'suara','antrian_id', 'status', 'tanggal', 'panggil', 'loket','kelompok','poli_id','histori_kunjungan_irj_id'];

	public function register_antrian()
	{
		
		return $this->belongsTo(Registrasi::class,'id','antrian_poli_id');
	}

	public function poli()
	{
		return $this->hasOne(Poli::class,'id','poli_id');
	}
}
