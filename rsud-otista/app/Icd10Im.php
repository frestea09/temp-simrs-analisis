<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Icd10\Entities\Icd10;

class Icd10Im extends Model
{
    protected $table    = 'icd10_im';
    protected $guarded = [];

    public function icd10(){
        return $this->belongsTo(Icd10::class, 'icd10_id', 'id');
    }
}
