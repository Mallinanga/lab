$(document).ready(function(){
  $(".todoList").sortable({
    axis: 'y',
    containment: 'window',
    update: function(){
      var arr = $(".todoList").sortable('toArray');
      arr = $.map(arr,function(val,key){
        return val.replace('todo-','');
      });
      $.get('ajax.php',{action:'rearrange',positions:arr});
    },
    stop: function(e,ui){
      ui.item.css({'top':'0','left':'0'});
    }
  });
  var currentTODO;
  $("#dialog-confirm").dialog({
    resizable: false,
    height: 130,
    modal: true,
    autoOpen: false,
    buttons: {
      'Yes': function(){
        $.get("ajax.php",{"action":"delete","id":currentTODO.data('id')},function(msg){
          currentTODO.fadeOut('fast');
        })
        $(this).dialog('close');
      },
      'No': function(){
        $(this).dialog('close');
      }
    }
  });
  $('.todo').live('dblclick',function(){
    $(this).find('a.edit').click();
  });
  $('.todo a').live('click',function(e){
    currentTODO = $(this).closest('.todo');
    currentTODO.data('id',currentTODO.attr('id').replace('todo-',''));
    e.preventDefault();
  });
  $('.todo a.delete').live('click',function(){
    $("#dialog-confirm").dialog('open');
  });
  $('.todo a.edit').live('click',function(){
    var container = currentTODO.find('.text');
    if(!currentTODO.data('origText')){
      currentTODO.data('origText',container.text());
    } else {
      return false;
    }
    $('<input type="text">').val(container.text()).appendTo(container.empty());
    container.append(
      '<div class="editTodo">'+
        '<a class="saveChanges" href="#">Save</a>, <a class="discardChanges" href="#">Cancel</a>'+
      '</div>'
    );
  });
  $('.todo a.discardChanges').live('click',function(){
    currentTODO.find('.text')
    .text(currentTODO.data('origText'))
    .end()
    .removeData('origText');
  });
  $('.todo a.saveChanges').live('click',function(){
    var text = currentTODO.find("input[type=text]").val();
    $.get("ajax.php",{'action':'edit','id':currentTODO.data('id'),'text':text});
    currentTODO.removeData('origText')
    .find(".text")
    .text(text);
  });
  var timestamp=0;
  $('#addButton').click(function(e){
    if((new Date()).getTime() - timestamp<5000) return false;
    $.get("ajax.php",{'action':'new','text':'Double Click Me','rand':Math.random()},function(msg){
      $(msg).hide().appendTo('.todoList').fadeIn();
    });
    timestamp = (new Date()).getTime();
    e.preventDefault();
  });
});
