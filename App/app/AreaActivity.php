<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AreaActivity extends Model
{
  public $timestamps = false;
  protected $fillable = ['title', 'updated_at'];
  protected $table = 'area_activities';
}
