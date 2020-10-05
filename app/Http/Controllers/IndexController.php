<?php

namespace App\Http\Controllers;
use App\Apartment;
use App\Tag;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

      //registro l'evento di visualizzazione andando a registrarlo nel db
      $new_view = new View();
      $new_view->apartment_id = $id;
      $new_view->date = Carbon::now()->format('Y-m-d');
      $new_view->save();

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
      // trovo l'id utente loggato
      $user_id = Auth::id();
      if ($user_id === $user->id) {
        $apartments = Apartment::where('user_id', $user->id)->get();
        $messages = [];
        foreach ($apartments as $apartment) {
          $messages[] = Message::where('apartment_id', $apartment->id)->get();
        }

        return view('admin.messages.messages',compact('messages'));
      }else {
        // se non corrisponde mostro pagina 404
        abort(404);
      }

    }

    public function apartmentList(User $user){
      // trovo l'id utente loggato
      $user_id = Auth::id();
      if ($user_id === $user->id){
        //mostro la lista dei suoi appartamenti
        $apartments = Apartment::where('user_id', $user->id)->get();
        return view('admin.apartments.apartmentlist',compact('apartments'));
      }else {
        // se non corrisponde mostro pagina 404
        abort(404);
      }

    }

    // visualizzo le statistiche
    public function chartHandler(Apartment $apartment){
      // trovo l'id utente loggato
      $user_id = Auth::id();

      if ($apartment->user_id === $user_id) {
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
          //inserisco il conteggio per ogni data
          $array_views[] = count($view_value);
        }


        //prendo dati dei messaggi relativi all'appartamento

        // $messages = Message::where('apartment_id', $apartment->id)->get();
        // dd($messages);
        // $dates_message_group = $messages->groupBy('created_at');

        $messages = DB::table('messages')
          -> select(DB::raw('DATE(created_at) as date, COUNT(id) as count'))
          -> where('apartment_id', $apartment->id)
          -> groupBy('date')
          -> get();

          // dd($messages);

          $array_messages = [];

          foreach ($messages as $message) {
            $array_messages[] = [
              'count' => $message->count,
              'date' => $message->date
            ];
          }

          $array_dates_message = [];
          $array_counts_message = [];

          foreach ($array_messages as $message) {

            foreach ($message as $k => $v) {
              if ($k === 'count') {
                $array_counts_message[] = $v;
              }elseif ($k === 'date') {
                $array_dates_message[] = $v;
              }
            }
          }


        return view('admin.apartments.chart',compact('apartment'))
             ->with('array_dates',json_encode($array_dates,JSON_NUMERIC_CHECK))
             ->with('array_views',json_encode($array_views,JSON_NUMERIC_CHECK))
             ->with('array_dates_message',json_encode($array_dates_message,JSON_NUMERIC_CHECK))
             ->with('array_counts_message',json_encode($array_counts_message,JSON_NUMERIC_CHECK));
      }else {
        // se non corrisponde mostro pagina 404
        abort(404);
      }

    }

}
