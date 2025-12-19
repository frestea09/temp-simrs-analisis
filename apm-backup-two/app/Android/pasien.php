<?php

namespace App\Android;

use Illuminate\Database\Eloquent\Model;
// use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

// class pasien extends Authenticatable implements JWTSubject
class pasien extends Authenticatable
{
    protected $guard = 'pasien-api';

    protected $table = 'pasiens';

    // public function getAuthPassword()
    // {
    //     return $this->tgllahir;
    // }

    // protected $fillable = [
	// 	'name', 'email', 'password', 'kelompokkelas_id', 'poli_id', 'gudang_id',
	// ];

    protected $hidden = [
		'api_token'
	];

    // public function getJWTIdentifier()
    // {
    //     return $this->getKey();
    // }
    // public function getJWTCustomClaims()
    // {
    //     return [];
    // }
}
