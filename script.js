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
    response = JSON.parse(resp);
    if(response.status==="Success"){
      var now = Date.now();
      var diff = now - response.timestamp;
      var days = Math.floor(diff / 1000 / 60 / 60 / 24);
      $("#score").text(days);
      $(".screen").hide();
      $("#success_screen").show();
    }else if(response.status==="Not Found"){
      //show not found message
      $(".screen").hide();
      $("#notfound_screen").show();
    } else if(response.status==="Error"){
      //show Error
      $(".screen").hide();
      $("#error_screen").show();
    }
  });

});
