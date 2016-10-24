$(document).ready(function(){

});

$('button').on('click',function(){
  $(".screen").hide();
  $("#loading_screen").show();
  window.setTimeout(function(){
    $(".screen").hide();
    $("#results_screen").show();
  },1000);

});
