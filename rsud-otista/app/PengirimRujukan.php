<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PengirimRujukan extends Model
{
    protected $table = 'pengirim_rujukan';
    protected $fillable = ['id','nama'];
}
