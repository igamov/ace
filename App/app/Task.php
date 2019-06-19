<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
  protected $fillable = ['rank', 'title', 'body', 'date_start', 'date_end', 'time_estimate', 'time_actual', 'manager_id', 'project_id', 'status_id', 'priority_id', 'developer_id'];

  public function project()
  {
    return $this->belongsTo('App\Project');
  }
  public function priority()
  {
    return $this->belongsTo('App\Priority', 'priority_id');
  }
  public function status()
  {
    return $this->belongsTo('App\Status');
  }
  public function comments()
  {
    return $this->hasMany('App\Comment');
  }
  public function history()
  {
    return $this->hasMany('App\History');
  }
  public function developer()
  {
    return $this->belongsTo('App\User', 'developer_id');
  }
  public function manager()
  {
    return $this->belongsTo('App\User', 'manager_id');
  }
}
