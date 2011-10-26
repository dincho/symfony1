function messagebar_message(message, to_append)
{
  if (typeof to_append === "undefined") {
    to_append = false;
  }

  id = 'messageBar';
  var obj = document.getElementById(id);
  if(obj)
  {
    if(to_append)
      obj.innerHTML = obj.innerHTML + '|&nbsp;&nbsp;&nbsp;'+ message+ '&nbsp;&nbsp;&nbsp;'
    else
      obj.innerHTML = '&nbsp;&nbsp;&nbsp;'+ message+ '&nbsp;&nbsp;&nbsp;'
  }
  else
  {
    var newdiv = document.createElement('div');
     newdiv.setAttribute('id', id);
     newdiv.innerHTML = '&nbsp;&nbsp;&nbsp;'+ message+ '&nbsp;&nbsp;&nbsp;';
     
     document.body.appendChild(newdiv);
   }
   $(id).show();

}

Event.observe(window, 'unload', function()
{
  var obj = $('messageBar');
  if(obj)
  {
    obj.hide();
  }
});
