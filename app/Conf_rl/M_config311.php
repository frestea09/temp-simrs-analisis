<?php

namespace App\Conf_rl;

use Illuminate\Database\Eloquent\Model;

class M_config311 extends Model
{
    protected $table    = 'conf_rl311';

    protected $fillable = ['kegiatan','nomer','create_at'];
    protected $primaryKey ='id_conf_rl311';
}
