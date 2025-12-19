<?php

namespace Modules\Antrian\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;

class Antrian extends Model
{
    protected $fillable = ['nomor','type','poli_id','bagian','suara', 'status', 'tanggal', 'panggil', 'loket', 'kelompok'];

    public function registrasi()
	{
		return $this->hasOne(Registrasi::class, 'antrian_id', 'id');
	}
}
