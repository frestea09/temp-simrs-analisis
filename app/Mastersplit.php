<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Modules\Config\Entities\Tahuntarif;
use Modules\Kategoriheader\Entities\Kategoriheader;

class Mastersplit extends Model
{
    protected $fillable = ['tahuntarif_id', 'kategoriheader_id', 'nama'];

    public function tahuntarif()
    {
        return $this->belongsTo(Tahuntarif::class);
    }

    public function kategoriheader()
    {
        return $this->belongsTo(Kategoriheader::class);
    }
}
