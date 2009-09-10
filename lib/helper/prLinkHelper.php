<?php
function pr_link_to($name = '', $internal_uri = '', $options = array())
{
    $current_uri = sfRouting::getInstance()->getCurrentInternalUri();
    return link_to_unless( ereg($internal_uri, $current_uri) , $name, $internal_uri, $options);
}

function link_to_ref($name = '', $internal_uri = '', $options = array())
{
  $ref = array('query_string' => 'return_url=' . urlencode(sfRouting::getInstance()->getCurrentInternalUri()));
  $options = array_merge($options, $ref);
  return link_to($name, $internal_uri, $options);
}
?>