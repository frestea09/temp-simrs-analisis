<?php

namespace Modules\Kategoriheader\Entities;
use Illuminate\Database\Eloquent\Model;
use Modules\Kategoritarif\Entities\Kategoritarif;
use Modules\Tarif\Entities\Tarif;
use App\Mastersplit;

class Kategoriheader extends Model
{
    protected $fillable = ['nama'];

    public function kategoritarif()
    {
      return $this->hasMany(Kategoritarif::class);
    }

    public function mastersplit()
    {
        return $this->hasMany(Mastersplit::class);
    }

    public function tarif()
    {
      return $this->hasMany(Tarif::class);
    }
}
