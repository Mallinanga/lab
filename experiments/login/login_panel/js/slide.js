$(document).ready(function(){
  $("#open").click(function(){
    $("div#panel").slideDown("slow");
  });
  $("#close").click(function(){
    $("div#panel").slideUp("slow");
  });
  $("#toggle a").click(function(){
    $("#toggle a").toggle();
  });
});
