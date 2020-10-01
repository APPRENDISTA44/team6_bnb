@extends('layouts.app')
@section('content')

<div class="container">

  @foreach ($messages as $apartment_messages)


    @foreach ($apartment_messages as $message)
      <div class="row">
        <div class="col-4">
          <h3>{{$message->sender}}</h3>
        </div>
        <div class="col-6">
          <p>{{$message->text}}</p>
        </div>
        <div class="col-2">
          <a href="{{route('admin.apartment.show',$message->apartment_id)}}">Vai all'appartamento</a>
        </div>
      </div>

    @endforeach

  @endforeach



</div>
@endsection
