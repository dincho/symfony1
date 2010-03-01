<?php
use_helper('Number');

$prices = array(1,2,3,5,8,13,18,25,33,44,55,78,99);
$options = array();

$culture = sfConfig::get('app_settings_currency_' . $sf_user->getCulture(), 'GBP');

foreach($prices as $price)
    if( $price >= $min_price ) $options[$price] = format_currency($price, $culture);

echo select_tag($name, $options); ?>