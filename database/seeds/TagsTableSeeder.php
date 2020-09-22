<?php

use Illuminate\Database\Seeder;
use App\Tag;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $tags = [
        'WiFi',
        'Posto Macchina',
        'Piscina',
        'Portineria',
        'Sauna',
        'Vista Mare',
      ];

      foreach ($tags as $tag) {
        $new_tag = new Tag();
        $new_tag->tag = $tag;
        $new_tag->save();
      }
    }
}
