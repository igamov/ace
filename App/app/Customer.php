<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
  protected $fillable = [
    'name',
    'email',
    'phone',
    'site',
    'inn',
    'kpp',
    'legal_name',
    'legal_address',
    'manager_id',
    'area_activity_id',
    'spokesman_id'
  ];
  public function area_activity()
  {
    return $this->belongsTo('App\AreaActivity');
  }
  public function projects()
  {
    return $this->hasMany('App\Project');
  }
  public function invoices()
  {
    return $this->hasMany('App\Invoice');
  }
}
