window.onload = init;

function show_hide_other()
{
  $('others_16').style.display = ( $('others_check_16').checked ) ? '' : 'none';
}

function init()
{
  Event.observe('others_check_16', 'click', show_hide_other );
  show_hide_other();
}