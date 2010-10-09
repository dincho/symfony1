<?php
class DomainsRoutingConfigHandler extends sfRoutingConfigHandler 
{
  public function execute($configFiles)
  {
    // parse the yaml
    $default_config = $this->parseYamls($configFiles);

    $routing = sfRouting::getInstance();
    foreach ($default_config as $name => $params)
    {
      $routing->connect(
        $name,
        ($params['url'] ? $params['url'] : '/'),
        (isset($params['param']) ? $params['param'] : array()),
        (isset($params['requirements']) ? $params['requirements'] : array())
      );
    }

    $default_routes = var_export($routing->getRoutes(), 1);
    
    $retval = sprintf("<?php\n".
                      "// auto-generated by sfRoutingConfigHandler\n".
                      "// date: %s\n
                      \$routes = sfRouting::getInstance();\n",
                      date('Y/m/d H:i:s'));

    $domain_cultures = sfConfig::get('app_domain_cultures');
    if( empty($domain_cultures) )
    {
        throw new Exception("Culture based domains are not set!");
    }
    
    $routing->clearRoutes();
    foreach ($default_config as $name => $params)
    {
        unset($params['param']['sf_culture']);
        $routing->connect(
            $name,
            ($params['url'] ? str_replace(':sf_culture/', '', $params['url']) : '/'),
            (isset($params['param']) ? $params['param'] : array()),
            (isset($params['requirements']) ? $params['requirements'] : array())
        );
    }
  
    $domain_routes = var_export($routing->getRoutes(), 1);
    $domains_array = "'" .implode("','", array_values($domain_cultures)) . "'";
    $retval .= sprintf("\nif(in_array(@\$_SERVER['HTTP_HOST'], array(%s))  ) {
                                   \$routes->setRoutes(\n%s\n); \n}", 
                                   $domains_array, $domain_routes);    

    $routing->clearRoutes();
    $retval .= sprintf("else{ \$routes->setRoutes(\n%s\n); }\n", $default_routes);
    
    return $retval;
  }
}
