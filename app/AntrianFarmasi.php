<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;

class AntrianFarmasi extends Model
{
    protected $guarded = ['id'];
    public function registrasi(){
        return $this->belongsTo(Registrasi::class, 'registrasi_id', 'id');
    }
}
