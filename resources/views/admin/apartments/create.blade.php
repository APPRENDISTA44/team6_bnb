@extends('layouts.app')
@section('content')
  <div class="container" id="ms_form_create">
    <h1 class="mt-4 mb-3">Inserisci il tuo appartamento</h1>
    <div class="row">
      <div class="col-12">



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

        {{-- creo form per creazione appartamenti--}}

        <form action="{{route('admin.apartment.store')}}" method="post" enctype="multipart/form-data">
          @csrf
          @method('POST')

          <!-- campo titolo -->
          <div class="mb-3">

            <label class="mb-2">Titolo</label>
            <input type="text" class="form-control" name="title" value="{{old('title')}}" maxlength="255">
          </div>

          <!-- campo descrizione -->
          <div class="mb-3">

            <label class="mb-2">Descrizione</label>
            <textarea name="description" class="form-control" rows="8" cols="80">{{old('description')}}</textarea>
          </div>

          <!-- campo numero di stanze -->
          <div class="mb-3">

            <label class="mb-2">Numero di stanze</label>
            <input type="number" pattern="[0-9]" class="form-control" name="number_of_rooms" value="{{old('number_of_rooms')}}"  max="50" min="1">
          </div>

          <!-- campo numero di letti -->
          <div class="mb-3">

            <label class="mb-2">Numero di letti</label>
            <input type="number" pattern="[0-9]" class="form-control" name="number_of_beds" value="{{old('number_of_beds')}}"  max="150" min="1">
          </div>

          <!-- numero di bagni -->
          <div class="mb-3">

            <label class="mb-2">Numbero di bagni</label>
            <input type="number" pattern="[0-9]" class="form-control" name="number_of_bathrooms" value="{{old('number_of_bathrooms')}}" max="25" min="1">
          </div>

          <!-- campo metri quadrati  -->
          <div class="mb-3">

            <label class="mb-2">Metri quadrati</label>
            <input type="number" pattern="[0-9]" class="form-control" name="sqm" value="{{old('sqm')}}" max="1000" min="10" placeholder="minimo 10">
          </div>

          <!-- i checkboxes -->
          @if (!empty($tags))

            <div class="ms_tags_container">
              <hr>
              @foreach ($tags as $tag)
                <div class="mb-1">
                  <input type="checkbox" name="tags[]" value="{{$tag->id}}">
                  <label class="mb-2">{{$tag->tag}}</label>
                </div>
              @endforeach
              <hr>
            </div>
          @endif


          <!-- l'immagine -->
          <div class="mb-3">

            <label class="mr-4">Inserisci un'immagine dell'appartamento</label>
            <input type="file" name="image" accept="image/*">
          </div>

          <!-- campo Indirizzo -->
          <div class="ms_address mb-3">

            <label class="mb-2">Indirizzo</label>
            <input type="text" class="form-control" name="address" value="{{old('address')}}">
          </div>
          <!-- campo città -->
          <div class="ms_city mb-3">

            <label class="mb-2">Città</label>
            <input type="text" class="form-control" name="city" value="{{old('city')}}" maxlength="150">
          </div>
          <!-- campo cap -->
          <div class="ms_cap mb-3">

            <label class="mb-2">CAP</label>
            <input type="number" pattern="[0-9]" class="form-control" name="cap" value="{{old('cap')}}" max="99999" min="0">
          </div>
          <!-- campo provincia -->
          <div class="ms_province mb-3">

            <label class="mb-2">Provincia</label>
            <input type="text" class="form-control" name="province" value="{{old('province')}}" maxlength="2">
          </div>
          <!-- il bottone per generare le coordinate -->

          <button type="button" class="btn btn-success mb-3" id="ms_coordinate_generator">Genera coordinate e procedi</button>
          <div class="d-none ms_error">Alcuni campi sono scorretti</div>
          <!-- le coordinate -->
          <div class="ms_coordinates mb-3">
            <label class="mb-2">Longitudine</label>
            <input type="number" step="any" class="form-control ms_longitude" name="longitude" value="{{old('longitude')}}">

            <label class="mb-2">Latitudine</label>
            <input type="number" step="any" class="form-control ms_latitude" name="latitude" value="{{old('latitude')}}">

          </div>

          <!-- il tasto salva -->
          <div class="mb-3 ms_submit">

            <input type="submit" class="btn btn-primary" name="" value="salva appartamento">
          </div>

        </form>

      </div>
    </div>
  </div>


@endsection
