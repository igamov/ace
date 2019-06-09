<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
  protected $fillable = ['title', 'price', 'sum', 'nds_id','count','invoice_id'];
  public $timestamps = false;
  public function invoice()
  {
    return $this->belongsTo('App\Invoice');
  }
  public function nds(){
    return $this->hasMany('App\Nds');
  }
}
