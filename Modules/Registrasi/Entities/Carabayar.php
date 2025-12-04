<?php

namespace Modules\Registrasi\Entities;
use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;

class Carabayar extends Model
{
    protected $fillable = [];

    public function registrasi()
    {
      return $this->hasMany(Registrasi::class);
    }

}
