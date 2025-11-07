<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;

class Antrian4 extends Model {
	protected $table    = 'antrians';
	protected $fillable = ['nomor', 'suara', 'status', 'tanggal', 'panggil', 'loket'];

	public function registrasi()
	{
		return $this->hasOne(Registrasi::class, 'antrian_id', 'id');
	}
}
