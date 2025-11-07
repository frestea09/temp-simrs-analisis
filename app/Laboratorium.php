<?php

namespace App;

use App\Labkategori;
use App\RincianHasillab;
use Illuminate\Database\Eloquent\Model;
use Modules\Pasien\Entities\Pasien;

class Laboratorium extends Model {
	protected $fillable = ['labkategori_id', 'nama', 'rujukan', 'nilairujukanbawah', 'nilairujukanatas', 'satuan'];

	public function labkategori() {
		return $this->belongsTo(Labkategori::class);
	}

	public function rincian() {
		return $this->hasMany(RincianHasillab::class);
	}

	/**
	 * Laboratorium belongs to Pasien.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function pasienData() {
		// belongsTo(RelatedModel, foreignKey = pasien_id, keyOnRelatedModel = id)
		return $this->belongsTo(Pasien::class, 'pasien_id', 'id');
	}
}
