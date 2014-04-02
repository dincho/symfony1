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

function loadMessages(ajax) {
    var nav = document.querySelector('#thread_pagination .js-nav');
    var sep = document.querySelector('#thread_pagination .js-separator');
    var fetchLink = document.getElementById("fetch_link");
    var currentOffset = parseInt(fetchLink.getAttribute("data-offset"), 10);
    var currentLimit = parseInt(fetchLink.getAttribute("data-limit"), 10);
    var displayFetchLink = !!ajax.getResponseHeader("displayFetchLink");

    //hide loader and show navigation
    document.querySelector('#thread_pagination .js-loader').style.display = 'none';
    nav.style.display = null;

    //keep offset in sync (why?!)
    fetchLink.setAttribute("data-offset", currentLimit + currentOffset);
    document.forms[0].displayFetchLink.value = +displayFetchLink; //cast to int

    //show "more" link if anything for pagination
    fetchLink.style.display = (displayFetchLink) ? null : 'none';

    //hide separator is "more" link is hidden
    sep.style.display = (displayFetchLink) ? null : 'none';

    //if this function is called => at least on "2nd page" => show reload/refresh link
    document.querySelector('#thread_pagination .js-reload').style.display = null;

    //keep numberOfMessages hidden field in sync, because of re-population on error
    var nomEl = document.getElementById("numberOfMessages");
    var currentMessNum = parseInt(nomEl.value, 10);
    nomEl.value = currentMessNum + parseInt(ajax.getResponseHeader("numberOfMessages"), 10);
}

function showMessageLoading() {
    //show loader and hide nav
    document.querySelector('#thread_pagination .js-nav').style.display = 'none';
    document.querySelector('#thread_pagination .js-loader').style.display = null;
}
