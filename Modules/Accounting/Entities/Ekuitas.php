<?php

namespace Modules\Accounting\Entities;

use Illuminate\Database\Eloquent\Model;

class Ekuitas extends Model
{
    protected $table = 'akutansi_lap_ekuitases';

    protected $fillable = [
        'tahun',
        'key',
        'jumlah'
    ];
}
