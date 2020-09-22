<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
  protected $fillable = [
    'title',
    'description',
    'number_of_rooms',
    'number_of_beds',
    'number_of_bathrooms',
    'sqm',
    'address',
    'image',
    'sponsor_expiry',
    'latitude',
    'longitude',
    'availability',
    'views',
    'user_id'
  ];

  public function user(){
    return $this->belongsTo('App\User');
  }

  public function messages(){
    return $this->hasMany('App\Message');
  }

  public function tags(){
    return $this->belongsToMany('App\Tag');
  }
}
