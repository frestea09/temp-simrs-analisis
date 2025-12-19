<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;

class RecordSatuSehat extends Model
{
    protected $guarded = ['id'];
    protected $table = 'record_satusehat';

    public function registrasi(){
        return $this->belongsTo(Registrasi::class, 'registrasi_id', 'id');
    }
}
