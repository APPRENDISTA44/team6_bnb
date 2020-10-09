@extends('layouts.app')
@section('content')

<div class="container ms_message_list mt-5">

  <h2>La lista dei tuoi messaggi </h2>
  <table class="table table-dark mt-5">
    <thead>
      <tr class="ms_table_first_row">
        <th scope="col">Mittente</th>
        <th scope="col">Messaggio</th>
        <th scope="col">Appartamento</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($messages as $apartment_messages)
          @foreach ($apartment_messages as $message)
            <tr>
              <td>{{$message->sender}}</td>
              <td>{{$message->text}}</td>
              <td class="ms_table_col_link" ><a class="ms_links" href="{{route('admin.apartment.show',$message->apartment_id)}}">Vai all'appartamento</a></td>
            </tr>
          @endforeach
        @endforeach


    </tbody>
  </table>


</div>
@endsection
