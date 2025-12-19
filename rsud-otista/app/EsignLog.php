<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;

class EsignLog extends Model
{
    protected $guarded = ['id'];
    protected $table = 'esign_logs';

    public function registrasi(){
        return $this->belongsTo(Registrasi::class, 'registrasi_id', 'id');
    }
}
