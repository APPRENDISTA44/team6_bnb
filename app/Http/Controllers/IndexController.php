<?php

namespace App\Http\Controllers;
use App\Apartment;
use App\Tag;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\View;

class IndexController extends Controller
{
    // INDEX
    public function index() {
      //recupero gli appartamenti nel db
      $apartments = Apartment::all();
      $tags = Tag::all();
      return view('guest.index', compact('apartments','tags'));
    }

    //funzione per gestire coordinate e dati inviati da un utente
    //PARAMETRO: $request sono i dati che ricevo da una chiamata ajax
    //RETURN: Json coi dati recuperati dal db e filtrati da mostrare
    public function coordinatesHandler(Request $request){

      $data = $request->all();
      $latitude = $data['latitude'];
      $longitude = $data['longitude'];
      $number_of_rooms = $data['rangeRooms'];
      $number_of_beds = $data['rangeBeds'];
      if (!empty($data['arrayTags'])) {
        $array_tags = $data['arrayTags'];
      }else {
        $array_tags = [];
      }
      $distance_research = $data['distance'];
      //formatto cordinate per la funzione points_distance
      $user_coordinates = $latitude . ',' . $longitude;
      //inizializzo l'array dove salvero i dati da mostrare
      $array_results = [];

      //recupero gli appartamenti nel db
      $apartments = Apartment::all();
      //ciclo per filtrare gli appartamenti
      foreach ($apartments as $apartment) {
        $array_apartment_tag = [];


        $apartment_rooms = $apartment->number_of_rooms;
        $apartment_beds = $apartment->number_of_beds;
        $apartment_latitude = $apartment->latitude;
        $apartment_longitude = $apartment->longitude;
        $apartment_coordinates = $apartment_latitude . ',' . $apartment_longitude;
        $distance = $this->points_distance($user_coordinates,$apartment_coordinates);
        //se la distanza dell'appartamento è minore di quella settata
        if ( $distance <= $distance_research ) {
          //se il numero di stanze e il numero dei letti sono maggiori di quelli settati
          if ( ($apartment_rooms >= $number_of_rooms) && ($apartment_beds >= $number_of_beds) ) {
            //se non ha selezionato tags mostro tutti i risultati
            if (empty($array_tags)) {
              //mostro l'appartamento
              $array_results[] = [
                'distance' => $distance,
                'apartment' => $apartment
              ];
              //altrimenti se l'utente ha selezionato dei tag
            }else {
              //creo un array di oggetti tags
              $apartments_tags = $apartment->tags;
              //se non è vuoto
              if (!empty($apartments_tags)) {
                //cicliamo su array di oggetti tags e metto l'id dei tags presenti
                //in un array di supporto
                foreach ($apartments_tags as $apartments_tag) {
                  $array_apartment_tag[] = $apartments_tag->id;
                }
                //controllo che $array_apartment_tag contenga tutti gli elementi di $array_tags
                if (count($array_tags) === count(array_intersect($array_tags,$array_apartment_tag))) {
                  //mostro l'appartamento
                  $array_results[] = [
                    'distance' => $distance,
                    'apartment' => $apartment
                  ];
                }
              }
            }
          }
        }
      }
      //ordino l'array basandomi sulla distanza dal punto di interesse, in ordine crescente
      usort($array_results, function($a, $b) {
        return $a['distance'] <=> $b['distance'];
      });


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


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     // SHOW PER OSPITI
    public function show($id){
      $apartment = Apartment::find($id);
      return view("guest.show", compact("apartment"));
    }

    //gestisco l'arrivo di mail
    public function emailHandler(Request $request, Apartment $apartment){

      //se l'utente è loggato
      if (Auth::check()) {

        // Validiamo i dati immessi dall'utente nel form
        $request->validate([
          'text' => 'required|max:3000',
        ]);
          // Prendo i dati dal form
        $data = $request->all();

        $new_message = new Message();

        $new_message->apartment_id = $apartment->id;
        $new_message->text = $data['text'];
        $user = Auth::user();
        $new_message->sender = $user->email;
        //altrimenti se non è loggato
      } else {
        // Validiamo i dati immessi dall'utente nel form
        $request->validate([
          'text' => 'required|max:3000',
          'sender' => 'required|max:255|email|string'
        ]);
        // Prendo i dati dal form
        $data = $request->all();

        $new_message = new Message();

        $new_message->apartment_id = $apartment->id;
        $new_message->text = $data['text'];
        $new_message->sender = $data['sender'];
      }

      $new_message->save();

    }
    //gestisco i messaggi ricevuti da un utente
    public function messages(User $user){

      $apartments = Apartment::where('user_id', $user->id)->get();
      $messages = [];
      foreach ($apartments as $apartment) {
        $messages[] = Message::where('apartment_id', $apartment->id)->get();
      }

      return view('admin.messages.messages',compact('messages'));

    }

    public function apartmentList(User $user){
      $apartments = Apartment::where('user_id', $user->id)->get();
      return view('admin.apartments.apartmentlist',compact('apartments'));
    }

    // visualizzo le statistiche
    public function chartHandler(Apartment $apartment){
      // Recupero il numero di visite
      $views = View::where('apartment_id', $apartment->id)->get();
      // Recupero le date
      $dates_view_group = $views->groupBy('date');

      $array_dates = [];

      $array_views = [];
      // inizializzo foreach per riempire gli array


      foreach ($dates_view_group as $date_key => $view_value ) {

        // inserisco ogni singola data nell'array
        $array_dates[] = $date_key;

      }

      foreach ($dates_view_group as $date_key => $view_value) {

        $array_views[] = count($view_value);



      }
      // dd($array_views);
      // dd($dates_view_group);
      // dd($array_dates);
      // Ritorno gli array
      return view('admin.apartments.chart',compact('apartment', 'array_dates', 'array_views'));
    }



}
