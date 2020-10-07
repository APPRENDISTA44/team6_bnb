@extends('layouts.app')
@section('content')
<div class="ms_show">
  <div class="container">
    <div class="row">
      <div class="col">
        @if (Auth::check())
          <h1>Ciao {{$user->name}}</h1>
        @else
          <h1>Ciao ospite</h1>
        @endif

        {{-- Immagine --}}
        <div class="apartment_image">
          <img src="{{asset('storage') . "/" . $apartment->image}}" alt="{{$apartment->title}}">
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col">
        {{-- Titolo --}}
        <h2>Titolo: {{$apartment->title}}</h2>
      </div>
      <div class="col-lg-6 col-md-12">
        {{-- Descrizione --}}
        <p><strong>Descrizione:</strong> {{$apartment->description}}</p>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-12">
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
      <div class="col-3">
        <ul>
          <li><strong>Numero di stanze:</strong> {{$apartment->number_of_rooms}}</li>
          <li><strong>Numero di letti:</strong>{{$apartment->number_of_beds}}</li>
          <li><strong>Numero di bagni</strong>{{$apartment->number_of_bathrooms}}</li>
          <li><strong>Metri quadrati:</strong>{{$apartment->sqm}}</li>
        </ul>
      </div>
    </div>

    <div class="row">
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

    {{-- se l'utente è loggato prendo la sua mail --}}
    @if (Auth::check())
      <div class="row">
        <div class="col">
          {{-- stampo messaggi di errore --}}
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{route('email',$apartment)}}" method="post">
            @csrf
            @method('POST')
            <label>Inserisci la tua mail</label>
            <p>{{$user->email}}</p>
            <textarea name="text" rows="8" cols="80">{{old('text')}}</textarea>
            <input type="submit" class="btn btn-primary" name="" value="manda email">
          </form>
        </div>
      </div>
      {{-- altrimenti mostro input dove inserire la mail --}}
    @else
      <div class="row">
        <div class="col">
          {{-- stampo messaggi di errore --}}
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          <form action="{{route('email',$apartment)}}" method="post">
            @csrf
            @method('POST')
            <label>Inserisci la tua mail</label>
            <input type="email" class="form-control" name="sender" value="{{old('sender')}}" maxlength="255">
            <textarea name="text" rows="8" cols="80">{{old('text')}}</textarea>
            <input type="submit" class="btn btn-primary" name="" value="manda email">
          </form>
        </div>
      </div>
    @endif


  </div>
</div>

@endsection
