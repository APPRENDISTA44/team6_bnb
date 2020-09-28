$(document).ready(function(){

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

      console.log(encodedInputSearch);
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


          }
        },
        // Se la chiamata fallisce
        error : function(){
          alert('Si è verificato un errore');
        }






      });







    }




  });


});
