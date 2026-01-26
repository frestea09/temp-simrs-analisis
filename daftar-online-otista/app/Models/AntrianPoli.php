<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Poli;
use App\RegistrasiAntrian;
use Modules\Registrasi\Entities\Registrasi;

class AntrianPoli extends Model {
	protected $table    = 'antrian_poli';

	protected $fillable = ['nomor', 'suara', 'status', 'tanggal', 'panggil', 'loket','kelompok','poli_id'];

	public function register_antrian()
	{
		
		return $this->belongsTo(Registrasi::class,'id','antrian_poli_id');
	}

	public function poli()
	{
		return $this->hasOne(Poli::class,'id','poli_id');
	}
}
