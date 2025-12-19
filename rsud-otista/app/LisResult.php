<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class LisResult extends Model {
	protected $table    = 'lis_results';
	protected $fillable = ['no_ref','json'];
}