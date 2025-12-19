<?php

namespace App\Android;

use Illuminate\Database\Eloquent\Model;

class pasien_android extends Model
{
    protected $table = 'pasien_android';

    protected $guarded = ['id'];

    protected $hidden = [
		'api_token'
	];
}
