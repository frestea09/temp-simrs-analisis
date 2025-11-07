<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Icd9\Entities\Icd9;

class Icd9Inacbg extends Model
{
    protected $table    = 'icd9_inacbg';
	protected $guarded = [];

    public function icd9(){
        return $this->belongsTo(Icd9::class, 'icd9_id', 'id');
    }
}
