@extends('layouts.app')

@section('content')

  {{-- se è scaduta o non è mai esistita la sponsorizzazione --}}
  @if ($date_of_expire === 0)

    {{-- Titolo appartamento --}}
    <div class="container">
      <h1 class="mt-4 mb-3">Sponsirizza l'appartamento {{$apartment->title}}</h1>
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

      <div class="row">
        <div class="col">

          {{-- HTML --}}
          <div class="ms_sponsor d-none" id="ms_payment_container">
            <div id="dropin-container"></div>
            <button id="submit-button" class="btn btn-success">Sponsorizza ora</button>
          </div>

        </div>

      </div>
    </div>

    {{-- CDN --}}
    <script src="https://js.braintreegateway.com/web/dropin/1.24.0/js/dropin.js"></script>

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

    @else
      <div class="container-fluid d-flex justify-content-center align-items-center flex-column" id="ms_landscape_sponsor">
        <div class="ms_container_deadline d-flex justify-content-center align-items-center flex-column">
          <h2>Hai già una sponsorizzazione attiva</h2>
          <h3>Torna il {{$date_of_expire_data}} alle {{$date_of_expire_hour}}</h3>
        </div>
        <a class="ms_links mt-5" href="{{route('admin.apartment.list', Auth::user())}}">Torna ai tuoi appartamenti</a>


      </div>


  @endif


@endsection
