<?php

namespace Modules\Bed\Entities;
use Illuminate\Database\Eloquent\Model;
use Modules\Kamar\Entities\Kamar;
use App\Rawatinap;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bed extends Model
{
    use SoftDeletes;
    protected $fillable = ['kamar_id', 'nama', 'kode', 'reserved', 'keterangan', 'hidden'];

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }

    public function rawatInap()
    {
        return $this->hasMany(Rawatinap::class);
    }
}
