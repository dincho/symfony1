function flag_request_complete(request)
{
    if ( request.status == 200 && $('layout').value == 'window' ) 
    {
        $('msg_container').update(); //remove old errors if any
        parent.$('msg_container').update(request.responseText);
        parent.Windows.close("flag_profile_window");
        
        return;
    }
    
    $('msg_container').update(request.responseText);
}   