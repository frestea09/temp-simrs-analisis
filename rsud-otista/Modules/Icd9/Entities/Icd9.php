<?php

namespace Modules\Icd9\Entities;
use Illuminate\Database\Eloquent\Model;
use App\PerawatanIcd9;

class Icd9 extends Model
{
    protected $fillable = ['nomor', 'nama'];

    public function perawaranicd9()
    {
        return $this->hasMany(Perawaranicd9::class);
    }
}
