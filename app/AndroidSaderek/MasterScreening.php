<?php

namespace App\AndroidSaderek;

use Illuminate\Database\Eloquent\Model;

class MasterScreening extends Model
{
    protected $table    = 'saderek_master_screening';

    protected $fillable = ['urut','pertanyaan','skor','type','status','with_detail'];
}
