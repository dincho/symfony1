<?php
class geoActions extends sfActions
{
    public function executeGetAdm1ByCountry()
    {
        $countries = $this->getRequestParameter('country');
        if( $countries && strpos($countries, ',') !== false ) $countries = explode(',', $countries);
        
        // $countries = ($this->getRequestParameter('country')) ? explode(',', $this->getRequestParameter('country')) : array();
        
        if( !$this->getRequestParameter('allow_blank') && !$countries ) return sfView::NONE;
        
        $adm1s = GeoPeer::getAllByCountry($countries);
        
        $adm1s_tmp = array();
        foreach ($adm1s as $adm1)
        {
            $tmp['id'] = $adm1->getId();
            $tmp['title'] = $adm1->getName();
            $adm1s_tmp[] = $tmp;
        }
        
        $output = json_encode($adm1s_tmp);
        
        return $this->renderText($output);
    }
    
    public function executeGetAdm2ByAdm1()
    {
        $output = '';
        if ( $adm1 = $this->getRequestParameter('adm1') )
        {
            $adm2s = GeoPeer::getAllByAdm1($adm1);
            
            $adm2s_tmp = array();
            foreach ($adm2s as $adm2)
            {
                $tmp['id'] = $adm2->getId();
                $tmp['title'] = $adm2->getName();
                $adm2s_tmp[] = $tmp;
            }
            
            $output = json_encode($adm2s_tmp);
            $this->getResponse()->setHttpHeader("X-JSON", '(' . $output . ')');
        }
        return $this->renderText($output);
    }
    
    public function executeGetAdm2ByAdm1Id()
    {
        $countries = ($this->getRequestParameter('country')) ? explode(',', $this->getRequestParameter('country')) : array();
        $adm1s = ($this->getRequestParameter('adm1')) ? explode(',', $this->getRequestParameter('adm1')) : array();
        
        if( !$this->getRequestParameter('allow_blank') && (!$countries || !$adm1s) ) return sfView::NONE;
        
        $adm2s = GeoPeer::getAllByAdm1Id($countries, $adm1s);
    
        $adm2s_tmp = array();
        foreach ($adm2s as $adm2)
        {
            $tmp['id'] = $adm2->getId();
            $tmp['title'] = $adm2->getName();
            $adm2s_tmp[] = $tmp;
        }
    
        $output = json_encode($adm2s_tmp);
        return $this->renderText($output);
    }    
    
    public function executeAutocompleteCity()
    {
        $country = $this->getRequestParameter('country');
        $adm1_id = $this->getRequestParameter('adm1_id');
        $adm2_id = $this->getRequestParameter('adm2_id');
        $city = $this->getRequestParameter('city');
        $list = array();
        
        if( strlen($city) > 1 ) //skip 1 char searches acording to the example in the FS
        {
            if( $adm1_id ) $adm1_obj = GeoPeer::retrieveByPK($adm1_id);
            if( $adm2_id ) $adm2_obj = GeoPeer::retrieveByPK($adm2_id);
        
            $c = new Criteria();
            $c->add(GeoPeer::DSG, "PPL");
            $c->add(GeoPeer::COUNTRY, $country);
            if( $adm1_id && $adm1_obj ) $c->add(GeoPeer::ADM1, $adm1_obj->getName());
            if( $adm2_id && $adm2_obj ) $c->add(GeoPeer::ADM2, $adm2_obj->getName());
            $c->add(GeoPeer::NAME, $city.'%', Criteria::LIKE);
            $c->addAscendingOrderByColumn(GeoPeer::NAME);
            $c->setLimit(14); //add limit to avoid select overflow of the select
        
            $city_objs = GeoPeer::doSelect($c);
        
            foreach($city_objs as $city_obj)
            {
                $list[$city_obj->getId()]=$city_obj->getName();
            }
        }
        
        $this->list = $list;
    }
    
    public function executeGetCities()
    {
      $cities = GeoPeer::getPopulatedPlaces($this->getRequestParameter('country'), $this->getRequestParameter('adm1_id'), $this->getRequestParameter('adm2_id'));
      $output = '';
      
      if ( $cities )
      {
          $cities_tmp = array();
          foreach ($cities as $city)
          {
              $tmp['id'] = $city->getId();
              $tmp['title'] = $city->getName();
              $cities_tmp[] = $tmp;
          }
          
          $output = json_encode($cities_tmp);
      }
      
      return $this->renderText($output);
    }
}