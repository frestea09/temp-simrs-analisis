<?php

namespace App\HRD;

use Illuminate\Database\Eloquent\Model;

class HrdPendidikanFormal extends Model
{
    public function pendidikan()
    {
        return $this->belongsTo('\Modules\Pendidikan\Entities\Pendidikan', 'pendidikan_id', 'id');
    }
}
