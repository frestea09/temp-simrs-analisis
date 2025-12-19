<?php

namespace App\Models\Pasien;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pasien\Regency;

class District extends Model
{
    protected $fillable = [];
    public $incrementing = false;
    protected $primaryKey = 'id';

    public function kabupaten(){
        return $this->hasOne(Regency::class,'id','regency_id');
    }
}
