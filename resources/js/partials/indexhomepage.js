$(document).ready(function(){
  var Handlebars = require("handlebars");
  // variabili per chiamata ajax
  var countryCode = "IT";
  var api_key = "GtzDpsAXELltupPjSlfBcqWR2zqzfjKy";
  var url = "https://api.tomtom.com/search/2/search/";
  var format = ".json";

  // Messaggio di Errore
  var errorMessage = 'I campi sono sbagliati';

  // setto valori di default degli Slider
    $('#formControlRangeRooms').val('1');
    $('#formControlRangeBeds').val('1');
    $('#formControlRangeKm').val('20');

    //creo variabili per la ricerca
    var rangeRooms = $('#formControlRangeRooms').val();
    var rangeBeds = $('#formControlRangeBeds').val();
    var rangeKm = $('#formControlRangeKm').val();


  // evento click sul bottone ricerca
  $('#ms_homepage #ms_search_button').on('click', function(){

    //cattura dati indirizzo dal form
    var inputSearch = $('#ms_homepage input').val().trim();

    // // chiamata ajax per recuperare coordinate della search

    // Controllo validazione campi
    // Se
    if ((inputSearch == "") ||  (inputSearch.length < 2) ) {

      console.log('Errore');

    } else {

      // Se tutti controlli sono superati, faccio la chiamata AJAX
      var encodedInputSearch = encodeURI(inputSearch);


      //Chiamata ajax per ottenere coordinate da indirizzo
      //scritto dall'utente
      $.ajax({

        url: url + encodedInputSearch + format,
        method: "GET",
        data: {
          "countrySet" : countryCode,
          "key" : api_key
        },

        // Se la chiamata ha successo
        success : function(data){

          if (data.results.length === 0) {
            errorMessage = "La ricerca non ha prodotto risultati";
            alert(errorMessage)
          }else {

           var coordinates = data.results[0].position;
           console.log(coordinates);

           // Faccio latra chiamata AJAX per passare i dati al controller
            sentDataToIndex(coordinates,rangeRooms,rangeBeds,rangeKm);
          }
        },
        // Se la chiamata fallisce
        error : function(){
          alert('Si è verificato un errore nella chiamata principale');
        }

      });


    }

  });
  // fine evento click sul search




  //eventi di modifica dati appartamenti

  $('#formControlRangeRooms').click(function() {
    rangeRooms = $('#formControlRangeRooms').val();
    $('.ms_range_rooms').text( rangeRooms );
    // Faccio latra chiamata AJAX per passare i dati al controller
     sentDataToIndex(coordinates,rangeRooms,rangeBeds,rangeKm);


  });

  $('#formControlRangeBeds').click(function() {
    rangeBeds = $('#formControlRangeBeds').val();
    $('.ms_range_beds').text( rangeBeds );
    // Faccio latra chiamata AJAX per passare i dati al controller
     sentDataToIndex(coordinates,rangeRooms,rangeBeds,rangeKm);
  });

  $('#formControlRangeKm').click(function() {
    rangeKm = $('#formControlRangeKm').val();
    $('.ms_range_km').text( rangeKm );
    // Faccio latra chiamata AJAX per passare i dati al controller
     sentDataToIndex(coordinates,rangeRooms,rangeBeds,rangeKm);

  });


  //evento click su checkbox
  //aggiungiamo classe ms_checked se selezionato
  $(".ms_checkbox").click(function() {
    $(this).toggleClass('ms_checked');
});

  //funzione per chiamata ajax che ritorna json
function sentDataToIndex(coordinates,rangeRooms,rangeBeds,rangeKm) {
  // Faccio latra chiamata AJAX per passare i dati al controller
  $.ajax({
    // csfr token per chiamata ajax
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: "/home",
    method:"POST",
    data: {
      latitude: coordinates.lat,
      longitude: coordinates.lon,
      distance: rangeKm,
      rangeRooms: rangeRooms,
      rangeBeds: rangeBeds,
      rangeKm: rangeKm
    },

    // Se la chiamata ha successo

    success:function(response){
     console.log(response);
   },

   // Se ci sono errori
   error: function(){
     alert('Si è verificato un errore nei dati');
   }

  });
}


});
