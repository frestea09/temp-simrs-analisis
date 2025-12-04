<?php

namespace Modules\Instalasi\Entities;
use Illuminate\Database\Eloquent\Model;
use Modules\Poli\Entities\Poli;

class Instalasi extends Model
{
    protected $fillable = ['nama'];

    public function poli()
    {
        return $this->hasMany(Poli::class);
    }
}
