<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SnomedCT extends Model
{
    protected $table = 'snomed-ct';

    public function children(){
        return $this->hasMany(SnomedCTChildren::class, 'snomed_ct_id', 'id');
    }
}
