<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LogistikBatch;
use App\ResepNote;

class ResepNoteDetail extends Model
{
    protected $table = 'resep_note_detail';
    protected $fillable = ['id','kronis', 'obat_racikan','resep_note_id','logistik_batch_id','obat_id','qty','cara_bayar','cara_minum','tiket','takaran','informasi','is_empty','id_medication_request'];

    public function logistik_batch()
    {
        return $this->hasOne(LogistikBatch::class,'id','logistik_batch_id')->withTrashed();
    }

    public function resepnote()
    {
        return $this->hasOne(ResepNote::class,'id','resep_note_id');
    }
}
