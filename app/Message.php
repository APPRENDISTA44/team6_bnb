<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
  protected $fillable = [
    'apartment_id',
    'text',
    'sender',
    'created_at'
  ];


  public function apartment(){
    return $this->belongsTo('App\Apartment');
  }
}
