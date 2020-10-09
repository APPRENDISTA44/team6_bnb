@extends('layouts.app')
@section('content')

  <div class="ms_show">
    <div class="container">
      <div class="row">
        <div class="col">
          {{-- Nome utente attualmente loggato --}}
          <h1>Ciao {{$apartment->user->name}},</h1>

          {{-- Immagine --}}
          <div class="apartment_image">
            <img src="{{asset('storage') . "/" . $apartment->image}}" alt="{{$apartment->title}}">
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-12">
          {{-- Titolo --}}
          <h2>Titolo: {{$apartment->title}}</h2>
        </div>
        <div class="col-lg-4 col-md-12 mt-lg-4 mt-md-2">
          {{-- Descrizione --}}
          <p><strong>Descrizione:</strong> {{$apartment->description}}</p>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mt-lg-4 mt-md-2">
          <ul>
            <li>
              <i class="fas fa-map-marker-alt"></i>
              <strong> Indirizzo: </strong>{{$apartment->address}}
            </li>
            <li><strong> Città: </strong>{{$apartment->city}}</li>
            <li><strong> Cap: </strong>{{$apartment->cap}}</li>
            <li><strong> Provincia: </strong>{{$apartment->province}}</li>
          </ul>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mt-lg-4 mt-md-2">
          <ul>
            <li><i class="fas fa-home"></i> <strong>Numero di stanze: </strong> {{$apartment->number_of_rooms}}</li>
            <li><i class="fas fa-bed"></i> <strong>Numero di letti: </strong>{{$apartment->number_of_beds}}</li>
            <li><i class="fas fa-bath"></i> <strong>Numero di bagni: </strong>{{$apartment->number_of_bathrooms}}</li>
            <li><i class="fas fa-ruler-combined"></i> <strong>Metri quadrati: </strong>{{$apartment->sqm}}</li>

          </ul>
        </div>

        <div class="col-lg-2 col-md-6 col-sm-12 mt-lg-4 mt-md-2">
          <span> <strong>Altri servizi </strong></span>
          <ul>
              @foreach ($array_tags as $tag)


                  <li>{{ $tag }}</li>


              @endforeach
          </ul>
        </div>
        <div class="col-lg-2 col-md-6 col-sm-12 mt-lg-4 mt-md-2">
          <span> <strong>Altri servizi </strong></span>
          <ul>
            @foreach ($array_tags as $tag)


              <li>{{ $tag }}</li>


            @endforeach
          </ul>
        </div>


      </div>

      <div class="row">

        {{-- mappa --}}
        <div class="col-md-6 col-sm-12">
          <h3>My Google Maps Demo</h3>
          <!--The div element for the map -->
          <div id="map">
          </div>
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

        {{-- link ai messaggi ed appartamenti admin --}}
            <div class="col-md-6 col-sm-12 mt-4">
              @if (Auth::check())
                <div class="ms_admin_show_links">
                  <a class="ms_links" href="{{route('admin.apartment.chart',$apartment, Auth::user())}}">Vedi le statistiche</a>
                </div>
              @endif
            </div>
        {{-- fine sezione dei link --}}

      </div>

    </div>
  </div>

@endsection
