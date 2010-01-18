window.onload = init;

function show_hide_other(id)
{
    others_el = $('others_' + id);
    if( others_el )
    {
        others_el.style.display = ( $('others_check_' + id).checked ) ? '' : 'none';
    }
}

function init()
{
    other_ids = [8, 9, 14, 15, 16, 17];
  
    other_ids.each( function(id){
          Event.observe('others_check_' + id, 'click', function(event) { 
              show_hide_other(id);
          });
          
          show_hide_other(id);
    });
}