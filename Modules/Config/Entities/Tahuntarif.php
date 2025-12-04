<?php

namespace Modules\Config\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Tarif\Entities\Tarif;
use App\Mastersplit;

class Tahuntarif extends Model
{
    protected $fillable = ['tahun'];

    public function tarif()
    {
        return $this->hasMany(Tarif::class);
    }

    public function mastersplit()
    {
      return $this->hasMany(Mastersplit::class);
    }
}
