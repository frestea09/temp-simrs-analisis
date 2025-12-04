<?php

namespace Modules\Kelas\Entities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Kamar\Entities\Kamar;
use App\Rawatinap;

class Kelas extends Model
{
    protected $fillable = ['nama'];
    use SoftDeletes;

    public function kamar()
    {
      return $this->hasMany(Kamar::class);
    }

    public function rawatInap()
    {
        return $this->hasMany(Rawatinap::class);
    }
}
