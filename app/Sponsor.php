<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
  protected $fillable = [
    'price',
    'hours_duration',
    'offer_name'
  ];

  public function apartments()
    {
        return $this->belongsToMany('App\Apartment')
          ->using('App\ApartmentSponsor')
          ->withPivot([
                          'date_start',
                          'date_end'
                      ]);
    }
}
