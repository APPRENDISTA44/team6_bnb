@extends('layouts.app')
@section('content')

<div class="container">
  @foreach ($apartments as $apartment)
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


  @endforeach


</div>
@endsection
