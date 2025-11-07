<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Labkategori;
use App\Laboratorium;

class RincianHasillab extends Model
{
    public function labkategori()
    {
        return $this->belongsTo(Labkategori::class);
    }

    public function laboratoria()
    {
        return $this->belongsTo(Laboratorium::class);
    }
}
