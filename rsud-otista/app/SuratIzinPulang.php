<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;

class SuratIzinPulang extends Model
{
    protected $table    = 'surat_izin_pulang';
	protected $guarded = 'id';

    public function registrasi(){
        return $this->hasOne(Registrasi::class, 'registrasi_id', 'id');
    }
}
