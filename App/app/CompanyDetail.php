<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyDetail extends Model
{
  public $timestamps = false;
  protected $fillable = [
    'inn',
    'legal_name',
    'legal_address',
    'inn',
    'kpp',
    'rs',
    'bank',
    'ks',
    'bik',
    'director',
    'accountant'
  ];
}
