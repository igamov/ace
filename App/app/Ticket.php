<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
  protected $fillable = ['title', 'body',  'project_id', 'status_id', 'priority_id', 'spokesman_id'];

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
  public function spokesman()
  {
    return $this->belongsTo('App\User', 'spokesman_id');
  }
}
