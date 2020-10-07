require('./bootstrap');
var $ = require("Jquery");

$(document).on('click','input[type=radio]',function () {
  $('#ms_payment_container').removeClass('d-none');

});
