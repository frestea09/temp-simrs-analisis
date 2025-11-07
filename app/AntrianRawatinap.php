<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AntrianRawatinap extends Model
{
    protected $fillable = ['nomor', 'suara', 'status', 'tanggal', 'panggil', 'loket', 'kelompok'];
    
}
