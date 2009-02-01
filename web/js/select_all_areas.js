function select_all_areas(the_link, iso, new_href)
{
    chk = document.getElementById('countries_'+iso).checked;
    if(chk) the_link.href = new_href;
}