<?php

namespace Modules\Sebabsakit\Entities;
use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Sebabsakit\Entities\Sebabsakit;

class Sebabsakit extends Model
{
    protected $fillable = ['nama'];

    public function registrasi()
    {
      return $this->hasMany(Registrasi::class);
    }
}
