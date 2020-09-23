<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Sponsor;

class SponsorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $prices = [2.99,5.99];
      $offer_names = ['Silver','Gold'];
      $hours_durations = [24,72];
      for ($i=0; $i < 2 ; $i++) {
        $new_sponsor = new Sponsor();
        $new_sponsor->price = $prices[$i];
        $new_sponsor->offer_name = $offer_names[$i];
        $new_sponsor->hours_duration = $hours_durations[$i];
        $new_sponsor->save();
      }
    }
}
