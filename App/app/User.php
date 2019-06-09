<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  use Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'last_name', 'first_name', 'patronymic', 'email', 'password', 'api_token', 'photo'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token', 'api_token'
  ];
  public function info() {
    return [
      'user_id' => $this->id,
      'email' => $this->email,
      'api_token' => $this->api_token,
      'last_name' => $this->last_name,
      'first_name' => $this->first_name,
      'patronymic' => $this->patronymic,
      'photo' => $this->photo
    ];
  }
}
