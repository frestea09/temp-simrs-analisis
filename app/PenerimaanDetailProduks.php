<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenerimaanDetailProduks extends Model
{
    protected $table = 'penerimaan_produk_detil';

    protected $fillable = ['kode_penerimaan','kode_produk','nama_produk','jumlah','harga','satuan','ed','distribusi','stok'];
}
