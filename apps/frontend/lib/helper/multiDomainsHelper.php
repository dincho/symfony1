<?php

function url_for_language($new_culture, $url = null)
{
    $context = sfContext::getInstance();
    
    $routing = sfRouting::getInstance();
    
    if( is_null($url)) $url = $routing->getCurrentInternalUri();
    $current_culture = $context->getUser()->getCulture();
    
    $culture_domain = sfConfig::get('app_domains_' . $new_culture);
    $current_culture_domain = sfConfig::get('app_domains_' . $current_culture);
    if( $current_culture_domain != $context->getRequest()->getHost() ) $current_culture_domain = null;
    
    //cross domains sessions, add the session to the URL if redirect is to other domain
    if($culture_domain || $current_culture_domain)
    {
        $url .= (strpos($url, '?')) ? '&' : '?';
        $url .= 'PRSSID=' . session_id();
    }
    
    if($culture_domain) //do not have :sf_culture in routes
    {
        $url = $context->getController()->genUrl($url);
        $url = preg_replace('#/' . $current_culture . '#', '', $url);
        $url = 'http' . ($context->getRequest()->isSecure() ? 's' : '') . '://' . $culture_domain . $url;
    } else { //has :sf_culture in routes
        
        $url = preg_replace('#sf_culture='. $current_culture. '#', 'sf_culture=' . $new_culture, $url);
        
        if($current_culture_domain)
        {
            $url = sfConfig::get('app_base_domain') . '/' . $new_culture . $context->getController()->genUrl($url);
            $url = 'http' . ($context->getRequest()->isSecure() ? 's' : '') . '://' . $url;
        }
    }
    
    return $url;
}

function domain_image_tag($source, $options = array())
{
    $domain = strtolower(sfContext::getInstance()->getRequest()->getHost());
    
    $domain_file = sfConfig::get('sf_web_dir') . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;
    $domain_file .= $domain . DIRECTORY_SEPARATOR . $source;
    if(file_exists($domain_file))
    {
        $source = $domain . '/' . $source;
        
        return image_tag($source, $options);
    
    } else
    {
        return image_tag($source, $options);
    }
}