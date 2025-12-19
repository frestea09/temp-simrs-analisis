<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BpjsObatPRB extends Model
{
    protected $table    = 'bpjs_master_obat_prb';
	protected $fillable = ['kode', 'nama'];
}
