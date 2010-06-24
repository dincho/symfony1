loader_img = new Image();
loader_img.src = '/images/loading.gif';
loader_img.alt = 'Updating Results...';
loader_img.id = 'loader';
    
function show_loader(hide_id)
{
    //currently using only this container
    // so hardcode it!
    hide_id = 'match_results';
    
    if (document.getElementById('loader') != null) return;
    
	loader_span = document.createElement('span');
	loader_span.className = 'loading';
	loader_br = document.createElement('br');
	loader_text = document.createTextNode('Updating Results...');
    
    loader_span.appendChild(loader_img);
    loader_span.appendChild(loader_br);
    loader_span.appendChild(loader_text);
    
    container = document.getElementById('secondary_container');
    container.appendChild(loader_span);
    

    if( typeof(hide_id) != undefined) 
    {
      hide = document.getElementById(hide_id);
      if( hide ) hide.style.display = 'none';
    }
}

function show_load()
{
  document.getElementById('match_results').style.display = 'none';
  document.getElementById('loading').style.display = 'block';  
}

function hide_load()
{
  document.getElementById('match_results').style.display = 'block';
  document.getElementById('loading').style.display = 'none';  
}