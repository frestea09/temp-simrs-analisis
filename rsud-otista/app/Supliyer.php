<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supliyer extends Model
{
    protected $fillable = ['nama','kode','alamat','tlp','pimpinan','aktif'];
}
