@extends('layouts.app')
@section('content')

  {{-- sezione con search e immagine di sfondo --}}
  <div class="ms_homepage" id="ms_homepage">
    <div class="ms_background_image">
      <div class=" ms_absolute">
        <input class="form-control mr-sm-2" type="search" placeholder="Dove vuoi andare?" aria-label="Search">
        <button class="btn my-2 my-sm-0" id="ms_search_button" type="submit">Cerca</button>
      </div>
    </div>
    <div class="text">
      <blockquote>
        <h2>Il mondo è un libro, e chi non viaggia ne legge solo una pagina.</h2>
        <cite>Agostino d’Ippona</cite>
      </blockquote>
    </div>
  </div>

  {{-- fine sezione search e immagine di sfondo --}}
  @if (!empty($array_sponsored_apartment))
    <div class="container ms_sposored_apartment">
      <div class="row mt-4">
        <div class="col">
          <h2>Appartamenti in Evidenza</h2>
        </div>
      </div>

      <div class="row">
        {{--  sezione con gli appartamenti sponsorizzati --}}
        @foreach ($array_sponsored_apartment as $sponsored_apartment)

          <div class="col-lg-4 col-md-6 col-sm-12 mt-2">

            <!-- card singolo appartamento-->
            <div class="card">
              <img src="{{asset('storage') . "/" . $sponsored_apartment->image }}" alt="{{$sponsored_apartment->title}}" class="card-img-top">
              <div class="card-body">
                <h5 class="card-title">{{$sponsored_apartment->title}}</h5>
                <p class="card-text">{{$sponsored_apartment->description}}</p>

                @if (Auth::check())
                  <a class="ms_links" href="admin/apartment/{{$sponsored_apartment->id}}">Vedi dettagli</a>
                @else
                  <a class="ms_links" href="guest/apartment/{{$sponsored_apartment->id}}">Vedi dettagli</a>
                @endif
              </div>
            </div>
          </div>

        @endforeach
      </div>

    </div>
  @endif


{{-- sezione scelta filtri --}}
<div id="ms_filter_search" class="d-none">
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

{{-- inizio sezione che mostra appartamenti in evidenza --}}
  <div class="container mt-3">
    <h2 class="ms_evidence"></h2>
    <div class="row ms_apartment_sponsored_container">

    </div>
  </div>
{{-- fine sezione che mostra appartamenti in evidenza--}}

{{-- inizio sezione che mostra appartamenti --}}
  <div class="container mt-5">
    <h2 class="ms_searched"></h2>

    <div class="row ms_apartment_container">

    </div>
  </div>
{{-- fine sezione che mostra appartamenti --}}

{{-- Inzio template handlebars per mostrare appartamenti --}}
<script id="ms_apartment_template" type="text/x-handlebars-template">
  <div class="col-lg-4 col-md-6 col-sm-12 mt-4">

    <!-- card singolo appartamento-->
    <div class="card">
      <img src="{{asset('storage') . "/" }}@{{image}}" alt="@{{title}}" class="card-img-top">
      <div class="card-body">
        <h5 class="card-title">@{{title}}</h5>
        <p class="card-text">@{{description}}</p>

        @if (Auth::check())
          <a class="ms_links" href="admin/apartment/@{{id}}">Vedi dettagli</a>
        @else
          <a class="ms_links" href="guest/apartment/@{{id}}">Vedi dettagli</a>
        @endif
      </div>
    </div>
  </div>
</script>
@endsection
