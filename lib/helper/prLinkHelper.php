<?php
function pr_link_to($name = '', $internal_uri = '', $options = array())
{
    
    $current_uri = sfRouting::getInstance()->getCurrentInternalUri();
    return link_to_unless( ereg($internal_uri, $current_uri) , $name, $internal_uri, $options);
}

?>