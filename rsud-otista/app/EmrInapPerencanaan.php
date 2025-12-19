<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;

class EmrInapPerencanaan extends Model
{
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }

    public function registrasi()
    {
        return $this->belongsTo(Registrasi::class, 'registrasi_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
