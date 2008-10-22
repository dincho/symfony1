function show_hide (id)
{
  s = document.getElementById(id).style;
  s.display = (s.display == 'none') ? '' : 'none';
}