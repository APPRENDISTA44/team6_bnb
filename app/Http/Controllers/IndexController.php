<?php

namespace App\Http\Controllers;
use App\Apartment;
use App\Tag;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\View;
use App\Sponsor;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\ApartmentSponsor;


class IndexController extends Controller
{
    // INDEX
    public function index() {
      //trovo gli appartamenti sponsorizzati per popolare la sezione in evidenza
      $sponsors = ApartmentSponsor::all();
      $sponsors_filtered = $sponsors->where('date_end', '>', Carbon::now(new \DateTimeZone('Europe/Rome')))->groupBy('apartment_id');
      $array_sponsored_apartment = [];

      foreach ($sponsors_filtered as $key => $value) {
        $apartment = Apartment::find($key);
        $apartment_availability = $apartment->availability;
        if ($apartment_availability === 1) {
          $array_sponsored_apartment[] = $apartment;
        }
      }

        // dd($array_sponsored_apartment);

      //passa alla index i tags da mostrare per filtrare
      $tags = Tag::all();
      return view('guest.index', compact('tags','array_sponsored_apartment'));
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
        $apartment_availability = $apartment->availability;
        $distance = $this->points_distance($user_coordinates,$apartment_coordinates);
        //se l'appartamentoè disponibile
        if ($apartment_availability === 1) {
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
      }
      //ordino l'array basandomi sulla distanza dal punto di interesse, in ordine crescente
      usort($array_results, function($a, $b) {
        return $a['distance'] <=> $b['distance'];
      });


      //ritorno gli appartamenti disponibili in evidenza
      //trovo gli appartamenti sponsorizzati per popolare la sezione in evidenza
      $sponsors = ApartmentSponsor::all();
      $sponsors_filtered = $sponsors->where('date_end', '>', Carbon::now(new \DateTimeZone('Europe/Rome')))->groupBy('apartment_id');
      $array_sponsored_apartment = [];

      foreach ($sponsors_filtered as $key => $value) {
        $apartment = Apartment::find($key);
        $apartment_availability = $apartment->availability;
        if ($apartment_availability === 1) {
          $array_sponsored_apartment[] = $apartment;
        }
      }


      // ritorno in formato json l'array dei risultati
      return response()->json(['success'=>$array_results, 'sponsored'=>$array_sponsored_apartment]);
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

      //preparo array servizi da tornare alla view
      $array_tags = [];
      foreach ($apartment->tags as $tags) {
        $array_tags[] = $tags->tag;
      }

      //registro l'evento di visualizzazione andando a registrarlo nel db
      $new_view = new View();
      $new_view->apartment_id = $id;
      $new_view->date = Carbon::now()->format('Y-m-d');
      $new_view->save();

      return view("guest.show", compact("apartment","array_tags"));
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

          //calcolo totale numero di views
          $total_views = 0;
          foreach ($array_views as $number) {
            $total_views += $number;
          }

          //calcolo totale numero di messaggi ricevuti
          $total_messages = 0;
          foreach ($array_counts_message as $number) {
            $total_messages += $number;
          }



        return view('admin.apartments.chart',compact('apartment','total_views','total_messages'))
             ->with('array_dates',json_encode($array_dates,JSON_NUMERIC_CHECK))
             ->with('array_views',json_encode($array_views,JSON_NUMERIC_CHECK))
             ->with('array_dates_message',json_encode($array_dates_message,JSON_NUMERIC_CHECK))
             ->with('array_counts_message',json_encode($array_counts_message,JSON_NUMERIC_CHECK));
      }else {
        // se non corrisponde mostro pagina 404
        abort(404);
      }

    }

    //ritorno la view per effettuare sponsorizzazioni
    public function paymentHandler(Apartment $apartment){

      // trovo l'id utente loggato
      $user_id = Auth::id();
      if ($apartment->user_id === $user_id){
        $sponsors = Sponsor::all();
        //cerco se è presente una sponsorizzazione nello storico
        $array_sponsors = [];
        $array_sponsors = $apartment->sponsors()->where('apartment_id',$apartment->id)->first();
        $date_of_expire = 0;
        $date_of_expire_hour = 0;
        $date_of_expire_data = 0;

        //se è presente prendo la data di scadenza
        if ($array_sponsors !== null) {
          //la salvo in una variabile
          $date_of_expire = $apartment->sponsors()->where('apartment_id',$apartment->id)->latest()->first()->pivot->date_end;

          //controllo che la data di scadenza sia passata
          if ( Carbon::now(new \DateTimeZone('Europe/Rome'))->gt($date_of_expire) ) {
            //se è scaduto le do un valore 0
            $date_of_expire = 0;
          }else {
            //prendo la data e l'ora di $date_of_expire nel formato desiderato
            $array_date_of_expire = explode(" ", $date_of_expire);
            $date_of_expire_hour = $array_date_of_expire[1];
            $date_of_expire_data = $array_date_of_expire[0];
          }
        }

        return view('admin.apartments.sponsor', compact('sponsors', 'apartment','date_of_expire','date_of_expire_hour','date_of_expire_data'));

      }else {
        // se non corrisponde mostro pagina 404
        abort(404);
      }

    }


    //gestisco i dati ricevuti del pagamento
    public function paymentHandlerPost(Request $request){
      $data = $request->all();
      $apartments = Apartment::all();
      $sponsors = Sponsor::all();
      $apartment = $apartments->find($data['idApartment']);

      $sponsor = $sponsors->find($data['idSponsor']);

      $hours = $sponsor->hours_duration;

      $date_end = Carbon::now(new \DateTimeZone('Europe/Rome'));
      $date_end->addHours($hours);


      $apartment->sponsors()->attach($data['idSponsor'],
        [
          'date_end' => $date_end
        ]);

      // ritorno in formato json l'array dei risultati
      return response()->json(['success'=>$date_end]);

    }

}
