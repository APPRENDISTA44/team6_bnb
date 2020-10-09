@extends('layouts.app')
@section('content')
  <section class="page_404">
  	<div class="container">
  		<div class="row">
  		<div class="col-sm-12 ">
  		<div class="col-sm-10 col-sm-offset-1 offset-sm-1  text-center">
  		<div class="four_zero_four_bg">
  			<h1 class="text-center ">404</h1>


  		</div>

  		<div class="contant_box_404">
  		<h3 class="h2">
  		Sembra che tu ti sia perso...
  		</h3>

  		<p>la pagina che cerchi non è disponibile!</p>

  		<a href="{{route('home')}}" class="link_404">Vai alla Home</a>
  	</div>
  		</div>
  		</div>
  		</div>
  	</div>
  </section>
@endsection
