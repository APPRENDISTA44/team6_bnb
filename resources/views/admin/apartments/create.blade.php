@extends('layouts.app')
@section('content')
  <div class="container" id="ms_form_create">
    <div class="row">
      <div class="col-12">

        <h1>Inserisci il tuo appartamento</h1>

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
          <div>
            <br>
            <label>Titolo</label>
            <input type="text" class="form-control" name="title" value="{{old('title')}}" maxlength="255">
          </div>

          <!-- campo descrizione -->
          <div>
            <br>
            <label>Descrizione</label>
            <textarea name="description" class="form-control" rows="8" cols="80">{{old('description')}}</textarea>
          </div>

          <!-- campo numero di stanze -->
          <div>
            <br>
            <label>Numero di stanze</label>
            <input type="number" class="form-control" name="number_of_rooms" value="{{old('number_of_rooms')}}"  max="50" min="1">
          </div>

          <!-- campo numero di letti -->
          <div>
            <br>
            <label>Numero di letti</label>
            <input type="number" class="form-control" name="number_of_beds" value="{{old('number_of_beds')}}"  max="150" min="1">
          </div>

          <!-- numero di bagni -->
          <div>
            <br>
            <label>Numbero di bagni</label>
            <input type="number" class="form-control" name="number_of_bathrooms" value="{{old('number_of_bathrooms')}}" max="25" min="1">
          </div>

          <!-- campo metri quadrati  -->
          <div>
            <br>
            <label>Metri quadrati</label>
            <input type="number" class="form-control" name="sqm" value="{{old('sqm')}}" max="1000" min="10" placeholder="minimo 10">
          </div>

          <!-- i checkboxes -->
          @if (!empty($tags))

            <div class="ms_tags_container">
              @foreach ($tags as $tag)
                <div>
                  <input type="checkbox" name="tags[]" value="{{$tag->id}}">
                  <label>{{$tag->tag}}</label>
                </div>
              @endforeach

            </div>
          @endif


          <!-- l'immagine -->
          <div>
            <br>
            <label>Inserisci un'immagine dell'appartamento</label>
            <input type="file" name="image" accept="image/*">
          </div>

          <!-- campo Indirizzo -->
          <div class="ms_address">
            <br>
            <label>Indirizzo</label>
            <input type="text" class="form-control" name="address" value="{{old('address')}}">
          </div>
          <!-- campo città -->
          <div class="ms_city">
            <br>
            <label>Città</label>
            <input type="text" class="form-control" name="city" value="{{old('city')}}" maxlength="150">
          </div>
          <!-- campo cap -->
          <div class="ms_cap">
            <br>
            <label>CAP</label>
            <input type="number" class="form-control" name="cap" value="{{old('cap')}}" max="99999" min="0">
          </div>
          <!-- campo provincia -->
          <div class="ms_province">
            <br>
            <label>Provincia</label>
            <input type="text" class="form-control" name="province" value="{{old('province')}}" maxlength="2">
          </div>
          <!-- il bottone per generare le coordinate -->
          <br>
          <button type="button" class="btn btn-success" id="ms_coordinate_generator">Genera coordinate</button>
          <div class="d-none ms_error">Alcuni campi sono scorretti</div>
          <!-- le coordinate -->
          <div class="ms_coordinates">
            <label>Longitudine</label>
            <input type="number" step="any" class="form-control ms_longitude" name="longitude" value="{{old('longitude')}}">

            <label>Latitudine</label>
            <input type="number" step="any" class="form-control ms_latitude" name="latitude" value="{{old('latitude')}}">

          </div>

          <!-- il tasto salva -->
          <div>
            <br>
            <input type="submit" class="btn btn-primary" name="" value="salva appartamento">
          </div>

        </form>

      </div>
    </div>
  </div>


@endsection
