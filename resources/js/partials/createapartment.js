$(document).ready(function(){

  var errorMessage = 'I campi sono sbagliati';

  //evento click per la creazione di coordinate
  $('#ms_form_create #ms_coordinate_generator').on('click',function(){
    $("#ms_form_create .ms_error").addClass('d-none').text(errorMessage);

    //cattura dati indirizzo dal form
    var address = $('#ms_form_create .ms_address input').val().trim();
    var city = $('#ms_form_create .ms_city input').val().trim();
    var cap = $('#ms_form_create .ms_cap input').val();
    var province = $('#ms_form_create .ms_province input').val().trim();

    //controllo campi
    if ( (address !== "") && (city !== "")
      && (cap !== "") && (province.length === 2) && (cap.length === 5)) {

        //concateno e codifico le variabili in URI
        var fullAddress = address + " " + city + " " + cap + " " + province;
        var encodedFullAddress = spaceInPercentage(fullAddress);

        //chiamata ajax
        $.ajax({
          url: url + encodedFullAddress + format,
          method: "GET",
          data : {
            "countrySet" : countryCode,
            "key" : api_key
          },
          success : function(data){

            if (data.results.length === 0) {
              errorMessage = "Alcuni campi sono scorretti per coordinate";
              $("#ms_form_create .ms_error").removeClass('d-none').text(errorMessage);
            }else {
              //inseriamo i dati di latitudine e longitudine recuperati nel form
              $('#ms_form_create .ms_coordinates .ms_longitude').val(data.results[0].position.lon);
              $('#ms_form_create .ms_coordinates .ms_latitude').val(data.results[0].position.lat);
            }
          },
          error : function(){
            alert('errore');
          }
        });


    }else {
      $("#ms_form_create .ms_error").removeClass('d-none');
    }

    //funzione per codificare i dati per URI
    //PARAMETRO: stringa
    //RETURN: stringa codificata
    function spaceInPercentage(string) {
      return encodeURI(string);

    }
  });

});
