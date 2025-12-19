<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    protected $fillable = ['nomor','bagian', 'suara', 'status', 'tanggal', 'panggil', 'loket', 'kelompok'];
}
