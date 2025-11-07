<?php

namespace App\HRD;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HrdAdministrasi extends Model
{
    use SoftDeletes;

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
