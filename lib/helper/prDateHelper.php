<?php
function format_date_pr($time = null, $time_format = null, $date_format = 'dd MMMM')
{
    use_helper('Date');
    use_helper('I18N');
        
    $culture = sfContext::getInstance()->getUser()->getCulture();
    $today = time();
    $yesterday = $today - 86400;
        
    if( is_null($time_format) ) $time_format = ($culture == 'en') ? ', hh:mm a' : ', HH:mm';
    if( is_null($time) ) $time = $today;

    if( date('d', $time) == date('d', $today) && date('m', $time) == date('m', $today) && date('Y', $time) == date('Y', $today) )
    {
      $string = __('Today');
    } elseif ( date('d', $time) == date('d', $yesterday) && date('m', $time) == date('m', $yesterday) && date('Y', $time) == date('Y', $yesterday) )
    {
      $string = __('Yesterday');
    } else {
      $string = format_date($time, $date_format);
    }

    if( date('Y', $time) != date('Y') ) $time_format = ($culture == 'en') ?  ', yyyy hh:mm a' : ', yyyy HH:mm';

    //add the time
    $string .= format_date($time, $time_format);

    return $string;
}
