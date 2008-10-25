<?php
function boolColor($value, $bool = false)
{
	$class = ( $bool ) ? 'true_value' : 'false_value';
	
	return content_tag('span', $value, array('class' => $class));
}

function boolValue($value, $true_value = 'yes', $false_value = 'no')
{
	$_val = ( $value ) ? $true_value : $false_value;
	return boolColor($_val, $value);
}
