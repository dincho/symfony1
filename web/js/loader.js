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
    
    if( typeof(hide_id) != undefined) document.getElementById(hide_id).style.display = 'none';
}