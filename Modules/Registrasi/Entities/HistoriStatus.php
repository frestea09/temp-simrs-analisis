<?php

namespace Modules\Registrasi\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;

class HistoriStatus extends Model
{
    protected $fillable = [];

    public function registrasi()
    {
        return $this->hasOne(Registrasi::class,'id','registrasi_id');
    }
}
