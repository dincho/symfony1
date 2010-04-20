<?php

class prZong extends sfZong
{
    public function __construct($countryCode)
    {
        parent::__construct();
        
        $this->setCustomerKey(sfConfig::get('app_zong_customer_key'));
        $this->setItemsCurrency(sfConfig::get('app_zong_items_currency'));
        $this->setSupportedCountries(sfConfig::get('app_zong_supported_countries'));
        $this->setCountryCode($countryCode);
    }
}