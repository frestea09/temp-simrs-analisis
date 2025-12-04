<?php

namespace Modules\Accounting\Entities;

use Illuminate\Database\Eloquent\Model;

class Sal extends Model
{
    protected $table = 'akutansi_lap_sal';

    protected $fillable = [
        'tahun',
        'key',
        'jumlah'
    ];
}
