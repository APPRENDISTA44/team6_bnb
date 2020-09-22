<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Message;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
      for ($i=0; $i < 4 ; $i++) {
        $new_message = new Message();
        $new_message->user_id = $i + 1;
        $new_message->apartment_id = $i + 1;
        $new_message->text = $faker->text(500);
        $new_message->sender = $faker->email;
        $new_message->save();
      }
    }
}
