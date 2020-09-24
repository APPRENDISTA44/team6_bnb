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
        <form action="{{route('admin.apartment.update', $apartment)}}" method="post" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div>
            <br>
            <label>Titolo</label>
            <input type="text" class="form-control" name="title" value="{{old('title') ? old('title') : $apartment->title}}" maxlength="255">
          </div>

          <div>
            <br>
            <label>Descrizione</label>
            <textarea name="description" class="form-control" rows="8" cols="80">{{old('description') ? old('description') : $apartment->description}}</textarea>
          </div>

          <div>
            <br>
            <label>Numero di stanze</label>
            <input type="number" class="form-control" name="number_of_rooms" value="{{old('number_of_rooms') ? old('number_of_rooms') : $apartment->number_of_rooms}}">
          </div>

          <div>
            <br>
            <label>Numero di letti</label>
            <input type="number" class="form-control" name="number_of_beds" value="{{old('number_of_beds') ? old('number_of_beds') : $apartment->number_of_beds}}">
          </div>

          <div>
            <br>
            <label>Numbero di bagni</label>
            <input type="number" class="form-control" name="number_of_bathrooms" value="{{old('number_of_bathrooms') ? old('number_of_bathrooms') : $apartment->number_of_bathrooms}}">
          </div>

          <div>
            <br>
            <label>Metri quadrati</label>
            <input type="number" class="form-control" name="sqm" value="{{old('sqm') ? old('sqm') : $apartment->sqm}}">
          </div>

          @if (!empty($tags))
            <div class="ms_tags_container">
              @foreach ($tags as $tag)
                <div>
                  <input type="checkbox" name="tags[]" {{ ($apartment->tags->contains($tag)) ? 'checked' : '' }} value="{{$tag->id}}">
                  <label>{{$tag->tag}}</label>
                </div>
              @endforeach

            </div>
          @endif


          <div>
            <br>
            <label>Inserisci un'immagine dell'appartamento</label>
            <input type="file" name="image" accept="image/*" value={{$apartment->image}}>
          </div>

          <div class="ms_address">
            <br>
            <label>Indirizzo</label>
            <input type="text" class="form-control" name="address" value="{{old('address') ? old('address') : $apartment->address}}">
          </div>

          <div class="ms_city">
            <br>
            <label>Città</label>
            <input type="text" class="form-control" name="city" value="{{old('city') ? old('city') : $apartment->city}}" maxlength="150">
          </div>

          <div class="ms_cap">
            <br>
            <label>CAP</label>
            <input type="number" class="form-control" name="cap" value="{{old('cap') ? old('cap') : $apartment->cap}}" max="99999" min="0">
          </div>

          <div class="ms_province">
            <br>
            <label>Provincia</label>
            <input type="text" class="form-control" name="province" value="{{old('province') ? old('province') : $apartment->province}}" maxlength="2">
          </div>

          <br>
          <button type="button" class="btn btn-success" id="ms_coordinate_generator">Genera coordinate</button>
          <div class="d-none ms_error">Alcuni campi sono scorretti</div>

          <div class="ms_coordinates">
            <label>Longitudine</label>
            <input type="number" step="any" class="form-control ms_longitude" name="longitude" value="">

            <label>Latitudine</label>
            <input type="number" step="any" class="form-control ms_latitude" name="latitude" value="">
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
