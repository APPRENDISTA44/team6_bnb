<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Carbon\Carbon;
use App\Apartment;

class ApartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
      $latitudes = [
        45.46369,
        45.46315,
        45.74537,
        45.82546

      ];

      $longitudes = [
        9.19049,
        9.19108,
        9.12215,
        8.82889
      ];

      for ($i=0; $i < 4; $i++) {

        $new_apartment = new Apartment();
        $new_apartment->title = $faker->sentence();
        $new_apartment->description = $faker->text(500);
        $new_apartment->number_of_rooms = $faker->numberBetween(1,4);
        $new_apartment->number_of_beds = $faker->numberBetween(1,4);
        $new_apartment->number_of_bathrooms = $faker->numberBetween(1,2);
        $new_apartment->sqm = $faker->numberBetween(40,300);
        $new_apartment->address = $faker->address;
        $new_apartment->city = $faker->city;
        $new_apartment->cap = $faker->numberBetween(10000,99999);
        $new_apartment->province = $faker->cityPrefix;
        $new_apartment->image = $faker->imageUrl();
        $new_apartment->latitude = $latitudes[$i];
        $new_apartment->longitude = $longitudes[$i];
        $new_apartment->availability = true;
        $new_apartment->user_id = $i + 1;
        $new_apartment->save();

        $new_apartment->tags()->attach(rand(1,6));


        $new_apartment->sponsors()->attach(1,
          [
            'date_end' => Carbon::createFromFormat('d-m-Y H:i:s', '25-09-2020 14:20:36')
          ]);
      }
    }
}
