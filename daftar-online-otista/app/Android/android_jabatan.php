<?php

namespace App\Android;

use Illuminate\Database\Eloquent\Model;

class android_jabatan extends Model
{
    protected $table    = 'android_jabatan';

    protected $fillable = ['jab_nama'];
    
    public $timestamps = false;
}
