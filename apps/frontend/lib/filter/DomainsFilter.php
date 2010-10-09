<?php

class DomainsFilter extends sfFilter
{ 
  public function execute ($filterChain)
  {
    $context = $this->getContext();
    $user = $context->getUser();
    $request = $context->getRequest();
    
    $domain_cultures = sfConfig::get('app_domain_cultures');
    
    if( $culture = array_search($request->getHost(), $domain_cultures) )
    {
        $user->setCulture($culture);
    }
    
    $filterChain->execute();
  } 
}

?>
