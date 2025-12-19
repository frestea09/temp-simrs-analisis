<?php

namespace App\Android;

use Illuminate\Database\Eloquent\Model;
use App\Android\android_direksi;

class android_manajemen extends Model
{
    protected $table    = 'android_manajemen';

    protected $fillable = ['manaj_nama'];
    
    public $timestamps = false;

    public function anggota()
    {
      return $this->hasMany(android_direksi::class,'manajemen_id','id');
    }
}
