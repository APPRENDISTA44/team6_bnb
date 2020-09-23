<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ApartmentSponsor extends Pivot
{
  protected $fillable = [
    'date_start',
    'date_end'
  ];


}
