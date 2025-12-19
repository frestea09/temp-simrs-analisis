<?php

namespace App\Logistik;

use Illuminate\Database\Eloquent\Model;

class LogistikPemakaian extends Model {
	/**
	 * LogistikPemakaian belongs to Bara.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	// public function barang() {
	// 	return $this->belongsTo(\App\Masterobat::class, 'masterobat_id', 'id');
	// }

	public function barang()
	{
		return $this->belongsTo('\App\Masterobat', 'masterobat_id', 'id');
	}

	/**
	 * LogistikPemakaian belongs to User.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user() {
		// belongsTo(RelatedModel, foreignKey = user_id, keyOnRelatedModel = id)
		return $this->belongsTo(\App\User::class, 'user_id', 'id');
	}
}
