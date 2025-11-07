<?php

namespace App;

use App\Logistik\Logistik_BAPB;
use Illuminate\Database\Eloquent\Model;

class ReturObatRusak extends Model
{
    public function barang() {
		// belongsTo(RelatedModel, foreignKey = barang_id, keyOnRelatedModel = id)
		return $this->belongsTo(Masterobat::class, 'masterobat_id', 'id');
	}
    public function suplier() {
		
		return $this->belongsTo(Supliyer::class, 'supplier_id', 'id');
	}
    public function logistik() {
		
		return $this->belongsTo(LogistikBatch::class, 'logistik_batch_id', 'id');
	}
    
}
