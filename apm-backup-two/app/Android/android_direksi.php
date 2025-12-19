<?php

namespace App\Android;

use Illuminate\Database\Eloquent\Model;
use App\Android\agama;
use App\Android\android_jabatan;
use App\Android\android_manajemen;

class android_direksi extends Model
{
    protected $table    = 'android_direksi';

    protected $fillable = ['dir_nik','dir_nama','dir_tmplahir','dir_tgllahir','dir_kelamin','dir_alamat','dir_sambutan','agama_id','manajemen_id','jabatan_id','dir_photo','dir_photo_path'];

    public function agama()
    {
      return $this->hasOne(agama::class,'id','agama_id');
    }

    public function jabatan()
    {
      return $this->hasOne(android_jabatan::class,'id','jabatan_id');
    }

    public function manajemen()
    {
      return $this->hasOne(android_manajemen::class,'id','manajemen_id');
    }
}
