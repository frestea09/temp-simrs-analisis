<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BpjsProgramPRB extends Model
{
    protected $table    = 'bpjs_master_program_prb';
	protected $fillable = ['kode', 'nama'];
}
