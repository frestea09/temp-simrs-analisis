<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Folio;
use Modules\Registrasi\Entities\Registrasi;

class Orderlab extends Model
{
    protected $table    = 'order_lab';

    public function registrasi()
    {
        return $this->hasOne(Registrasi::class, 'id', 'registrasi_id');
    }

    public function hasillab()
    {
        return $this->hasOne(Hasillab::class, 'order_lab_id', 'id');
    }

    public function folios()
    {
        return $this->hasMany(Folio::class, 'order_lab_id', 'id');
    }

    public function folio()
    {
        return $this->hasOne(Folio::class, 'order_lab_id', 'id');
    }
}
