<?php

namespace Modules\Pasien\Entities;
use App\Hasillab;
use App\Pembayaran;
use Illuminate\Database\Eloquent\Model;
use Modules\Pasien\Entities\Agama;
use Modules\Pasien\Entities\Village;
use Modules\Pekerjaan\Entities\Pekerjaan;
use Modules\Pendidikan\Entities\Pendidikan;
use Modules\Registrasi\Entities\Folio;
use Modules\Registrasi\Entities\Registrasi;
use Illuminate\Database\Eloquent\SoftDeletes;

class Biodata extends Model {

	use SoftDeletes;
	//protected $fillable = ['pasiens'];

	 protected $fillable = [];
	// protected $dates = ['deleted_at'];

	public function Registrasi() {
		return $this->hasMany(registrasi::class);
	}

	public function folio() {
		return $this->hasMany(Folio::class);
	}

	public function pembayaran() {
		return $this->hasMany(Pembayaran::class);
	}

	public function hasillab() {
		return $this->hasMany(Hasillab::class);
	}

	public function pekerjaan() {
		return $this->belongsTo(Pekerjaan::class);
	}

	public function agama() {
		return $this->belongsTo(Agama::class);
	}

	public function kelurahan() {
		// belongsTo(RelatedModel, foreignKey = kelurahan_id, keyOnRelatedModel = id)
		return $this->belongsTo(Village::class, 'village_id', 'id');
	}
}
