<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BpjsPRBResponse extends Model
{
    protected $table    = 'bpjs_prb_response';
	protected $fillable = ['bpjs_prb_id', 'response'];
}
