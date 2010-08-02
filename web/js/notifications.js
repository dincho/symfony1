function parse_notifications(request, notification_lifetime)
{

  var json = eval('(' + request.responseText + ')');
  var nbElementsInResponse = (json) ? json.length : 0;
  var delay = 0;
  
  for (var i = 0; i <= nbElementsInResponse; i++)
  {
    if(json[i]) show_notification(json[i], notification_lifetime);
  }
}

function show_notification(note, lifetime)
{

    if( typeof(note.title) != 'string' ) return; //don't show empty notifications
    
    var notes = $$('.notification');
    var last_note = notes[notes.length-1];
    
    var padding = 20;
    var theBox = document.createElement('div');
    
    if( last_note )
    {
      theBox.style.bottom = ( parseInt(last_note.style.height, 10) + parseInt(last_note.style.bottom, 10) + padding ) + 'px';
    } else {
      theBox.style.bottom = padding + 'px';
    }
    
    theBox.style.height = '70px';
    theBox.style.display = "none";
    theBox.className = "notification";
    
    var close_link = document.createElement('a');
    close_link.appendChild(document.createTextNode('x'));
    close_link.className = "close_link sec_link";

    var br = document.createElement('br');
    br.setAttribute('class', 'clear');

    var h3 = document.createElement('h3');
    h3.innerHTML = note.title;
    
    var theBody = document.createElement('p');
    theBody.innerHTML = note.body;
   
    Event.observe(close_link, 'click', function(event) {
      theBox.remove();
    });
    
    theBox.appendChild(close_link);
    theBox.appendChild(br);
    theBox.appendChild(h3);
    theBox.appendChild(theBody);    
    document.body.appendChild(theBox);
    
    new Effect.Appear(theBox, { duration: 2.0 });
    setTimeout(function () { 
                new Effect.Fade(theBox, { duration: 1.0 }); 
                setTimeout(function() { theBox.remove(); }, 1200);
                }, lifetime);
}