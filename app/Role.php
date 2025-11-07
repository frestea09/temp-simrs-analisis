<?php

namespace App;
use Laratrust\LaratrustRole;
use App\User;

class Role extends LaratrustRole
{

  protected $fillable = ['name', 'display_name', 'description'];

  public function users()
  {
      return $this->belongsToMany('App\User');
  }
}
