<?php

namespace App\Logistik;

use Illuminate\Database\Eloquent\Model;
use App\Logistik\LogistikBatch;
use App\Masterobat;

class LogistikStock extends Model {
    protected $guarded = ['id'];
	/**
	 * LogistikStock belongs to Item.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function item() {
		// belongsTo(RelatedModel, foreignKey = item_id, keyOnRelatedModel = id)
		return $this->belongsTo(\App\Masterobat::class, 'masterobat_id', 'id');
	}

	public function gudang() {
		// belongsTo(RelatedModel, foreignKey = item_id, keyOnRelatedModel = id)
		return $this->belongsTo(\App\Logistik\LogistikGudang::class, 'gudang_id', 'id');
	}

	/**
	 * LogistikStock belongs to Supplier.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function supplier() {
		// belongsTo(RelatedModel, foreignKey = supplier_id, keyOnRelatedModel = id)
		return $this->belongsTo(\App\Logistik\LogistikSupplier::class, 'supplier_id', 'id');
	}

	public function logistik_batch(){
		return $this->hasOne(LogistikBatch::class,'id','logistik_batch_id');
	}

	public function master_obat(){
        return $this->hasOne(Masterobat::class,'id','masterobat_id');
    }
}
