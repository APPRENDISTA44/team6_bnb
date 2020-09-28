$(document).ready(function(){
  // variabili per chiamata ajax
  var countryCode = "IT";
  var api_key = "GtzDpsAXELltupPjSlfBcqWR2zqzfjKy";
  var url = "https://api.tomtom.com/search/2/search/";
  var format = ".json";

  // Messaggio di Errore
  var errorMessage = 'I campi sono sbagliati';

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


      //
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
        },
        // Se la chiamata fallisce
        error : function(){
          alert('Si è verificato un errore nella chiamata principale');
        }






      });







    }




  });


});
