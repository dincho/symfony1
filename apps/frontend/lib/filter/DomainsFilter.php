<?php

class DomainsFilter extends sfFilter
{
  public function execute($filterChain)
  {
    $context = $this->getContext();
    $user = $context->getUser();
    $request = $context->getRequest();
    $host = $request->getHost();
    $domain_cultures = sfConfig::get('app_domain_cultures');

    //strip the port
    if (false !== ($pos = strpos($host, ':'))) {
        $host = substr($host, 0, $pos);
    }

    foreach ($domain_cultures as $culture => $domains) {
        if (in_array($host, $domains)) {
            $user->setCulture($culture);
            break;
        }
    }

    $filterChain->execute();
  }
}
