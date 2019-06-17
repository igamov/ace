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
    'last_name', 'first_name', 'patronymic', 'email', 'password', 'api_token', 'photo', 'role_id'
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
      'role_id' => $this->role_id,
      'role_name' => $this->role->name,
      'photo' => $this->photo
    ];
  }
  public function role()
  {
    return $this->belongsTo('App\UserRoles');
  }
//  public function devTasks(){
//    return $this->hasMany('App\Task', 'developer_id', 'id');
//  }
  public function manager_projects(){
    return $this->hasMany('App\Project', 'manager_id', 'id');
  }
  public function manager_customers(){
    return $this->hasMany('App\Customer', 'manager_id', 'id');
  }
  public function spoke_customers(){
    return $this->hasMany('App\Customer', 'spokesman_id', 'id');
  }
}
