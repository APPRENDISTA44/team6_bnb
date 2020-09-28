<?php

namespace App\Http\Controllers;
use App\Apartment;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    // INDEX
    public function index() {
      return view('guest.index');
    }

    public function coordinatesHandler(Request $request){

      $data = $request->all();
      $apartments = Apartment::all();
      $latitude = $data['latitude'];
      $longitude = $data['longitude'];
      $user_coordinates = $latitude . ',' . $longitude;
      $array_results = [];


      // for ($i=0; $i < count($apartments) ; $i++) {
      //   $apartment_latitude = $apartments[$i]->latitude;
      //   $apartment_longitude = $apartments[$i]->longitude;
      //   $apartment_coordinates = $apartment_latitude . ',' . $apartment_longitude;
      //   $distance = $this->points_distance("48.857924,2.294026","41.890164,12.492346");
      //
      //   $array_results[] = $distance;
      // }

      foreach ($apartments as $apartment) {

        $apartment_latitude = $apartment->latitude;
        $apartment_longitude = $apartment->longitude;
        $apartment_coordinates = $apartment_latitude . ',' . $apartment_longitude;
        $distance = $this->points_distance($user_coordinates,$apartment_coordinates);
        $array_results[] = $distance;
        // if ( ($this->points_distance($apartment_coordinates,$user_coordinates)) ) {
        //   $array_results[] = $apartment;
        // }
      }


      // $distance = $this->points_distance("48.857924,2.294026","41.890164,12.492346");

      // ritorno in formato json informazioni per debug
      return response()->json(['success'=>$array_results]);
    }

    // public function test(){
    //
    // }



    public function points_distance ( $coordinate_a, $coordinate_b ) {

      $RAGGIO_QUADRATICO_MEDIO = 6372.795477598;
      list($decLatA, $decLonA) = array_map('trim', explode(',', $coordinate_a));
      list($decLatB, $decLonB) = array_map('trim', explode(',', $coordinate_b));
      $radLatA = pi() * $decLatA / 180;
      $radLonA = pi() * $decLonA / 180;
      $radLatB = pi() * $decLatB / 180;
      $radLonB = pi() * $decLonB / 180;
      $phi = abs($radLonA - $radLonB);
      $P = acos (
            (sin($radLatA) * sin($radLatB)) +
            (cos($radLatA) * cos($radLatB) * cos($phi))
      );
      return $P * $RAGGIO_QUADRATICO_MEDIO;
}
}
