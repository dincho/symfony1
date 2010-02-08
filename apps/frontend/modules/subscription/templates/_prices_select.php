<?php
use_helper('Number');

$prices = array(1,2,3,5,8,13,18,25);
$options = array();

foreach($prices as $price)
    if( $price >= $min_price ) $options[$price] = format_currency($price, 'GBP');

echo select_tag($name, $options); ?>