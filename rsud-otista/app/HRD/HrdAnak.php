<?php

namespace App\HRD;

use Illuminate\Database\Eloquent\Model;

class HrdAnak extends Model
{
    public function pendidikan()
    {
        return $this->belongsTo('\Modules\Pendidikan\Entities\Pendidikan', 'pendidikan_id', 'id');
    }

    public function pekerjaan()
    {
        return $this->belongsTo('\Modules\Pasien\Entities\Pekerjaan', 'pekerjaan_id', 'id');
    }
}
