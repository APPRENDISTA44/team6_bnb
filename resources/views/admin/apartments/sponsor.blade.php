@extends('layouts.app')

@section('content')

  {{-- Titolo appartamento --}}
  <div class="container">
    <div class="row">
      <div class="col">
        <h1>Sponsirizza l'appartamento {{$apartment->title}}</h1>
      </div>
    </div>
    <div class="row">
      <div class="col">
        {{-- Creo Form e stampo le informazioni per la sponsorizzazione --}}
        @foreach ($sponsors as $sponsor)
          <div class="ms_sponsor">
            <input type="radio" name="price" value="{{$sponsor->id}}">
            <label for="{{$sponsor->id}}">{{$sponsor->offer_name}}:
              sponsorizza per {{$sponsor->hours_duration}} ore - per € {{$sponsor->price}}
            </label>
          </div>
        @endforeach
      </div>
    </div>
  </div>

  {{-- CDN --}}
  <script src="https://js.braintreegateway.com/web/dropin/1.24.0/js/dropin.js"></script>

  {{-- HTML --}}
  <div class="ms_sponsor">
    <div id="dropin-container"></div>
    <button id="submit-button" class="button button--small button--green">Purchase</button>
  </div>


  {{-- MAIN SCRIPT --}}
  <script>
    var button = document.querySelector('#submit-button');

    braintree.dropin.create({
      authorization: 'sandbox_g42y39zw_348pk9cgf3bgyw2b',
      selector: '#dropin-container'
    }, function (err, instance) {
      button.addEventListener('click', function () {
        instance.requestPaymentMethod(function (err, payload) {
          // Submit payload.nonce to your server
          if (err) {
            console.log('Errore');
          }else {

            var idSponsor = $('input:checked').val();
            // Faccio latra chiamata AJAX per passare i dati al controller
            $.ajax({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              url: "/apartment/sponsor",
              method:"POST",
              data: {
                idSponsor: idSponsor,
                idApartment: {{$apartment->id}}
              },
              success:function(response){
                console.log(response.success);
              },
              // Se ci sono errori
              error: function(){
                alert('Si è verificato un errore nei dati');
              }
            });


          }

        });
      })
    });

  </script>
@endsection
