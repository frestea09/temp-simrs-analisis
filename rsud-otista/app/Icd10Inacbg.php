<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Icd10\Entities\Icd10;

class Icd10Inacbg extends Model
{
    protected $table    = 'icd10_inacbg';
    protected $guarded = [];

    public function icd10(){
        return $this->belongsTo(Icd10::class, 'icd10_id', 'id');
    }
}
