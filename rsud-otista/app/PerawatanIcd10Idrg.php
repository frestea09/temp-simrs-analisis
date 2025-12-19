<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Modules\Icd10\Entities\Icd10;

class PerawatanIcd10Idrg extends Model
{
    public function icd10()
    {
        return $this->belongsTo(Icd10::class, 'nomor');
    }
}
