<?php

/**
 * sfMessageSource_pdMySQL class file.
 *
 *
 * @author     Dincho Todorov <dincho@xbuv.com>
 * @package    pr
 * @subpackage i18n
 */

class sfMessageSource_pdMySQL extends sfMessageSource_MySQL
{
  
  private $domain;
  
  function __construct($source)
  {
    parent::__construct($source);
    
    $domain = (isset($_SERVER['HTTP_HOST'])) ? strtolower($_SERVER['HTTP_HOST']) : 'localhost';
    
    //strip the port
    if (false !== ($pos = strpos($domain, ':'))) {
        $domain = substr($domain, 0, $pos);
    }

    $catalog_domains = sfConfig::get('app_catalog_domains');
    $this->domain = isset($catalog_domains[$domain]) ? $catalog_domains[$domain] : $domain;
  }
  
  protected function getCatalogueDetails($catalogue = 'messages')
  {
      return parent::getCatalogueDetails($this->domain.'.'.$catalogue);
  }
  
  protected function getCatalogueList($catalogue)
  {
      $catalogs = parent::getCatalogueList($this->domain.'.'.$catalogue);
      
      //remove the culture independent catalogs, since we don't use it
      //performance boost
      array_pop($catalogs);
      
      return $catalogs;
  }
  
  function __destruct()
  {
      //do nothing, the parent closes the mysql connection, but we don't want so.
  }  
}
