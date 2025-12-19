<?php

namespace App\Models\Pasien;
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
