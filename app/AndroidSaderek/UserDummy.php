<?php

namespace App\AndroidSaderek;

use Illuminate\Database\Eloquent\Model;

class UserDummy extends Model
{
    protected $table    = 'saderek_user_dummy';

    protected $fillable = ['nik','tgllahir','nama','alamat','hp','kelamin'];

}
