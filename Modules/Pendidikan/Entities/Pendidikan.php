<?php

namespace Modules\Pendidikan\Entities;
use Illuminate\Database\Eloquent\Model;
use Modules\Pasien\Entities\Pasien;

class Pendidikan extends Model
{
    protected $fillable = ['pendidikan'];

    public function pasien()
    {
        return $this->hasMany(Pasien::class);
    }
}
