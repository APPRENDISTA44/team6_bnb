@extends('layouts.app')
@section('content')
  <div class="ms_apartment_list container">
    @foreach ($apartments as $apartment)
      <div class="row mt-4 ms_style">
        <div class="col-lg-4 col-sm-12">
          <!-- card singolo appartamento-->
          <img src="{{asset('storage' . '/' . $apartment->image)}}" alt="{{$apartment->title}}" class="card-img-top">
        </div>
        <div class="col-lg-8 col-sm-12">
          <h5>{{$apartment->title}}</h5>
          <p>{{$apartment->description}}</p>
          {{-- links --}}
          <div>
            <a class="ms_links" href="{{route('admin.apartment.show',$apartment->id)}}">Vai ai dettagli</a>
          </div>
          <div>
            <a class="ms_links" href="{{route('admin.apartment.chart',$apartment)}}">Vai alle statistiche</a>
          </div>
        </div>
      </div>
    @endforeach
  </div>

@endsection
