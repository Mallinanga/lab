$(document).ready(function(){
  var count = $('.onlineWidget .count');
  var panel = $('.onlineWidget .onlinepanel');
  var timeout;
  count.load('online.php');
  $('.onlineWidget').hover(
    function(){
      clearTimeout(timeout);
      timeout = setTimeout(function(){panel.trigger('open');},500);
    },
    function(){
      clearTimeout(timeout);
      timeout = setTimeout(function(){panel.trigger('close');},500);
    }
  );
  var loaded=false;
  panel.bind('open',function(){
    panel.slideDown(function(){
      if(!loaded){
        panel.load('geodata.php');
        loaded=true;
      }
    });
  }).bind('close',function(){
    panel.slideUp();
  });
});
