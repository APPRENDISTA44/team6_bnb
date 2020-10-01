@extends('layouts.app')

@section('content')


<div class="container">
  <div class="row">
    <div class="col">
      {{-- Nome utente attualmente loggato --}}
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

    {{-- mappa --}}
    <div class="col">

      <h3>My Google Maps Demo</h3>
    <!--The div element for the map -->
    <div id="map"></div>
    <script>
      // Initialize and add the map
      function initMap() {
        // The location of Uluru
        var uluru = {lat: {{$apartment->latitude}}, lng: {{$apartment->longitude}}};
        // The map, centered at Uluru
        var map = new google.maps.Map(
          document.getElementById('map'), {zoom: 9, center: uluru});
          // The marker, positioned at Uluru
          var marker = new google.maps.Marker({position: uluru, map: map});
        }
    </script>
    <!--Load the API from the specified URL
    * The async attribute allows the browser to render the page while the API loads
    * The key parameter will contain your own API key (which is not needed for this tutorial)
    * The callback parameter executes the initMap() function
    -->
    <script defer
    src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_KEY')}}&callback=initMap">
    </script>
    </div>
  </div>


</div>
@endsection
