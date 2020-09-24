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

        <form action="" method="post" enctype="multipart/form-data">
          @csrf
          @method('POST')

          <div>
            <br>
            <label>Titolo</label>
            <input type="text" class="form-control" name="title" value="{{old('title')}}" maxlength="255">
          </div>

          <div>
            <br>
            <label>Descrizione</label>
            <textarea name="description" class="form-control" rows="8" cols="80">{{old('description')}}</textarea>
          </div>

          <div>
            <br>
            <label>Numero di stanze</label>
            <input type="number" class="form-control" name="number_of_rooms" value="{{old('number_of_rooms')}}">
          </div>

          <div>
            <br>
            <label>Numero di letti</label>
            <input type="number" class="form-control" name="number_of_beds" value="{{old('number_of_beds')}}">
          </div>

          <div>
            <br>
            <label>Numbero di bagni</label>
            <input type="number" class="form-control" name="number_of_bathrooms" value="{{old('number_of_bathrooms')}}">
          </div>

          <div>
            <br>
            <label>Metri quadrati</label>
            <input type="number" class="form-control" name="sqm" value="{{old('sqm')}}">
          </div>

          <div class="ms_address">
            <br>
            <label>Indirizzo</label>
            <input type="text" class="form-control" name="address" value="{{old('address')}}">
          </div>

          <div class="ms_city">
            <br>
            <label>Città</label>
            <input type="text" class="form-control" name="city" value="{{old('city')}}" maxlength="150">
          </div>

          <div class="ms_cap">
            <br>
            <label>CAP</label>
            <input type="number" class="form-control" name="cap" value="{{old('cap')}}" max="99999">
          </div>

          <div class="ms_province">
            <br>
            <label>Provincia</label>
            <input type="text" class="form-control" name="province" value="{{old('province')}}" maxlength="2">
          </div>

          <br>
          <button type="button" class="btn btn-success" id="ms_coordinate_generator">Genera coordinate</button>

          <div class="ms_coordinates">
            <label>Longitudine</label>
            <input type="number" class="form-control ms_longitude" name="longitude" value="{{old('longitude')}}">

            <label>Latitudine</label>
            <input type="number" class="form-control ms_latitude" name="latitude" value="{{old('latitude')}}">

          </div>


          <div>
            <br>
            <label>Post Image</label>
            <input type="file" name="image_path" accept="image/*">
          </div>

          <div>
            <br>
            <input type="submit" class="btn btn-primary" name="" value="salva post">
          </div>

        </form>


      </div>
    </div>
  </div>


@endsection
