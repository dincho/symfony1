<?php

class DomainsFilter extends sfFilter
{ 
  public function execute ($filterChain)
  {
    $context = $this->getContext();
    $user = $context->getUser();
    $request = $context->getRequest();
    
    $domains_config = sfYaml::load(sfConfig::get('sf_config_dir') . DIRECTORY_SEPARATOR . 'app.yml');
    $domains_culture = $domains_config[SF_ENVIRONMENT]['domains'];
    
    if( $culture = array_search($request->getHost(), $domains_culture) )
    {
    	$user->setCulture($culture);
    }
    
    $filterChain->execute();
  } 
}

?>
