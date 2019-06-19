<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
  public $timestamps = true;
  protected $fillable = ['body', 'user_id', 'project_id'];
  public function user(){
    return $this->belongsTo('App\User');
  }
}
