<?php
function format_date_pr($time = null, $time_format = ', hh:mm', $date_format = 'm')
{
  if( !$time ) $time = time();
  
  $today = time();
  $yesterday = $today - 86400;
  
  use_helper('Date');
  use_helper('I18N');
  
  if( date('d', $time) == date('d', $today) && date('m', $time) == date('m', $today) && date('Y', $time) == date('Y', $today) )
  {
      $string = __('Today');
  } elseif ( date('d', $time) == date('d', $yesterday) && date('m', $time) == date('m', $yesterday) && date('Y', $time) == date('Y', $yesterday) )
  {
      $string = __('Yesterday');
  } else {
      $string = format_date($time, $date_format);
  }
  
  if( date('Y', $time) != date('Y') ) $time_format = ', yyyy hh:mm';

  $string .= format_date($time, $time_format);
  
  return $string;
}
