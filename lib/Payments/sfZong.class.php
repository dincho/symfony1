<?php

class sfZong
{
    protected $countryCode = null;
    protected $localCurrency = null;
    protected $itemsCurrency = 'EUR';
    protected $exchangeRate = null;
    protected $cache = null;
    protected $customerKey = null;
    protected $supportedCountries = array();
    private $items = null; //array
    
    public function __construct()
    {
        $this->cache = new sfFileCache(sfConfig::get('sf_cache_dir')."/zong/");
        $this->cache->setLifeTime(10800); //3 hours as recommended by Zong
    }
    
    public function setCountryCode($value)
    {
        $this->countryCode = $value;
    }
    
    public function getCountryCode()
    {
        return $this->countryCode;
    }
    
    public function setItemsCurrency($value)
    {
        $this->itemsCurrency = $value;
    }
    
    public function getItemsCurrency()
    {
        return $this->itemsCurrency;
    }
    
    public function getLocalCurrency()
    {
        return $this->localCurrency;
    }
    
    public function getExchangeRate()
    {
        return $this->exchangeRate;
    }
    
    public function setCustomerKey($key)
    {
        $this->customerKey = $key;
    }
    
    public function getCustomerKey()
    {
        return $this->customerKey;
    }
    
    public function setSupportedCountries(array $values)
    {
        $this->supportedCountries = $values;
    }
    
    public function getSupportedCountries()
    {
        return $this->supportedCountries;
    }
    
    private function getItemsFromAPI()
    {
        $cache_key = $this->getCustomerKey() . '_' . $this->getItemsCurrency() . '_' . $this->getCountryCode();

        if( $this->cache->has( $cache_key ) )
        {
            $response = $this->cache->get( $cache_key );
            return $this->parseXmlResponse($response);
        }
            
        $dom = new DOMDocument();
        $dom->formatOutput = true;

        $request = $dom->createElementNS('http://pay01.zong.com/zongpay', 'requestMobilePaymentProcessEntrypoints');
        $request->setAttributeNS('http://www.w3.org/2000/xmlns/' ,'xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $request->setAttribute('xsi:schemaLocation', 'http://pay01.zong.com/zongpay/zongpay.xsd');
        
        $customerKey = $dom->createElement('customerKey', $this->getCustomerKey());
        $countryCode = $dom->createElement('countryCode', $this->getCountryCode());
        $items = $dom->createElement('items');
        $items->setAttribute('currency', $this->getItemsCurrency());
        
        $request->appendChild($customerKey);
        $request->appendChild($countryCode);
        $request->appendChild($items);
        $dom->appendChild($request);
        
        //echo $dom->saveXML();exit();
        
        $params = array('request' => $dom->saveXML());
        $data = http_build_query($params, '', '&');
        
        $process = curl_init();
        curl_setopt($process, CURLOPT_URL, 'https://pay01.zong.com/zongpay/actions/default?method=lookup');
        curl_setopt($process, CURLOPT_POSTFIELDS, $data);
        curl_setopt($process, CURLOPT_POST, 1);
        curl_setopt($process, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($process, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($process, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($process, CURLOPT_TIMEOUT, 30);
        $response = curl_exec($process);
        $info = curl_getinfo($process);
        curl_close($process);
        
        //print_r($response);exit();
         $items = array();
         
         if( $response !== false && $info['http_code'] == 200 )
         {
            //parsing the response
            $this->cache->set($cache_key, null, $response);
            $items = $this->parseXmlResponse($response);
        }
        
        return $items;
    }
    
    
    private function parseXmlResponse($response)
    {
        $items = array();
        
        $xml_reponse = simplexml_load_string($response);
        $this->localCurrency = $xml_reponse->localCurrency;
        $this->exchangeRate = (float) $xml_reponse->exchangeRate;

        $i = 0;
        if( count($xml_reponse->items) > 0 )
        {
            foreach($xml_reponse->items->item as $item)
            {
                $attributes = $item->attributes();
                foreach($attributes as $name => $value)
                {
                    $$name = (string)$value;
                }

                $items[$i]['entrypointURL'] = (string)$item->entrypointUrl;
                $items[$i]['amount'] = (float) $workingPrice;
                $i++;
            }
        }
        
        return $items;
    }
    
    /**
     * Getter used for variable cache 
     */
    public function getItems()
    {
        if( !in_array($this->getCountryCode(), $this->getSupportedCountries()) ) return array();
        
        //return $this->getItemsFromAPI();
        
        if( is_null($this->items) )
        {
            $this->items = $this->getItemsFromAPI();
        }
        
        return $this->items;
    }
    
    public function getFirstItemWithPriceGreaterThan($amount)
    {
        $items = $this->getItems();
        if( count($items) < 1 ) return array();
        
        $best_match_item = array('amount' => PHP_INT_MAX);
        
        // sfLoader::loadHelpers('I18N');
        // printf("Country: %s ----------------\n", format_country($this->getCountryCode()));
        
        foreach($items as $item)
        {
            $price = $item['amount']/$this->exchangeRate;
            $diff = abs($amount - $price);
            
            $best_match_price = $best_match_item['amount']/$this->exchangeRate;
            $best_match_diff = abs($amount - $best_match_price);
            
            // printf("Item: %.2f %s - %.4f  %s \n", $item['amount'], $this->getLocalCurrency(), $price, $this->getItemsCurrency());

            if( $diff < $best_match_diff )
            {
                $best_match_item = $item;
            }
        }
        
        // printf("Best match: %.2f %s \n",  $best_match_item['amount'], $this->getLocalCurrency());
        return $best_match_item;
    }
}