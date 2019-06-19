<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
  protected $fillable = ['body', 'user_id', 'task_id'];
  protected $table = 'histories';

  public function user(){
    {
      return $this->belongsTo('App\User');
    }
  }
}
