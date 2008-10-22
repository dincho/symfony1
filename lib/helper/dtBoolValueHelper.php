<?php
function boolColor($value, $bool = false)
{
	$class = ( $bool ) ? 'true_value' : 'false_value';
	
	return content_tag('span', $value, array('class' => $class));
}

function boolValue($value)
{
	$_val = ( $value ) ? 'yes' : 'no';
	return boolColor($_val, $value);
}
