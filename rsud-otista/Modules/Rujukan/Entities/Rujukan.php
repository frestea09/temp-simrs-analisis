<?php

namespace Modules\Rujukan\Entities;
use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;

class Rujukan extends Model
{
    protected $fillable = ['nama'];

    public function registrasi()
    {
      return $this->hasMany(Registrasi::class);
    }
}
