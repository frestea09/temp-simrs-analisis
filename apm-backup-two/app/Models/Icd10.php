<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\PerawatanIcd10;
use App\JknIcd10;

class Icd10 extends Model
{
    protected $fillable = ['nomor', 'nama'];

    function perawatanicd10()
    {
        return $this->hasMany(PerawatanIcd10::class, 'icd10');
    }

    function jknicd10()
    {
        return $this->hasMany(JknIcd10::class, 'icd10');
    }
}
