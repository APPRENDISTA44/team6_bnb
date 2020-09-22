<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
  protected $fillable = [
    'user_id',
    'apartment_id',
    'text',
    'sender'
  ];

  public function user(){
    return $this->belongsTo('App\User');
  }

  public function apartment(){
    return $this->belongsTo('App\Apartment');
  }
}
