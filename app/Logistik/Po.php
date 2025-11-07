<?php

namespace App\Logistik;

use App\Masterobat;
use App\Satuanbeli;
use Illuminate\Database\Eloquent\Model;

class Po extends Model {
	protected $table = 'logistik_po';

	/**
	 * Po belongs to Barang.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function barang() {
		// belongsTo(RelatedModel, foreignKey = barang_id, keyOnRelatedModel = id)
		return $this->belongsTo(Masterobat::class, 'masterobat_id', 'id');
	}

	/**
	 * Po belongs to Satuan.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function satBeli() {
		// belongsTo(RelatedModel, foreignKey = satuan_id, keyOnRelatedModel = id)
		return $this->belongsTo(Satuanbeli::class, 'satuan', 'id');
	}

}
