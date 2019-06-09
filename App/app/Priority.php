<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
  public $timestamps = false;
  protected $fillable = ['title', 'color', 'updated_at'];
  protected $table = 'priorities';
}
