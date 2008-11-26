function msg_select(chk, is_checked, read_unread)
{
    if( chk.length != undefined )
    {    
	    for (i = 0; i < chk.length; i++)
	    {
	        msg_select_item(chk[i], is_checked, read_unread);
	    }
    } else {
        msg_select_item(chk, is_checked, read_unread);
    }
}

function msg_select_item(oItem, is_checked, read_unread)
{
	if( read_unread != undefined )
	{
	    oItem.checked = false; //clear all fields first
	    if( oItem.getAttribute('read') == read_unread ) 
	    {
	        oItem.checked = is_checked;
	    }
	} else {
	    oItem.checked = is_checked;
	}
}
