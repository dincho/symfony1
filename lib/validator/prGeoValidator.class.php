<?php
class prGeoValidator extends sfValidator
{
    public function execute(&$value, &$error) 
    {
        $request = $this->getContext()->getRequest();
        $country_iso = $request->getParameter('country');
        $adm1_id = $request->getParameter('adm1_id');
        $adm2_id = $request->getParameter('adm2_id');
        $city_id = $request->getParameter('city_id');
        
        if ( !$country_iso || !ctype_alpha($country_iso) )
        {
            $error['field_name'] = 'country';
            $error['msg'] = 'Please select your country of residence';
            return false;
        }
        
        $c = new Criteria();
        $c->add(GeoPeer::COUNTRY, $country_iso);
        $c->add(GeoPeer::DSG, 'ADM1');
        $has_adm1 = GeoPeer::doCount($c);
        
        if ( $has_adm1 )
        {
            if( !$adm1_id )
            {
                $error['field_name'] = 'adm1_id';
                $error['msg'] = 'Please select you area where you live.';
                return false;            
            }
        
            //adm1 obj
            $c->add(GeoPeer::ID, $adm1_id);
            $adm1= GeoPeer::doSelectOne($c);

            if( !$adm1 )
            {
                $error['field_name'] = 'adm1_id';
                $error['msg'] = "Selected area does not exists in selected country";
                return false;
            }
            
            //has adm1 but no error so add the adm1 area to the criteria
            $c->add(GeoPeer::ADM1_ID, $adm1->getId());
        }
                
        $c->add(GeoPeer::DSG, 'ADM2');
        $c->remove(GeoPeer::ID);
        $has_adm2 = GeoPeer::doCount($c);
        
        if ( $has_adm2 )
        {
            if( !$adm2_id )
            {
                $error['field_name'] = 'adm2_id';
                $error['msg'] = 'Please select you secondary administrative area where you live.';
                return false;            
            }
        
            //adm2 obj
            $c->add(GeoPeer::ID, $adm2_id);
            $adm2 = GeoPeer::doSelectOne($c);

            if( !$adm2 )
            {
                $error['field_name'] = 'adm2_id';
                $error['msg'] = "Selected secondary administrative area does not exists in selected country and area";
                return false;
            }
            
            //has adm2 but no error so add the adm2 area to the criteria
            $c->add(GeoPeer::ADM2_ID, $adm2->getId());
        }
        
        
        if ( !$city_id )
        {
            $error['field_name'] = 'city_id';
            $error['msg'] = 'Please provide city where live.';
            return false;
        }
        
        $c->add(GeoPeer::DSG, 'PPL');
        $c->add(GeoPeer::ID, $city_id);
        $city = GeoPeer::doSelectOne($c);
        
        if( !$city )
        {
            $error['field_name'] = 'city_id';
            $error['msg'] = 'No such city in selected country/areas';
            return false;            
        }
        
        return true;
    }

    public function initialize($context, $parameters = null)
    {
        // Initialize parent
        parent::initialize ( $context );

        //set default parameters
        $this->setParameter('check_block', true);
        $this->setParameter('check_sex', true);
        $this->setParameter('check_onlyfull', true);

        $this->setParameter('block_error', 'This member has blocked you');
        $this->setParameter('sex_error', 'Due to privacy restrictions you cannot interact with this profile');
        $this->setParameter('onlyfull_error', 'Due to privacy restrictions you cannot interact with this profile');

        // Set parameters
        $this->getParameterHolder ()->add($parameters);

        return true;
    }
}