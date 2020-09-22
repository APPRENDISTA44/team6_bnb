<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      $names = ['Al','Linda','Luca','Tommaso'];
      $surnames = ['Pen','Minotti','Isidoro','Venza'];
      $emails = [
        'al.pen@mail.it',
        'linda.minotti@mail.it',
        'luca.isidoro@mail.it',
        'tommaso.venza@mail.it'
      ];
      $dates_of_birth = [
        '01-02-1989',
        '03-05-1986',
        '31-01-1995',
        '22-08-1983'
      ];
      $passwords = [
        'alpen123',
        'lindaminotti123',
        'lucaisidoro123',
        'tommasovenza123'
      ];

      for ($i=0; $i < 4; $i++) {
        $new_user = new User();
        $new_user->name = $names[$i];
        $new_user->surname = $surnames[$i];
        $new_user->email =  $emails[$i];
        $new_user->birth = Carbon::createFromFormat('d-m-Y',$dates_of_birth[$i]);
        $new_user->password = Hash::make($passwords[$i]);
      }

    }
}
