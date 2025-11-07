<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ResepNoteDetail;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResepNoteDuplicate extends Model
{
    use SoftDeletes;
    
    protected $table = 'resep_note_duplicate';
    protected $fillable = ['id','poli_id','nama_racikan','uuid','source','registrasi_id','pasien_id','comment','no_resep','status','created_by'];

    public function resep_detail()
    {
        return $this->hasMany(ResepNoteDetail::class,'resep_note_id','id');
    }

    public function user()
    {
        return $this->hasOne(User::class,'id','created_by');
    }
}
