<?php

namespace App\Models\Pasien;
use Illuminate\Database\Eloquent\Model;
use Modules\Pasien\Entities\Pasien;

class Pekerjaan extends Model
{
    protected $fillable = ['nama'];

    public function pasien()
    {
        return $this->hasMany(Pasien::class);
    }
}
