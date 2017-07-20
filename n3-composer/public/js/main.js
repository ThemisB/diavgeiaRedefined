$(function() {
  function isNumber(e) {
    e = e ? e : window.event;
    var charCode = (e.which) ? e.which : e.keyCode;
    if ((charCode > 31 && charCode < 48) || charCode > 57)
      return false;
    return true;
  }
  $("#government_institution_postalcode").on("keypress", function(e){
    return isNumber(e);
  });

});