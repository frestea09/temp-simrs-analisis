<?php

namespace App\Models\Pasien;
// use App\Hasillab;
// use App\Pembayaran;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pasien\Agama;
use App\Models\Pasien\Village;
use App\Models\Pasien\Pekerjaan;
// use Modules\Pendidikan\Entities\Pendidikan;
// use Modules\Registrasi\Entities\Folio;
// use Modules\Registrasi\Entities\Registrasi;

class Pasien extends Model {
	protected $fillable = [];

	// public function Registrasi() {
	// 	return $this->hasMany(registrasi::class);
	// }

	// public function folio() {
	// 	return $this->hasMany(Folio::class);
	// }

	// public function pembayaran() {
	// 	return $this->hasMany(Pembayaran::class);
	// }

	// public function hasillab() {
	// 	return $this->hasMany(Hasillab::class);
	// }

	public function pekerjaan() {
		return $this->belongsTo(Pekerjaan::class);
	}

	// public function agama() {
	// 	return $this->belongsTo(Agama::class);
	// }

	// public function pendidikan() {
	// 	return $this->belongsTo(Pendidikan::class);
	// }

	public function kelurahan() {
		// belongsTo(RelatedModel, foreignKey = kelurahan_id, keyOnRelatedModel = id)
		return $this->belongsTo(Village::class, 'village_id', 'id');
	}
}
