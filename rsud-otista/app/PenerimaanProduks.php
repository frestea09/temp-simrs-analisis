<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenerimaanProduks extends Model
{
    protected $table = 'penerimaan_produks';

    protected $fillable = ['kode_penerimaan','nama_supplier'];
}
