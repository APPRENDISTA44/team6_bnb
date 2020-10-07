@extends('layouts.app')
@section('content')


  {{-- sezione con search e immagine di sfondo --}}
  <div class="container-fluid ms_homepage" id="ms_homepage">
    <div class="row">
      <div class="col">
        <div class="ms_background_image">
          <div class=" ms_absolute">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn my-2 my-sm-0" id="ms_search_button" type="submit">Search</button>
          </div>
        </div>

        <div class="text">
          <h1>Riscopri L'italia</h1>
          <p>Cambia quadro. Scopri alloggi nelle vicinanze tutti da vivere, per lavoro o svago.</p>
          <a href="#">Esplora i dintorni</a>
        </div>
      </div>
    </div>
  </div>
  {{-- fine sezione search e immagine di sfondo --}}

{{-- link ai messaggi ed appartamenti admin --}}
<div class="container ms_auth_links">
  <div class="row mt-4">
    <div class="col">
      @if (Auth::check())
          <div class="links float-right">
            <a class="ms_links" href="{{route('messages', Auth::user())}}">Vedi i tuoi messaggi</a>
            <a class="ms_links" href="{{route('admin.apartment.list', Auth::user())}}">Vedi i tuoi appartamenti</a>
          </div>
      @endif
    </div>
  </div>
</div>
{{-- fine sezione dei link --}}


{{-- sezione scelta filtri --}}
<div id="ms_filter_search">

  <div class="container mt-4">

    <h3>Seleziona i servizi di tuo interesse</h3>
    {{-- scelta servizi opzionali --}}
      @if (!empty($tags))

        <div class="ms_tags_container mt-3">
            <div class="row ms_tags_row">
              <div class="col-6">
                <div class="row">
                  @foreach ($tags as $tag)

                          <div class="col-md-6 col-sm-12">
                            <input class="ms_checkbox" type="checkbox" name="tags[]" value="{{$tag->id}}">
                            <label>{{$tag->tag}}</label>
                          </div>

                  @endforeach
                </div>
              </div>
            </div>
      @endif
      {{-- fine scelta servizi opzionali --}}

    {{-- scelta filtri numero camera, letti e km --}}
    <h3 class="mt-4">Seleziona i filtri di tuo interesse</h3>
    <div class="row">

      <div class="col-md-4 col-sm-12">

        <div class="form-group">
           <label for="formControlRangeRooms">seleziona numero di stanze</label>
           <span class="ms_range_rooms"></span>
           <input type="range" class="form-control-range" id="formControlRangeRooms" min="1" max="50">
        </div>
      </div>

      <div class="col-md-4 col-sm-12">
        <div class="form-group">
           <label for="formControlRangeBeds">seleziona numero di letti</label>
           <span class="ms_range_beds"></span>
           <input type="range" class="form-control-range" id="formControlRangeBeds" min="1" max="150">

        </div>
      </div>

      <div class="col-md-4 col-sm-12">
        <div class="form-group">
           <label for="formControlRangeKm">seleziona chilometri di distanza</label>
           <span class="ms_range_km"></span>
           <input type="range" class="form-control-range" id="formControlRangeKm" min="20" max="100">
        </div>
      </div>
    </div>
    {{-- fine scelta filtri numero camera, letti e km --}}

  </div>
</div>
{{-- FINE SEZIONE FILTRI --}}



{{-- inizio sezione che mostra appartamenti --}}
<div class="container">
  <div class="ms_apartment_container">

  </div>
</div>



<script id="ms_apartment_template" type="text/x-handlebars-template">
  <div class="container">
    <div class="row">
      <div class="col-4">

        <!-- card -->
        <div class="card" style="width: 18rem;">
          <img src="..." class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">@{{title}}</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
          </div>
        </div>


        <!-- Titolo -->
        <h1>@{{title}}</h1>
        <!-- Inidirzzo -->
        <div class="address">
        <h3>@{{city}} - @{{province}}</h3>
        </div>

        <!-- Immagine -->
        <div class="apartment_image">
        <img src="{{asset('storage') . "/" }}@{{image}}" alt="@{{title}}">
        </div>

        <!-- Collegamento a dettagli -->

        @if (Auth::check())
          <a href="admin/apartment/@{{id}}">Vedi dettagli</a>
        @else
          <a href="guest/apartment/@{{id}}">Vedi dettagli</a>
        @endif


      </div>
    </div>

  </div>
</script>


@endsection
