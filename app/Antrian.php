<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;

class Antrian extends Model {
	protected $table    = 'antrians';
	protected $fillable = ['nomor', 'suara', 'status', 'tanggal', 'panggil', 'loket','bagian'];

	public function registrasi()
	{
		return $this->hasOne(Registrasi::class, 'antrian_id', 'id');
	}
}
