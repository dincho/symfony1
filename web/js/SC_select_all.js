function SC_select_all(chk)
{
    for (i = 0; i < chk.length; i++)
    chk[i].checked = true;
}

function SC_select_greather(chk, changed_chk)
{
    if( changed_chk.checked )
    {
	    for (i = 0; i < chk.length; i++)
	    {
	        if(chk[i].value > changed_chk.value) chk[i].checked = true;
	    }
    }
}