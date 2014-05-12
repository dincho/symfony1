<?php

class prZong extends sfZong
{
    public function __construct($countryCode, $currency)
    {
        parent::__construct();

        $this->setCustomerKey(sfConfig::get('app_zong_customer_key'));
        $this->setItemsCurrency($currency);
        $this->setSupportedCountries(sfConfig::get('app_zong_supported_countries'));
        $this->setCountryCode($countryCode);
    }
}
