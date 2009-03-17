function add_tags(val, el_id)
{
	el = document.getElementById(el_id);
	if( el.value && el.value.substr(el.value.length - 1, 1) != ",") val = "," + val;
	el.value = el.value + val;
}