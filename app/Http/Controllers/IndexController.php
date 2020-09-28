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

    //funzione per gestire coordinate e dati inviati da un utente
    //PARAMETRO: $request sono i dati che ricevo da una chiamata ajax
    //RETURN: Json coi dati recuperati dal db e filtrati da mostrare
    public function coordinatesHandler(Request $request){

      $data = $request->all();
      $latitude = $data['latitude'];
      $longitude = $data['longitude'];
      $distance_research = $data['distance'];
      //formatto cordinate per la funzione points_distance
      $user_coordinates = $latitude . ',' . $longitude;
      //inizializzo l'array dove salvero i dati da mostrare
      $array_results = [];

      //recupero gli appartamenti nel db
      $apartments = Apartment::all();
      //ciclo per filtrare gli appartamenti
      foreach ($apartments as $apartment) {
        $apartment_latitude = $apartment->latitude;
        $apartment_longitude = $apartment->longitude;
        $apartment_coordinates = $apartment_latitude . ',' . $apartment_longitude;
        $distance = $this->points_distance($user_coordinates,$apartment_coordinates);
        if ( $distance <= $distance_research ) {
          $array_results[] = $apartment;
        }
      }

      // ritorno in formato json l'array dei risultati
      return response()->json(['success'=>$array_results]);
    }


    //funzione per calcolare la distanza tra due punti
    //PARAMETRI: due stringhe contenenti entrambe latitudine e longitudine separate da virgola
    //RETURN: un float la distanza tra i due punti
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
