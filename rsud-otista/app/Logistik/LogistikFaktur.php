<?php

namespace App\Logistik;

use Illuminate\Database\Eloquent\Model;

class LogistikFaktur extends Model
{
    public function barang()
    {
        return $this->belongsTo(\App\Masterobat::class, 'masterobat_id', 'id');
    }

    public function po()
    {
        return $this->belongsTo(\App\Logistik\Po::class, 'po_id', 'id');
    }
    
    public function supplier()
    {
        return $this->belongsTo(\App\Logistik\LogistikSupplier::class, 'supplier_id', 'id');
    }
}
