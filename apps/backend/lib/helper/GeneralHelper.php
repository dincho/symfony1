<?php
function block_netmask_tag($name, $selected = '', $options=array())
{
        return select_tag($name, options_for_select(
    array(
        32 => '32' ,
            24 => '24',
        16 => '16',
        8 => '8'
        ),
        $selected,
    $options));

}

function block_item_type($name, $selected = '', $options=array())
{
        return select_tag($name, options_for_select(
    array(
        0 => 'Domain' ,
        1 => 'Email',
        2 => 'Single IP',
        3 => 'IP Range'
        ),
        $selected,
    $options));

}
