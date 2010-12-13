<?php

class DomainsFilter extends sfFilter
{ 
  public function execute ($filterChain)
  {
    $context = $this->getContext();
    $user = $context->getUser();
    $request = $context->getRequest();
    $domain_cultures = sfConfig::get('app_domain_cultures');
    
    foreach($domain_cultures as $culture => $domains)
    {
        if( in_array($request->getHost(), $domains) )
        {
            $user->setCulture($culture);
            break;
        }
    }
    
    $filterChain->execute();
  } 
}