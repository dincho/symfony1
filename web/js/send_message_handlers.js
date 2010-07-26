function send_message_complete(request)
{
    if ( request.status == 200 && $('layout').value == 'window' ) 
    {
        $('msg_container').update(); //remove old errors if any
        parent.$('msg_container').update(request.responseText);
        parent.$("send_message_link_window").remove();
        parent.$('send_message_span').remove();
        parent.$('send_message_link').show();
        
        parent.Windows.close("send_message_window");
        
        return;
    }
    
    $('msg_container').update(request.responseText);
}

function draft_complete(request)
{
    if( $('layout').value == 'window' )
    {
        parent.$("msg_container").update(request.responseText);
        parent.Windows.close("send_message_window");
    } else {
        $("msg_container").update(request.responseText);
    }
}