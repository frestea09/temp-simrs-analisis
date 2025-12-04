<?php

namespace Modules\Kategoritarif\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Kategoriheader\Entities\Kategoriheader;
use Modules\Tarif\Entities\Tarif;

class Kategoritarif extends Model
{
    protected $fillable = ['namatarif', 'kategoriheader_id'];

    public function kategoriheader()
    {
      return $this->belongsTo(Kategoriheader::class);
    }

    public function tarif()
    {
      return $this->hasMany(Tarif::class);
    }
}
