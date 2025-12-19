<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class PacsOrder extends Model {
	protected $table    = 'pacs_order';
	protected $fillable = ['nama', 'no_rm','insurance','urgensi','room','dokter','klinis','radiografer','tindakan'];
}