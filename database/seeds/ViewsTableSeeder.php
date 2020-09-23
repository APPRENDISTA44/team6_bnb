<?php

use Illuminate\Database\Seeder;
use App\View;
use Carbon\Carbon;
use Faker\Generator as Faker;


class ViewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
      for ($i=0; $i < 8 ; $i++) {
        $new_view = new View();
        $new_view->apartment_id = rand(1,4);
        $new_view->date = $faker->dateTime('now','CEST');
        $new_view->save();
      }
    }
}
