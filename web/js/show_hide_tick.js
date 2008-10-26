function show_hide_tick (id)
{
  s = document.getElementById(id).style;
  tick_id = id + "_tick";
  t = document.getElementById(tick_id); 
  
  if( s.display == 'none' )
  {
    s.display = '';
    t.innerHTML = '-';
  } else {
    s.display = 'none';
    t.innerHTML = '+';
  }
}