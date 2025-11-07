<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;

class HistoriOrderLab extends Model
{
    protected $table    = 'histori_order_lab';

    public function registrasi()
    {
        return $this->hasOne(Registrasi::class, 'id', 'registrasi_id');
    }
}
