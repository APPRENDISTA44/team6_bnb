<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Apartment;
use App\Tag;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\View;





class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $tags = Tag::all();
      return view('admin.apartments.create',compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // Validiamo i dati immessi dall'utente nel form
      // regole nella funzione validation Rules
      $request->validate($this->validationRulesCreate($this->validationRules()));

      // Prendo i dati dal form
      $data = $request->all();

      // Creo nuova istanza di appartamento con i dati
      $apartment_new = new Apartment();

      $apartment_new->title = $data['title'];
      $apartment_new->description = $data['description'];
      $apartment_new->number_of_rooms = $data['number_of_rooms'];
      $apartment_new->number_of_beds = $data['number_of_beds'];
      $apartment_new->number_of_bathrooms = $data['number_of_bathrooms'];
      $apartment_new->sqm = $data['sqm'];
      $apartment_new->address = $data['address'];
      $apartment_new->city = $data['city'];
      $apartment_new->cap = $data['cap'];
      $apartment_new->province = $data['province'];
      $apartment_new->latitude = $data['latitude'];
      $apartment_new->longitude = $data['longitude'];

      // Salvo immagine caricata nel server
      $path = $request->file('image')->store('images','public');
      // Salvo nel database il path dell'immagine
      $apartment_new->image = $path;

      // Salvo l'id dell'utente admin che sta creando l'appartamento
      $apartment_new->user_id = Auth::id();

      // Setto disponibilità di visualizzazione default true
      $apartment_new->availability = true;

      // Salvo i dati dell'istanza
      $apartment_new->save();

      // Verifichiamo che siano presenti dei tags
      // se ci sono li associamo al nuovo appartamento
      if (isset($data['tags'])) {
        $apartment_new->tags()->sync($data['tags']);
      }

        return redirect()->route('admin.apartment.show', $apartment_new);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $user = Auth::user();
      $apartment = Apartment::find($id);

      $array_tags = [];
      if (!empty($apartment->tags)) {
        foreach ($apartment->tags as $tags) {
          $array_tags[] = $tags->tag;
        }
      }
      // dd($apartment);

      // trovo l'id utente loggato
      $user_id = Auth::id();

      // Se l'utente corrisponde a quello loggato

      if ($user_id === $apartment->user_id) {


        // Gli mostro i dettagli del suo appartamento
        return view("admin.apartments.show", compact("apartment","array_tags"));

      // Altrimenti, gli mostro quello degli ospiti
      } else {
        //registro l'evento di visualizzazione andando a registrarlo nel db
        $new_view = new View();
        $new_view->apartment_id = $id;
        $new_view->date = Carbon::now()->format('Y-m-d');
        $new_view->save();
        return view("guest.show", compact("apartment","user","array_tags"));
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
        // trovo l'id utente loggato
        $user_id = Auth::id();

        // controllo se corrisponde con l'id dell'utente che ha creato l'appartamento
        if($user_id === $apartment->user_id) {

            // se corrisponde procedo:

            // prendo i nomi dei tag dalla tabella del database
            $tags = Tag::all();
            // ritorno la view per modificare gli appartamenti con i tag che servono
            // per fare i checkbox
            return view('admin.apartments.edit', compact('apartment','tags'));

        } else {
          // se non corrisponde mostro pagina 404
          abort(404);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apartment $apartment)
    {
      // Validiamo i dati immessi dall'utente nel form
      // regole nella funzione validation Rules
      $request->validate($this->validationRulesUpdate($this->validationRules()));

      // Prendo i dati cambiati dal form
      $data = $request->all();

      if ( !empty($request->file('image')) ) {
        // Salvo immagine caricata nel server
        $path = $request->file('image')->store('images','public');
        // Salvo nel database il path dell'immagine
        $data['image'] = $path;
      }


      // Verifichiamo che siano presenti dei tags
      // se ci sono li associamo al nuovo appartamento
      if (isset($data['tags'])) {
        $apartment->tags()->sync($data['tags']);
      } else {
        $apartment->tags()->detach();
      }

      // Update dei dati dell'apartamento
      $apartment->update($data);

      return redirect()->route('admin.apartment.show', $apartment);



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {
      $apartment->tags()->detach();
      $apartment->sponsors()->detach();
      $apartment->delete();
      return redirect()->route('admin.apartment.list', Auth::user());
    }

    // Funzione con le regole di validazione
    // RETURN: torna un array con le regole
    public function validationRules() {
      return  [
        'title' => 'required|max:255',
        'description' => 'max:3000',
        'number_of_rooms' => 'required|min:1|max:50|integer',
        'number_of_beds' => 'required|min:1|max:150|integer',
        'number_of_bathrooms' => 'required|min:1|max:25|integer',
        'sqm' => 'min:10|max:1000|numeric|integer',
        'address' => 'required|max:500|string',
        'city' => 'required|max:150|string|alpha',
        'cap' => 'required|min:0|max:99999|integer',
        'province' => 'required|min:2|max:2|string|alpha',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
      ];
    }

    // Funzione con le regole di validazione specifiche per update
    // PARAMETRO: accetta un array con le regole generali
    // RETURN: torna un array con le regole specifiche per update
    public function validationRulesUpdate($array) {
      $array["availability"] = 'required|boolean';
      $array["image"] = 'image';
      return $array;
    }
    public function validationRulesCreate($array){
      $array["image"] = 'required|image';
      return $array;
   }
}
