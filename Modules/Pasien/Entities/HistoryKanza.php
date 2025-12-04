<?php

namespace Modules\Pasien\Entities;
use Illuminate\Database\Eloquent\Model;

class HistoryKanza extends Model {
	protected $table    = 'history_kanza';
	protected $fillable = ['norm','pasien', 'alamat', 'kelamin', 'tgl_lahir', 'reg', 'jam', 'status', 'dokter', 'poli', 'carabayar'];
	
}