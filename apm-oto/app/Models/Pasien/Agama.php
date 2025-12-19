<?php

namespace App\Models\Pasien;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pasien\Pasien;


class Agama extends Model
{
    protected $fillable = [];

    public function pasien()
    {
        return $this->hasMany(Pasien::class);
    }
}
