$(document).ready(function(){

  // variabili per chiamata ajax
  var countryCode = "IT";
  var api_key = "GtzDpsAXELltupPjSlfBcqWR2zqzfjKy";
  var url = "https://api.tomtom.com/search/2/search/";
  var format = ".json";

  //evento click per la creazione di coordinate
  $('#ms_form_create #ms_coordinate_generator').on('click',function(){

    //cattura dati indirizzo dal form
    var address = $('#ms_form_create .ms_address input').val().trim();
    var city = $('#ms_form_create .ms_city input').val().trim();
    var cap = $('#ms_form_create .ms_cap input').val();
    var province = $('#ms_form_create .ms_province input').val().trim();

    if ( (address !== "") && (city !== "")
      && (cap !== "") && (province.length === 2)) {
        console.log('ok');
        console.log(address);


    }else {
      console.log('nope');
    }















    // var fullAddress = address + " " + city + " " + cap + " " + province;
    // var encodedFullAddress = spaceInPercentage(fullAddress);
    // //chiamata ajax
    // $.ajax({
    //   url: url + encodedFullAddress + format,
    //   method: "GET",
    //   data : {
    //     "countrySet" : countryCode,
    //     "key" : api_key
    //   },
    //   success : function(data){
    //
    //     //inseriamo i dati di latitudine e longitudine recuperati nel form
    //     $('#ms_form_create .ms_coordinates .ms_longitude').val(data.results[0].position.lon);
    //     $('#ms_form_create .ms_coordinates .ms_latitude').val(data.results[0].position.lat);
    //   },
    //   error : function(){
    //     alert('errore');
    //   }
    // });

    //funzione per codificare i dati per URI
    //PARAMETRO: stringa
    //RETURN: stringa codificata
    function spaceInPercentage(string) {
      return encodeURI(string);

    }
  });


});
