<?php
function domain_image_tag($source, $options = array())
{
    $domain = strtolower(sfContext::getInstance()->getRequest()->getHost());

    //strip the port
    if (false !== ($pos = strpos($domain, ':'))) {
        $domain = substr($domain, 0, $pos);
    }

    $domain_file = sfConfig::get('sf_web_dir') . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;
    $domain_file .= $domain . DIRECTORY_SEPARATOR . $source;
    if(file_exists($domain_file)) $source = $domain . '/' . $source;

    return image_tag($source, $options);
}
