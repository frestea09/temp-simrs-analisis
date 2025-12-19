<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;

class RencanaKontrol extends Model
{
	protected $table    = 'bpjs_rencana_kontrol';

	public function registrasi()
    {
        return $this->hasOne(Registrasi::class,'id','registrasi_id');
    }
}
