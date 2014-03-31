jQuery.noConflict();

function clearMessages() {
    if ($('msg_container')) {
        $('msg_container').innerHTML = '';
    }
}

// add message in static container
function addMessage(message, divClass) {
    divClass = divClass === undefined ? 'msg' : divClass;

    var $msgContainer = $('msg_container');
    var $msgs = $('msgs');

    if (!$msgContainer) {
        return;
    }

    if (!$msgs) {
        $msgs = $(document.createElement('div'));
        $msgs.setAttribute('id', 'msgs');
        $msgContainer.appendChild($msgs);
    }

    message = '<div class="' + divClass + '">' + message + '</div>';
    message = $msgs.innerHTML + message;

    $msgs.innerHTML = message;
}

function moveElement(draggable, droparea, event)
{
    var draggable_parent = draggable.parentNode;
    if( draggable_parent ===  droparea ) return; //dropped in the same parent
    
    clearMessages();
    
    draggable_parent.removeChild(draggable);
    var droparea_photo = $(droparea).down('.photo');
    
    if( droparea_photo ) //exchange elements position
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
    reorder_photo_block(droparea.parentNode);
    if(draggable_parent.parentNode !== droparea.parentNode)  reorder_photo_block(draggable_parent.parentNode);
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
   
   //reorder/fill-in empty containers
   for(var i=0; i<cnt; i++)
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
   var SERIALIZE_RULE = /^[^_\-](?:[A-Za-z0-9\-_]*)[_](.*)$/;
   
   var ajax_params = $(block).getElementsBySelector('.photo_container .photo').map( function(item) {
            var match = item.id.match(SERIALIZE_RULE);
            if( match ) return "photos[]=" + match[1];
        });
    ajax_params.unshift('block_id=' + encodeURIComponent(block.id));
    ajax_params = ajax_params.join('&');
   
   new Ajax.Request(photo_handler_url, {asynchronous:true, evalScripts:false, parameters:ajax_params});
}


function initFileUploads(block_id, errors) {
    (function ($) {
        var $block = $('#' + block_id);

        $('#btn_upload_' + block_id).fileupload({
            dataType: 'json',
            dropZone: $block,
            sequentialUploads: true,
            change: function () {
                clearMessages();
            },
            add: function (e, data) {
                if (data.files[0].size > 3145728) {
                    addMessage(errors.maxSizeErrorMsg + ' (' + data.files[0].name + ') ', 'msg_error');
                    return;
                }
                if (!/(\.|\/)(gif|jpe?g|png)$/i.test(data.files[0].name)) {
                    addMessage(errors.typeErrorMsg + ' (' + data.files[0].name + ') ', 'msg_error');
                    return;
                }

                var container = $('.photo_container:not(:has(.photo)):not(:has(img))', $block)[0];
                $(container).html('<img src="/images/ajax-loader-bg-3D3D3D.gif"' +
                    ' data-name="' + data.files[0].name + '"/>');
                data.submit();
            },
            fail: function (e, data) {
                var container = $('.photo_container:has(img[data-name="' +
                    data.files[0].name + '"])', $block)[0];
                $(container).html(''); //clear the container ( loader image )
                addMessage(errors.generalErrorMsg + ' (' + data.files[0].name + ') ', 'msg_error');
            },
            done: function (e, data) {
                var response = data.result;
                var container = $('.photo_container:has(img[data-name="' +
                    data.files[0].name + '"])', $block)[0];

                if (response.status === "success") {
                    $(container).html(response.data);
                    var photo = $(".photo", container);
                    photo.hide().fadeIn(1000);
                } else {
                    $(container).html(''); //clear the container ( loader image )
                    addMessage(data.result.error + ' (' + data.files[0].name + ') ', 'msg_error');
                }
            }
        });
    })(jQuery);
}
