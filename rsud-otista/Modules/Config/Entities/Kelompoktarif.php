<?php

namespace Modules\Config\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Tarif\Entities\Tarif;

class Kelompoktarif extends Model
{
    protected $fillable = ['kelompok'];

    public function tarif()
    {
        return $this->hasMany(Tarif::class);
    }
}
