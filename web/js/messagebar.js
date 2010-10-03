function messagebar_message(message)
{
  id = 'messageBar';
  var obj = document.getElementById(id);
  if(obj)
  {
    obj.innerHTML = obj.innerHTML + '|&nbsp;&nbsp;&nbsp;'+ message+ '&nbsp;&nbsp;&nbsp;'
  }
  else
  {
    var newdiv = document.createElement('div');
     newdiv.setAttribute('id', id);
     newdiv.innerHTML = '&nbsp;&nbsp;&nbsp;'+ message+ '&nbsp;&nbsp;&nbsp;';
     
     document.body.appendChild(newdiv);
   }
}

Event.observe(window, 'unload', function()
{
  $('messageBar').hide();
});
