<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
  protected $fillable = ['title', 'body', 'date_start', 'date_end', 'manager_id', 'customer_id', 'priority_id', 'team_id'];

  public function customer()
  {
    return $this->belongsTo('App\Customer');
  }
  public function priority()
  {
    return $this->belongsTo('App\Priority', 'priority_id');
  }
  public function manager()
  {
    return $this->belongsTo('App\User', 'manager_id');
  }
}