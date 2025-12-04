<?php

namespace Modules\Perusahaan\Entities;
use Illuminate\Database\Eloquent\Model;
use Modules\Registrasi\Entities\Registrasi;

class Perusahaan extends Model
{
    protected $fillable = ['nama','alamat','id_prk','diskon','plafon','kode'];

    public function registrasi()
    {
      return $this->hasMany(Registrasi::class);
    }
}
