$(document).ready(function(){

});

$('button').on('click',function(){
  $(".screen").hide();
  $("#loading_screen").show();
  /*
  window.setTimeout(function(){

  },1000);*/


  $.ajax({
    type: "POST",
    url: "php/db.php",
    data: {
      email: $('#email-input').val(),
      timestamp: Date.now()
    }
  })
  .done(function( resp ) {
    $(".screen").hide();
    $("#results_screen").show();
    console.log(resp);
  });

});
