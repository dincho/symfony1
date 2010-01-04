<?php
function pr_link_to($name = '', $internal_uri = '', $options = array())
{
    $current_uri = sfRouting::getInstance()->getCurrentInternalUri();
    return link_to_unless( ereg($internal_uri, $current_uri) , $name, $internal_uri, $options);
}

function link_to_ref($name = '', $internal_uri = '', $options = array())
{
  $ref = array('query_string' => 'return_url=' . base64_encode(remove_return_url(sfRouting::getInstance()->getCurrentInternalUri())));
  $options = array_merge($options, $ref);
  return link_to($name, $internal_uri, $options);
}

function link_to_if_ref($condition, $name = '', $internal_uri = '', $options = array())
{
  $ref = array('query_string' => 'return_url=' . base64_encode(remove_return_url(sfRouting::getInstance()->getCurrentInternalUri())));
  $options = array_merge($options, $ref);
  return link_to_if($condition, $name, $internal_uri, $options);
}

function link_to_unless_ref($condition, $name = '', $url = '', $options = array())
{
  return link_to_if_ref(!$condition, $name, $url, $options);
}

function remove_return_url($url)
{
  $url = preg_replace('/(return_url=\w+=&)/i', '', $url);
  return $url;
}
