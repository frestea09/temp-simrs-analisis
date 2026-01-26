<?php

namespace App\Android;

use Illuminate\Database\Eloquent\Model;

class slider extends Model
{
    protected $table    = 'android_slider';

    protected $fillable = ['slider_path','slider_img','slider_name'];
}
