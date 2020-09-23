@extends('layouts.app')
@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">

        <h1>Crea il tuo post</h1>

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
            <label>Titolo</label>
            <input type="text" class="form-control" name="title" value="{{old('title')}}">
          </div>

          <div>
            <label>Descrizione</label>
            <textarea name="description" class="form-control" rows="8" cols="80">{{old('description')}}</textarea>
          </div>




          <div>
            <label>Numero di stanze</label>
            <input type="number" class="form-control" name="number_of_rooms" value="{{old('number_of_rooms')}}">
          </div>

          <div>
            <label>Numero di letti</label>
            <input type="number" class="form-control" name="number_of_beds" value="{{old('number_of_beds')}}">
          </div>

          <div>
            <label>Numbero di bagni</label>
            <input type="number" class="form-control" name="number_of_bathrooms" value="{{old('number_of_bathrooms')}}">
          </div>

          <div>
            <label>Metri quadrati</label>
            <input type="number" class="form-control" name="sqm" value="{{old('sqm')}}">
          </div>

          <div>
            <label>Indirizzo</label>
            <input type="text" class="form-control" name="address" value="{{old('address')}}">
          </div>

          <div>
            <label>Città</label>
            <input type="text" class="form-control" name="city" value="{{old('city')}}">
          </div>

          <div>
            <label>CAP</label>
            <input type="number" class="form-control" name="cap" value="{{old('cap')}}">
          </div>

          <div>
            <label>Provincia</label>
            <input type="text" class="form-control" name="province" value="{{old('province')}}">
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
