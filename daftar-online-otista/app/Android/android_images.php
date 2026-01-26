<?php

namespace App\Android;

use Illuminate\Database\Eloquent\Model;

class android_images extends Model
{
    protected $table    = 'android_images';

    protected $fillable = ['img_path','img_extention','content_id'];
    
    public $timestamps = false;
}
