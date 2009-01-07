function select_all_areas(the_link, iso)
{
    chk = document.getElementById('countries_'+iso).checked;
    if(chk) the_link.href = the_link.href + '/select_all/1';
}