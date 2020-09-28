$(document).ready(function(){

  // evento click sul bottone ricerca
  $('#ms_homepage #ms_search_button').on('click', function(){

    //cattura dati indirizzo dal form
    var inputSearch = $('#ms_homepage input').val().trim();
    console.log(inputSearch);


    // // chiamata ajax per recuperare coordinate della search
    // $.ajax({
    //
    //   // controllo campo
    //
    //
    //
    // });
  });
});
