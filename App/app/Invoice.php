<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Invoice extends Model
{
  protected $fillable = [
    'number',
    'payment_date',
    'sum',
    'pdf_path',
    'manager_id',
    'customer_id',
    'updated_at'
  ];

  public function customer()
  {
    return $this->belongsTo('App\Customer');
  }
  public function project()
  {
    return $this->belongsTo('App\Project');
  }

  public function services()
  {
    return $this->hasMany('App\Service');
  }

}
