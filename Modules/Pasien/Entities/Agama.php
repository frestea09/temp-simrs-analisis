<?php

namespace Modules\Pasien\Entities;
use Illuminate\Database\Eloquent\Model;
use Modules\Pasien\Entities\Pasien;


class Agama extends Model
{
    protected $fillable = [];

    public function pasien()
    {
        return $this->hasMany(Pasien::class);
    }
}
