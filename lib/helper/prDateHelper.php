<?php

function format_date_pr($time = null, $time_format = null, $date_format = null, $timezone = null)
{
    sfLoader::loadHelpers(array('I18N', 'Date'));

    $culture = sfContext::getInstance()->getUser()->getCulture();
    $today = time();
    $yesterday = $today - 86400;

    if( is_null($time) ) $time = $today;
    if( is_null($time_format) ) $time_format = ($culture == 'en') ? ', h:i A' : ', H:i';
    if( is_null($date_format) ) $date_format = 'D';

    $dateTime = new DateTime("@$time");
    if( !is_null($timezone) ) $dateTime->setTimezone(new DateTimeZone($timezone));

    if ( $dateTime->format('dmY') == date('dmY', $today) ) {
      $string = __('Today');
    } elseif ( $dateTime->format('dmY') == date('dmY', $yesterday) ) {
      $string = __('Yesterday');
    } else {
      $string = format_date($dateTime->getTimestamp(), $date_format);
    }

    if( $time_format && $dateTime->format('Y') != date('Y', $today) ) $time_format = ($culture == 'en') ?  ', Y h:i A' : ', Y H:i';

    //add the time
    if($time_format) $string .= $dateTime->format($time_format);

    return $string;
}
