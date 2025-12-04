<?php

namespace Modules\Kamar\Entities;

use App\Kelompokkelas;
use Illuminate\Database\Eloquent\Model;

use Modules\Kelas\Entities\Kelas;
use Modules\Bed\Entities\Bed;
use Modules\Politype\Entities\Politype;
use App\Rawatinap;

class Kamar extends Model
{
    protected $fillable = ['nama', 'kelompokkelas_id','kelas_id', 'hidden'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function kelompokkelas()
    {
        return $this->belongsTo(Kelompokkelas::class);
    }

    public function bed()
    {
      return $this->hasMany(Bed::class);
    }

    public function politype()
    {
        return $this->hasMany(Politype::class);
    }

    public function rawatInap()
    {
      return $this->hasMany(Rawatinap::class);
    }
}
