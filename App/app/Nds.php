<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nds extends Model
{
  public $timestamps = false;
  protected $fillable = ['title', 'percent'];
  protected $table = 'nds';
}
