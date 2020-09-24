<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Apartment;
use App\Tag;
use Illuminate\Support\Facades\Auth;


class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
      //validiamo
      $request->validate([
        'title' => 'required|max:255',
        'description' => 'max:3000',
        'number_of_rooms' => 'required|min:1|max:50',
        'number_of_beds' => 'required|min:1|max:150',
        'number_of_bathrooms' => 'required|min:1|max:25',
        'sqm' => 'min:10|max:1000|numeric',
        'address' => 'required|max:500|string',
        'city' => 'required|max:150|string|alpha',
        'cap' => 'required|min:0|max:99999|numeric',
        'province' => 'required|min:2|max:2|string|alpha',
        'image' => 'required|image',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric'
      ]);

      $data = $request->all();

      //creo nuovo appartamento
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

      //salvo immagine
      $path = $request->file('image')->store('images','public');
      $apartment_new->image = $path;

      //salvo l'id dell'utente attivo
      $apartment_new->user_id = Auth::id();

      $apartment_new->availability = true;
      $apartment_new->save();
      
      if (isset($data['tags'])) {
        $apartment_new->tags()->sync($apartment_new['tags']);
      }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
