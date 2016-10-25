$(document).ready(function(){

});

$('#email-btn').on('click',function(){
  $(".screen").hide();
  $("#loading_screen").show();
  $.ajax({
    type: "POST",
    url: "php/checkEmail.php",
    data: {
      email: $('#email-input').val(),
      timestamp: Date.now()
    }
  })
  .done(function( resp ) {
    response = JSON.parse(resp);
    console.log(response);
    if(response.status==="Success"){
      //an email has been sent.
      //show verification page.
      $(".screen").hide();
      $("#verification_screen").show();
    }else if(response.status==="Error"){
      if(response.message === "The email was not found."){
        //show not found message
        $(".screen").hide();
        $("#notfound_screen").show();
      }else{
        //show Error
        $(".screen").hide();
        $("#error_screen").show();
      }
    }else{
      //show Error anyway
      $(".screen").hide();
      $("#error_screen").show();
    }
  });
});

$('#code-btn').on('click',function(){
  $(".screen").hide();
  $("#loading_screen").show();
  $.ajax({
    type: "POST",
    url: "php/verifyCode.php",
    data: {
      email: $('#email-input').val(),
      timestamp: Date.now(),
      code: $('#code-input').val()
    }
  })
  .done(function( resp ) {
    response = JSON.parse(resp);
    console.log(response);
    if(response.status==="Success"){
      //code verified
      //show success and score
      var now = Date.now();
      var diff = now - response.timestamp;
      var days = Math.floor(diff / 1000 / 60 / 60 / 24);
      $("#score").text(days);
      $(".screen").hide();
      $("#success_screen").show();

    }else if(response.status==="Error"){
      if(response.message === "Code not verified."){
        //show not found message
        $(".screen").hide();
        $("#notverified_screen").show();
      }else{
        //show Error
        $(".screen").hide();
        $("#error_screen").show();
      }
    }else{
      //show Error anyway
      $(".screen").hide();
      $("#error_screen").show();
    }
  });
});
