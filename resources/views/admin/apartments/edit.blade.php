@extends('layouts.app')
@section('content')
  <div class="container" id="ms_form_create">
    <div class="ms_title_delete_container d-flex justify-content-between align-items-center">
      <h1 class="mt-4 mb-3">Inserisci il tuo appartamento</h1>

      <form action="{{ route('admin.apartment.destroy', $apartment) }}" method="post">
        @csrf
        @method('DELETE')

        <input type="submit" class="btn btn-danger" value="Elimina appartamento">
      </form>

    </div>

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

        {{-- creo form per modificare o aggiornare appartamento--}}
        <form action="{{route('admin.apartment.update', $apartment)}}" method="post" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <!-- campo titolo -->
          <div class="mb-3">

            <label class="mb-2">Titolo</label>
            <input type="text" class="form-control" name="title" value="{{old('title') ? old('title') : $apartment->title}}" maxlength="255">
          </div>

          <!-- campo descrizione -->
          <div class="mb-3">

            <label class="mb-2">Descrizione</label>
            <textarea name="description" class="form-control" rows="8" cols="80">{{old('description') ? old('description') : $apartment->description}}</textarea>
          </div>

          <!-- campo numero di stanze -->
          <div class="mb-3">

            <label class="mb-2">Numero di stanze</label>
            <input type="number" pattern="[0-9]" class="form-control" name="number_of_rooms" value="{{old('number_of_rooms') ? old('number_of_rooms') : $apartment->number_of_rooms}}"max="50" min="1">
          </div>

          <!-- campo numero di letti -->
          <div class="mb-3">

            <label class="mb-2">Numero di letti</label>
            <input type="number" pattern="[0-9]" class="form-control" name="number_of_beds" value="{{old('number_of_beds') ? old('number_of_beds') : $apartment->number_of_beds}}"max="150" min="1">
          </div>

          <!-- campo numero di bagni -->
          <div class="mb-3">

            <label class="mb-2">Numbero di bagni</label>
            <input type="number" pattern="[0-9]" class="form-control" name="number_of_bathrooms" value="{{old('number_of_bathrooms') ? old('number_of_bathrooms') : $apartment->number_of_bathrooms}}"max="25" min="1">
          </div>

          <!-- campo matri quadrati -->
          <div class="mb-3">

            <label class="mb-2">Metri quadrati</label>
            <input type="number" pattern="[0-9]" class="form-control" name="sqm" value="{{old('sqm') ? old('sqm') : $apartment->sqm}}"max="1000" min="10" placeholder="minimo 10">
          </div>

          <!-- i checkbox creati dal foreach -->
          @if (!empty($tags))
            <div class="ms_tags_container">
              <hr>
              @foreach ($tags as $tag)
                <div class="mb-1">
                  <input type="checkbox" name="tags[]" {{ ($apartment->tags->contains($tag)) ? 'checked' : '' }} value="{{$tag->id}}">
                  <label class="mb-2">{{$tag->tag}}</label>
                </div>
              @endforeach
              <hr>
            </div>
          @endif

          <!-- l'immagine e campo immagine -->
          <div class="ms_image_container mb-3">
            <div class="row">
              <div class="col-12 col-lg-6">
                <div class="ms_img_form">
                  <img id="ms_image" src="{{ asset('storage') . '/' . $apartment->image }}" alt="{{ $apartment->title }}">
                </div>
              </div>
              <div class="col-12 col-lg-6 d-flex align-items-center mt-4 mt-lg-0">
                <label class="mr-2 ms_label_image">Sostituisci l'immagine</label>
                <input type="file" name="image" accept="image/*">
              </div>
            </div>

          </div>

          <!-- campo indirizzo -->
          <div class="ms_address mb-3">

            <label class="mb-2">Indirizzo</label>
            <input type="text" class="form-control" name="address" value="{{old('address') ? old('address') : $apartment->address}}">
          </div>
          <!-- campo città -->
          <div class="ms_city mb-3">

            <label class="mb-2">Città</label>
            <input type="text" class="form-control" name="city" value="{{old('city') ? old('city') : $apartment->city}}" maxlength="150">
          </div>

          <!-- campo cap -->
          <div class="ms_cap mb-3">

            <label class="mb-2">CAP</label>
            <input type="number" pattern="[0-9]" class="form-control" name="cap" value="{{old('cap') ? old('cap') : $apartment->cap}}" max="99999" min="0">
          </div>

          <!-- campo provincia -->
          <div class="ms_province mb-3">

            <label class="mb-2">Provincia</label>
            <input type="text" class="form-control" name="province" value="{{old('province') ? old('province') : $apartment->province}}" maxlength="2">
          </div>

          <!-- il bottone per generare le coordinate -->

          <button type="button" class="btn btn-success mb-3" id="ms_coordinate_generator">Genera coordinate e procedi</button>
          <div class="d-none ms_error">Alcuni campi sono scorretti</div>

          <!-- le coordinate -->
          <div class="ms_coordinates mb-3">
            <label class="mb-2">Longitudine</label>
            <input type="number" step="any" class="form-control ms_longitude" name="longitude" value="">

            <label class="mb-2">Latitudine</label>
            <input type="number" step="any" class="form-control ms_latitude" name="latitude" value="">
          </div>


          <!-- la select per mostrare o nascondere l'appartamento -->
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <label class="input-group-text" for="inputGroupSelect01">Seleziona disponibilità</label>
            </div>
            <select class="custom-select" id="inputGroupSelect01" name="availability">
            <option {{ ($apartment->availability === 1) ? "selected" : ""  }}  value="1">Disponibile</option>
            <option {{ ($apartment->availability === 0) ? "selected" : "" }} value="0">Non disponibile</option>
            </select>
          </div>

          <!-- salva -->
          <div class="mb-3 ms_submit">

            <input type="submit" class="btn btn-primary" name="" value="salva appartamento">
          </div>

        </form>


      </div>
    </div>
  </div>


@endsection
