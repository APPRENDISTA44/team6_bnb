@extends('layouts.app')

@section('content')


<div class="container">
  <div class="row">
    <div class="col">
      <h1>Ciao {{$apartment->user->name}}</h1>
      {{-- Titolo --}}
      <h2>Titolo: {{$apartment->title}}</h2>
      {{-- Descrizione --}}
      <p><strong>Descrizione:</strong> {{$apartment->description}}</p>
      <ul>
        {{-- Numero Stanze --}}
        <li><strong>Numero di stanze:</strong> {{$apartment->number_of_rooms}}</li>
        {{-- Numero letti --}}
        <li><strong>Numero di letti:</strong>{{$apartment->number_of_beds}}</li>
        {{-- Numero bagni --}}
        <li><strong>Numero di bagni</strong>{{$apartment->number_of_bathrooms}}</li>
      </ul>
      <ul>
        {{-- Metri quadrati --}}
        <li><strong>Metri quadrati:</strong>{{$apartment->sqm}}</li>
        {{-- Indirizzo --}}
        <li><strong>Indirizzo:</strong>{{$apartment->address}}</li>
        {{-- Città --}}
        <li><strong>City:</strong>{{$apartment->city}}</li>
        {{-- Cap --}}
        <li><strong>Cap:</strong>{{$apartment->cap}}</li>
        {{-- Provincia --}}
        <li><strong>Provincia:</strong>{{$apartment->province}}</li>
      </ul>
      {{-- Immagine --}}
      <div class="apartment_image">
        <img src="{{asset('storage') . "/" . $apartment->image}}" alt="{{$apartment->title}}">

      </div>
    </div>

  </div>

</div>
@endsection
