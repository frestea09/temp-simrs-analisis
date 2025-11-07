<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Tarif\Entities\Tarif;

class BdrsDetail extends Model
{
    protected $table = 'bdrs_detail';
    protected $guarded = [];

    public function tarif()
    {
        return $this->hasOne(Tarif::class, 'id','tarif_id');
    }
}
