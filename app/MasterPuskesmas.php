<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterPuskesmas extends Model
{
    protected $table = 'master_puskesmas';

    protected $fillable = ['nama','alamat'];
}
