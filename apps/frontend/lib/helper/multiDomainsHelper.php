<?php
function domain_image_tag($source, $options = array())
{
    $domain = strtolower(sfContext::getInstance()->getRequest()->getHost());
    
    $domain_file = sfConfig::get('sf_web_dir') . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;
    $domain_file .= $domain . DIRECTORY_SEPARATOR . $source;
    if(file_exists($domain_file)) $source = $domain . '/' . $source;

    return image_tag($source, $options);
}