function select_same_countries(el)
{
  var others = $('countries').getElementsBySelector('input[value="'+ el.value +'"]');
  for ( var i in others )
  {
      others[i].checked = el.checked;
  } 
}