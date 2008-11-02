function msg_select(chk, is_checked, read_unread)
{
    for (i = 0; i < chk.length; i++)
    {
        if( typeof(read_unread) != 'undefined' )
        {
            chk[i].checked = false; //clear all fields first
            if( chk[i].getAttribute('read') == read_unread ) 
            {
                chk[i].checked = is_checked;
            }
        } else {
            chk[i].checked = is_checked;
        }
    }
}
