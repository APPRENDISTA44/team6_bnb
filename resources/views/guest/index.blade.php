@extends('layouts.app')
@section('content')

  @if (Auth::check())
    <div class="container">
      <a href="{{route('messages', Auth::user())}}">Vedi i tuoi messaggi</a>
    </div>
  @endif




  <div class="container" id="ms_homepage">
    <div class="row">
      <div class="col">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" id="ms_search_button" type="submit">Search</button>
      </div>
    </div>
  </div>
<div class="container">
  <div class="form-group">
     <label for="formControlRangeRooms">seleziona numero di stanze</label>
     <input type="range" class="form-control-range" id="formControlRangeRooms" min="1" max="50">
     <span class="ms_range_rooms"></span>
  </div>

  <div class="form-group">
     <label for="formControlRangeBeds">seleziona numero di letti</label>
     <input type="range" class="form-control-range" id="formControlRangeBeds" min="1" max="150">
     <span class="ms_range_beds"></span>
  </div>

  <div class="form-group">
     <label for="formControlRangeKm">seleziona chilometri di distanza</label>
     <input type="range" class="form-control-range" id="formControlRangeKm" min="20" max="100">
     <span class="ms_range_km"></span>
  </div>

  @if (!empty($tags))

    <div class="ms_tags_container">
      @foreach ($tags as $tag)
        <div>
          <input class="ms_checkbox" type="checkbox" name="tags[]" value="{{$tag->id}}">
          <label>{{$tag->tag}}</label>
        </div>
      @endforeach

    </div>
  @endif


  <div class="ms_apartment_container">

  </div>
</div>

<script id="ms_apartment_template" type="text/x-handlebars-template">
  <div class="container">
    <div class="row">
      <div class="col">
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
