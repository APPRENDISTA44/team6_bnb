@extends('layouts.app')
@section('content')
  <div class="ms_apartment_list container">
    @foreach ($apartments as $apartment)
      <div class="row">
        <div class="col">
          <!-- card singolo appartamento-->
          <div class="card">
            <img src="{{asset('storage' . '/' . $apartment->image)}}" alt="{{$apartment->title}}" class="card-img-top">
            <div class="card-body">
              <h5 class="card-title">{{$apartment->title}}</h5>
              <p class="card-text">{{$apartment->description}}</p>
              <a class="ms_links" href="{{route('admin.apartment.show',$apartment->id)}}">Vai ai dettagli</a>
              <a class="ms_links" href="{{route('admin.apartment.chart',$apartment)}}">Vai alle statistiche</a>
            </div>
          </div>
        </div>
      </div>
      @endforeach
  </div>


  {{-- @foreach ($apartments as $apartment)
    <div class="row">
      <div class="col">
        {{$apartment->title}}
      </div>
      <div class="col">
        {{$apartment->city}}
      </div>
      <div class="col">
        <a href="{{route('admin.apartment.show',$apartment->id)}}">Vai ai dettagli</a>
      </div>
      <div class="col">
        <a href="{{route('admin.apartment.chart',$apartment)}}">Vai alle statistiche</a>
      </div>
    </div>
  @endforeach --}}

@endsection
