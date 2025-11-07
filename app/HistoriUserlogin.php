<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoriUserlogin extends Model {
	protected $fillable = ['user_id', 'ip_address'];
}
