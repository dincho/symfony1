var revert = true;

function moveElement(draggable, droparea, event)
{
    draggable_parent = draggable.parentNode;
    if( draggable_parent ===  droparea ) return; //droped in the same parent

    
    //validation - at least one public photo
    if( draggable_parent.parentNode.id == "public_photos" && 
        droparea.parentNode.id == "private_photos" && 
        draggable_parent.parentNode.getElementsBySelector('.photo').length == 1 )
    {
        
        new Ajax.Updater('msg_container', move_photo_error_url, {asynchronous:true, evalScripts:true});
        return;
    }
    
    revert = false; //turn off revert effect, if everething goes OK

    //hide msg contianer ( old errors )
    new Effect.Fade('msg_container', { duration: 0.3,
      queue: {scope:'_draggable', position:'end'}
    });
    
    setTimeout( function() { $('msg_container').update(); $('msg_container').show(); }, 350);
    
    draggable_parent.removeChild(draggable);
    droparea_photo = $(droparea).down('.photo');
    
    if( droparea_photo ) //exchange elements possition
    {
        droparea.removeChild(droparea_photo);
        draggable_parent.appendChild(droparea_photo);
    }
    
    // droparea.innerHTML = '';
    droparea.appendChild(draggable);
    
    //relative to the new parent
    draggable.style.left = "0px";
    draggable.style.top = "0px";
    
    //re-order/fill empty containers to the right
    if(draggable_parent.parentNode !== droparea.parentNode)  reorder_photo_block(draggable_parent.parentNode);
    reorder_photo_block(droparea.parentNode);
}

function revertEffect (element, top_offset, left_offset) {
    // var dur = Math.sqrt(Math.abs(top_offset^2)+Math.abs(left_offset^2))*0.02;
    // // new Effect.Move(element, { x: -top_offset, y: -left_offset, duration: dur,
    // //   queue: {scope:'_draggable', position:'end'}
    // // });
    
    var ret = revert;
    revert = true;
    return ret;
}

function delete_photo(id)
{
    var photo = $('photo_' + id);
    
    new Effect.Fade(photo, { duration: 0.5,
      queue: {scope:'_draggable', position:'end'}
    });
                    
    var photo_block = photo.parentNode.parentNode;
    
    setTimeout( function() { photo.remove(); reorder_photo_block(photo_block); }, 510);
}

function reorder_photo_block(block)
{
   var containers = $(block).getElementsBySelector('.photo_container');
   var cnt = containers.length;
   
   //re-order/fillin empty containers
   for(i=0; i<cnt; i++)
   {
       var photo = containers[i].down('.photo');
       if( photo !== undefined ) continue;
       
       for(j=i+1; j<cnt; j++)
       {
           var next_photo = containers[j].down('.photo');
           if( next_photo !== undefined )
           {
               next_photo.parentNode.removeChild(next_photo);
               containers[i].appendChild(next_photo);
           
               break;
           }
       } //end for ( siblings )
   }
   
   //let the server know
   var SERIALIZE_RULE = /^[^_\-](?:[A-Za-z0-9\-\_]*)[_](.*)$/;
   
   var ajax_params = $(block).getElementsBySelector('.photo_container .photo').map( function(item) {
            var match = item.id.match(SERIALIZE_RULE);
            if( match ) return "photos[]=" + match[1];
        });
    ajax_params.unshift('block_id=' + encodeURIComponent(block.id));
    ajax_params = ajax_params.join('&');
   
   new Ajax.Request(photo_handler_url, {asynchronous:true, evalScripts:false, parameters:ajax_params});
}

function get_empty_photo_container(block)
{
   var containers = $(block).getElementsBySelector('.photo_container');
   var cnt = containers.length;
   
   for(i=0; i<cnt; i++)
   {
       var photo = containers[i].down('.photo');
       if( photo === undefined ) return containers[i];
   }
   
   return null;
}