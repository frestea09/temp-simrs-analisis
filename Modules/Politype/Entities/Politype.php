<?php

namespace Modules\Politype\Entities;
use Illuminate\Database\Eloquent\Model;
use Modules\Poli\Entities\Poli;

class Politype extends Model
{
    protected $fillable = ['kode','nama'];

    public function poli()
    {
      return $this->hasMany(Poli::class);
    }
}
