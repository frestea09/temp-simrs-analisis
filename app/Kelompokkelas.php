<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Bed\Entities\Bed;

class Kelompokkelas extends Model
{
    use SoftDeletes;
    protected $table = 'kelompok_kelas';

    public function bed()
    {
        return $this->hasMany(Bed::class, 'kelompokkelas_id', 'id');
    }
}
