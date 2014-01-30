<?php

/**
 * geo actions.
 *
 * @package    PolishRomance
 * @subpackage geo
 * @author     Dincho Todorov <dincho at xbuv.com>
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class geoActions extends sfActions
{
  /**
   * Executes index action
   *
   */
    public function executeList()
    {
        $this->processSort();
        $this->processFilters();
    
        $c = new Criteria();
        
        $c->addAlias("adm1",GeoPeer::TABLE_NAME);
        $c->addAlias("adm2",GeoPeer::TABLE_NAME);
        $c->addJoin(GeoPeer::ADM1_ID, GeoPeer::alias("adm1",GeoPeer::ID), Criteria::LEFT_JOIN);
        $c->addJoin(GeoPeer::ADM2_ID, GeoPeer::alias("adm2",GeoPeer::ID), Criteria::LEFT_JOIN);

        $this->addFiltersCriteria($c);
        $this->addSortCriteria($c);
    
        $per_page = $this->getRequestParameter('per_page', sfConfig::get('app_pager_default_per_page'));
        $pager = new sfPropelPager('Geo', $per_page);
        $pager->setCriteria($c);
    
        $pager->setPage($this->getRequestParameter('page', 1));
        $pager->init();
        $this->pager = $pager;

        if ($this->getRequestParameter('page', 1) == 1) {
            $this->getUser()->setAttribute('criteria', $c, 'backend/geo/pager');
        }

        //var_dump($this->filters);
        $this->countries = GeoPeer::getCountriesArray();
        $this->adm1s = GeoPeer::getAllByCountry($this->filters['country']);
        $this->adm2s = GeoPeer::getAllByAdm1Id($this->filters['country'], $this->filters['adm1']);
        $this->DSGs = GeoPeer::getDSG($this->filters['country'], $this->filters['adm1'], $this->filters['adm2']);

    }
  
    public function executeCitiesWithoutCoordinates()
    {
        $this->sort_namespace = 'backend/geoCitiesWithoutCoords/sort';

        if ($this->getRequestParameter('sort'))
        {
            $this->getUser()->setAttribute('sort', $this->getRequestParameter('sort'), $this->sort_namespace);
            $this->getUser()->setAttribute('type', $this->getRequestParameter('type', 'asc'), $this->sort_namespace);
        }

        if (! $this->getUser()->getAttribute('sort', null, $this->sort_namespace))
        {
            $this->getUser()->setAttribute('sort', 'Member::created_at', $this->sort_namespace); //default sort column
            $this->getUser()->setAttribute('type', 'desc', $this->sort_namespace); //default order
        }
        
        
        $c = new Criteria();
        
        if ($sort_column = $this->getUser()->getAttribute('sort', null, $this->sort_namespace))
        {
            $sort_arr = explode('::', $sort_column);
            $peer = $sort_arr[0] . 'Peer';
    
            $sort_column = call_user_func(array($peer,'translateFieldName'), $sort_arr[1], BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
            if ($this->getUser()->getAttribute('type', null, $this->sort_namespace) == 'asc')
            {
                $c->addAscendingOrderByColumn($sort_column);
            } else
            {
                $c->addDescendingOrderByColumn($sort_column);
            }
        }
                
        
        $c->addJoin(MemberPeer::CITY_ID, GeoPeer::ID, Criteria::LEFT_JOIN);
        $c->add(MemberPeer::CITY_ID, null, Criteria::ISNOTNULL);
        $crit = $c->getNewCriterion(GeoPeer::LATITUDE, null, Criteria::ISNULL);
        $crit->addOr($c->getNewCriterion(GeoPeer::LONGITUDE, null, Criteria::ISNULL));
        $c->add($crit);
        $c->addDescendingOrderByColumn(MemberPeer::CREATED_AT);

        $per_page = $this->getRequestParameter('per_page', sfConfig::get('app_pager_default_per_page'));
        $pager = new sfPropelPager('Member', $per_page);
        $pager->setCriteria($c);
        $pager->setPage($this->getRequestParameter('page', 1));
        $pager->init();
        $this->pager = $pager;
    }
  
    public function executeEmptyCountries()
    {
        $con = Propel::getConnection();

        $this->limit = $this->getRequestParameter('per_page', sfConfig::get('app_pager_default_per_page'));
        $this->page = $this->getRequestParameter('page', 1);
        $offset = ($this->page - 1) * $this->limit;
        
        $sql = sprintf('SELECT t1.*
                FROM geo AS t1 LEFT JOIN geo AS t2 ON (t1.country = t2.country AND t2.dsg != "PCL")
                WHERE  t1.DSG = "PCL" AND t2.id IS NULL LIMIT %d, %d', $offset, $this->limit);
        $stmt = $con->createStatement();
        $rs = $stmt->executeQuery($sql, ResultSet::FETCHMODE_NUM);

        $this->geos = GeoPeer::populateObjects($rs);
    }
    
    public function executeEmptyAdm1()
    {
        $con = Propel::getConnection();

        $this->limit = $this->getRequestParameter('per_page', sfConfig::get('app_pager_default_per_page'));
        $this->page = $this->getRequestParameter('page', 1);
        $offset = ($this->page - 1) * $this->limit;
        
        $sql = sprintf('SELECT t1.*
                FROM geo AS t1 LEFT JOIN geo AS t2 ON (t1.country = t2.country AND t2.dsg != "ADM1" AND t1.id = t2.adm1_id)
                WHERE  t1.DSG = "ADM1" AND t2.id IS NULL LIMIT %d, %d', $offset, $this->limit);
        $stmt = $con->createStatement();
        $rs = $stmt->executeQuery($sql, ResultSet::FETCHMODE_NUM);

        $this->geos = GeoPeer::populateObjects($rs);
    }
    
    public function executeEmptyAdm2()
    {
        $con = Propel::getConnection();

        $this->limit = $this->getRequestParameter('per_page', sfConfig::get('app_pager_default_per_page'));
        $this->page = $this->getRequestParameter('page', 1);
        $offset = ($this->page - 1) * $this->limit;
        
        $sql = sprintf('SELECT t1.*
                FROM geo AS t1 LEFT JOIN geo AS t2 ON (t1.country = t2.country AND t1.adm1_id = t2.adm1_id AND t2.dsg != "ADM2" AND t1.id = t2.adm2_id)
                WHERE  t1.DSG = "ADM2" AND t2.id IS NULL LIMIT %d, %d', $offset, $this->limit);
        $stmt = $con->createStatement();
        $rs = $stmt->executeQuery($sql, ResultSet::FETCHMODE_NUM);

        $this->geos = GeoPeer::populateObjects($rs);
    }
    
    public function executeCreate()
    {
        $this->getUser()->checkPerm(array('content_edit'));
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $geo = new Geo();
            $geo->setName($this->getRequestParameter('name'));
            $geo->setCountry($this->getRequestParameter('country'));
            $geo->setDsg($this->getRequestParameter('dsg'));
            $geo->setAdm1Id(($this->getRequestParameter('adm1')) ? $this->getRequestParameter('adm1') : null);
            $geo->setAdm2Id(($this->getRequestParameter('adm2')) ? $this->getRequestParameter('adm2') : null);
            $geo->setLatitude(($this->getRequestParameter('latitude')) ? $this->getRequestParameter('latitude') : null);
            $geo->setLongitude(($this->getRequestParameter('longitude')) ? $this->getRequestParameter('longitude') : null);
            $geo->setPopulation($this->getRequestParameter('population'));
            $geo->setTimezone($this->getRequestParameter('timezone'));
            $geo->save();

            $this->setFlash('msg_ok', 'New geo feature has been added.');
            $redir = ( $this->getRequest()->hasParameter('ret_uri') ) ? base64_decode($this->getRequestParameter('ret_uri')) : 'geo/list';
            $this->redirect($redir);
        }

        $this->adm1s = array();
        $this->adm2s = array();
        $this->countries = GeoPeer::getCountriesArray();

    }
    

    public function validateCreate()
    {
        return ($this->getRequest()->getMethod() == sfRequest::POST ) ? $this->validateGeo() : true;
    }

    public function handleErrorCreate()
    {
        $this->countries = GeoPeer::getCountriesArray();
        $this->adm1s = GeoPeer::getAllByCountry($this->getRequestParameter('country'));
        $this->adm2s = ($this->getRequestParameter('adm1')) ? GeoPeer::getAllByAdm1Id($this->getRequestParameter('country'), $this->getRequestParameter('adm1')) : array();
    
        return sfView::SUCCESS;
    }
        
    public function executeCreateCountry()
    {
        $this->getUser()->checkPerm(array('content_edit'));
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $geo = new Geo();
            $geo->setName($this->getRequestParameter('name'));
            $geo->setCountry($this->getRequestParameter('iso_code'));
            $geo->setTimezone($this->getRequestParameter('timezone'));
            $geo->setDsg('PCL');
            $geo->save();

            $this->setFlash('msg_ok', 'New country has been added.');
            $redir = ( $this->getRequest()->hasParameter('ret_uri') ) ? base64_decode($this->getRequestParameter('ret_uri')) : 'geo/list';
            $this->redirect($redir);
        }
    }    
    
    public function handleErrorCreateCountry()
    {
        return sfView::SUCCESS;
    }
    
    public function executeEditCountry()
    {
        $this->getUser()->checkPerm(array('content_edit'));
        
        $c = new Criteria();
        $c->add(GeoPeer::DSG, 'PCL');
        $c->add(GeoPeer::ID, $this->getRequestParameter('id'));
        $geo = GeoPeer::doSelectOne($c);
        
        $this->forward404Unless($geo);
                
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $geo->setName($this->getRequestParameter('name'));
            $geo->setCountry($this->getRequestParameter('iso_code'));
            $geo->setTimezone($this->getRequestParameter('timezone'));
            $geo->save();
            
            if( $this->getRequestParameter('set_subs_timezone') )
            {
                $c = new Criteria();
                $c->add(GeoPeer::COUNTRY, $geo->getCountry());
                
                $c2 = new Criteria();
                $c2->add(GeoPeer::TIMEZONE, $this->getRequestParameter('timezone'));
                
                BasePeer::doUpdate($c, $c2, Propel::getConnection());
            }
            
            $this->setFlash('msg_ok', 'You changes has been saved.');
            $redir = ( $this->getRequest()->hasParameter('ret_uri') ) ? base64_decode($this->getRequestParameter('ret_uri')) : 'geo/list';
            $this->redirect($redir);
        }
        
        $this->geo = $geo;
    }    
    
    public function validateEditCountry()
    {
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $c = new Criteria();
            $c->add(GeoPeer::DSG, 'PCL');
            $c->add(GeoPeer::ID, $this->getRequestParameter('id'), Criteria::NOT_EQUAL);
            $c->add(GeoPeer::COUNTRY, $this->getRequestParameter('iso_code'));
            $geo = GeoPeer::doSelectOne($c);
            
            if( $geo )
            {
                $this->getRequest()->setError('iso_code', 'That country code is already in use');
                return false;
            }
        }
        
        return true;
    }
    
    public function handleErrorEditCountry()
    {
        $c = new Criteria();
        $c->add(GeoPeer::DSG, 'PCL');
        $c->add(GeoPeer::ID, $this->getRequestParameter('id'));
        $this->geo = GeoPeer::doSelectOne($c);
        
        return sfView::SUCCESS;
    }    


    private function validateGeo()
    {
        $request = $this->getContext()->getRequest();
        $country_iso = $request->getParameter('country');
        $adm1 = $request->getParameter('adm1');
        $adm2 = $request->getParameter('adm2');
        $dsg = $request->getParameter('dsg');


        if ( !$country_iso || !ctype_alpha($country_iso) )
        {
            $this->getRequest()->setError('country', 'Please select country');
            return false;
        }

        $c = new Criteria();
        $c->add(GeoPeer::COUNTRY, $country_iso);
        $c->add(GeoPeer::DSG, 'ADM1');
        $has_adm1 = GeoPeer::doCount($c);

        if ( $has_adm1 )
        {
            if( $dsg != 'ADM1' && !$adm1 )
            {
                $this->getRequest()->setError('adm1', 'Please select ADM1');
                return false;            
            }

            //adm1 obj
            $c->add(GeoPeer::ID, $adm1);
            $adm1_obj = GeoPeer::doSelectOne($c);

            if( $dsg != 'ADM1' && !$adm1_obj )
            {
                $this->getRequest()->setError('adm1', 'Selected ADM1 does not exists in selected country');
                return false;
            }

            //has adm1 but no error so add the adm1 area to the criteria
            $c->add(GeoPeer::ADM1_ID, $adm1);
        }

        $c->add(GeoPeer::DSG, 'ADM2');
        $c->remove(GeoPeer::ID);
        $has_adm2 = GeoPeer::doCount($c);

        if ( $has_adm2 )
        {
            if( $dsg == 'PPL' && !$adm2 )
            {
                $this->getRequest()->setError('adm2', 'Please select ADM2');
                return false;            
            }

            //adm2 obj
            $c->add(GeoPeer::ID, $adm2);
            $adm2_obj = GeoPeer::doSelectOne($c);

            if( $dsg == 'PPL' &&  !$adm2_obj )
            {
                $this->getRequest()->setError('adm2', 'Selected ADM2 does not exists in selected country and ADM1');
                return false;
            }

            //has adm2 but no error so add the adm2 area to the criteria
            $c->add(GeoPeer::ADM2_ID, $adm2);
        }

        return true;  
    } 

    public function executeEdit()
    {
        $this->getUser()->checkPerm(array('content_edit'));
        
        $geo = GeoPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($geo);

        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $geo->setName($this->getRequestParameter('name'));
            $geo->setCountry($this->getRequestParameter('country'));
            $geo->setDsg($this->getRequestParameter('dsg'));
            $geo->setAdm1Id(($this->getRequestParameter('adm1')) ? $this->getRequestParameter('adm1') : null);
            $geo->setAdm2Id(($this->getRequestParameter('adm2')) ? $this->getRequestParameter('adm2') : null);
            $geo->setLatitude(($this->getRequestParameter('latitude')) ? $this->getRequestParameter('latitude') : null);
            $geo->setLongitude(($this->getRequestParameter('longitude')) ? $this->getRequestParameter('longitude') : null);
            $geo->setTimezone($this->getRequestParameter('timezone'));
            $geo->setPopulation($this->getRequestParameter('population'));
            $geo->save();
        
            if( $this->getRequestParameter('set_subs_timezone') )
            {
                $c = new Criteria();
                $c->add(GeoPeer::COUNTRY, $geo->getCountry());
                
                if( $geo->getDSG() == 'ADM2' ) 
                {   
                    $c->add(GeoPeer::ADM1_ID, $geo->getAdm1Id());
                    $c->add(GeoPeer::ADM2_ID, $geo->getId());
                    $c->add(GeoPeer::DSG, 'PPL');
                } elseif( $geo->getDSG() == 'ADM1' ) 
                {
                    $c->add(GeoPeer::ADM1_ID, $geo->getId());
                }
                
                $c2 = new Criteria();
                $c2->add(GeoPeer::TIMEZONE, $this->getRequestParameter('timezone'));
                
                BasePeer::doUpdate($c, $c2, Propel::getConnection());
            }
            
            $this->setFlash('msg_ok', 'Your changed has been saved.');
            $redir = ( $this->getRequest()->hasParameter('ret_uri') ) ? base64_decode($this->getRequestParameter('ret_uri')) : 'geo/list';
            $this->redirect($redir);
        }

        $pager_crit = $this->getUser()->getAttribute('criteria', new Criteria(), 'backend/geo/pager');
        $this->pager = new GeoPager($pager_crit, $geo->getId());
        $this->pager->init();

        $this->adm1s = GeoPeer::getAllByCountry($geo->getCountry());
        $this->adm2s = GeoPeer::getAllByAdm1Id($geo->getCountry(), $geo->getAdm1Id());
        $this->geo = $geo;
        $this->geo_string = $this->getGeoString($geo);
    }

    private function getGeoString(Geo $geo)
    {
        $geo_tree = array();
        $c = new sfCultureInfo('en');
        $countries = $c->getCountries();

        if (isset($countries[$geo->getCountry()])) {
            $geo_tree[] = $countries[$geo->getCountry()];
        }
        
        if ($geo->getDsg() == 'PPL' && $geo->getAdm2Id()) {
            $geo_tree[] = $geo->getAdm2();
        } elseif ($geo->getDsg() == 'ADM2') {
            $geo_tree[] = $geo->getAdm1();
        }
        
        if ($geo->getDSG() != 'PCL') {
            $geo_tree[] = $geo->getName();
        }
        
        return implode(' ', array_reverse($geo_tree));
    }
    
    public function validateEdit()
    {
        return ($this->getRequest()->getMethod() == sfRequest::POST ) ? $this->validateGeo() : true;
    }

    public function handleErrorEdit()
    {
        $geo = GeoPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($geo);
  
        $this->adm1s = GeoPeer::getAllByCountry($this->getRequestParameter('country'));
        $this->adm2s = ( $this->getRequestParameter('adm1') ) ? GeoPeer::getAllByAdm1Id($this->getRequestParameter('country'), $this->getRequestParameter('amd1')) : array();
        $this->geo = $geo;
      
        return sfView::SUCCESS;
    }

    
    public function executeBatchEdit()
    {
        $this->getUser()->checkPerm(array('content_edit'));
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $marked = explode(',', $this->getRequestParameter('marked'));
            if( empty($marked) )
            {
                $this->setFlash('msg_error', 'No geo features marked for batch update.');
                $this->redirect('geo/list');
            }
            
            $c1 = new Criteria();
            $c1->add(GeoPeer::ID, $marked, Criteria::IN);
            
            $c2 = new Criteria();
            if( $this->getRequestParameter('set_country') ) $c2->add(GeoPeer::COUNTRY, $this->getRequestParameter('country'));
            if( $this->getRequestParameter('set_adm1') ) $c2->add(GeoPeer::ADM1_ID, $this->getRequestParameter('adm1'));
            if( $this->getRequestParameter('set_adm2') ) $c2->add(GeoPeer::ADM2_ID, $this->getRequestParameter('adm2'));
            if( $this->getRequestParameter('set_dsg') ) $c2->add(GeoPeer::DSG, $this->getRequestParameter('dsg'));
            if( $this->getRequestParameter('set_timezone')) $c2->add(GeoPeer::TIMEZONE, $this->getRequestParameter('timezone'));
            
            BasePeer::doUpdate($c1, $c2, Propel::getConnection());
            
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $redir = ( $this->getRequest()->hasParameter('ret_uri') ) ? base64_decode($this->getRequestParameter('ret_uri')) : 'geo/list';
            $this->redirect($redir);
        }
        
        $this->adm1s = array();
        $this->adm2s = array();
        
        
    }
    
    public function validateBatchEdit()
    {
        if( $this->getRequest()->getMethod() == sfRequest::POST ) 
        {
            if( !$this->getRequestParameter('set_country') && !$this->getRequestParameter('set_adm1') 
                && !$this->getRequestParameter('set_adm2') && !$this->getRequestParameter('set_dsg') && !$this->getRequestParameter('set_timezone'))
                {
                    $this->getRequest()->setError('general', 'No fields selected for update!');
                    return false;
                }
        }
        
        return true;
    }

    
    public function handleErrorBatchEdit()
    {
        $this->adm1s = ( $this->getRequestParameter('country') ) ? GeoPeer::getAllByCountry($this->getRequestParameter('country')) : array();
        $this->adm2s = ( $this->getRequestParameter('adm1') ) ? GeoPeer::getAllByAdm1Id($this->getRequestParameter('country'), $this->getRequestParameter('amd1')) : array();        
        
        return sfView::SUCCESS;
    }
    
    public function executeDelete()
    {
        $this->getUser()->checkPerm(array('content_edit'));
        
        $geo = GeoPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($geo);

        try {
            $geo->delete();
        } catch (PropelException $e) {
            $this->setFlash('msg_error', 'You can\'t delete this feature, because it\'s used');
            $this->redirect('geo/edit?id=' . $geo->getId());
        }

        $this->setFlash('msg_ok', 'Geo feature have been deleted.');
        $redir = ( $this->getRequest()->hasParameter('ret_uri') ) ? base64_decode($this->getRequestParameter('ret_uri')) : 'geo/list';
        $this->redirect($redir);
    }

    public function executeEditInfo()
    {
        $geo = GeoPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($geo);
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $geo->setInfo($this->getRequestParameter('info'));
            $geo->save();
            
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('geo/list');
        }
        
        $this->geo = $geo;
    }

    public function executeEditDetails()
    {
        $details = GeoDetailsPeer::retrieveByPK($this->getRequestParameter('id'), $this->getRequestParameter('cat_id'));
        
        if( !$details ) 
        {
            $details = new GeoDetails();
            $details->setId($this->getRequestParameter('id'));
            $details->setCatId($this->getRequestParameter('cat_id'));
        }
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $details->setMemberInfo($this->getRequestParameter('member_info'));
            $details->setSeoInfo($this->getRequestParameter('seo_info'));
            $details->save();
            
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            //$this->redirect('geo/list');
        }
        
        $this->details = $details;
    }
    
    public function executeUploadPhoto()
    {
        $geo = GeoPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($geo);
        $this->forward404Unless($this->getRequest()->getMethod() == sfRequest::POST);
        
        if ($this->getRequest()->getFileSize('new_photo'))
        {
            $photo = new GeoPhoto();
            $photo->setGeoId($geo->getId());
            $photo->updateImageFromRequest('file', 'new_photo');
            $photo->save();
            
            $this->setFlash('msg_ok', 'New photo has been uploaded');
        }
        
        $this->redirect('geo/editDetails?id=' . $geo->getId());
    }
    
    public function executeDeletePhoto()
    {
        $photo = GeoPhotoPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($photo);
        
        $photo->delete();
        
        $this->setFlash('msg_ok', 'Selected photo has been deleted');
        $this->redirect('geo/editInfo?id=' . $photo->getGeoId());
    }
    
    protected function processSort()
    {
        $this->sort_namespace = 'backend/geo/sort';

        if ($this->getRequestParameter('sort'))
        {
            $this->getUser()->setAttribute('sort', $this->getRequestParameter('sort'), $this->sort_namespace);
            $this->getUser()->setAttribute('type', $this->getRequestParameter('type', 'asc'), $this->sort_namespace);
        }

        if (! $this->getUser()->getAttribute('sort', null, $this->sort_namespace))
        {
            $this->getUser()->setAttribute('sort', 'Geo::id', $this->sort_namespace); //default sort column
            $this->getUser()->setAttribute('type', 'desc', $this->sort_namespace); //default order
        }
    }

    protected function addSortCriteria($c)
    {
        if ($sort_column = $this->getUser()->getAttribute('sort', null, $this->sort_namespace))
        {
            if( stripos($sort_column, '|') !== false )
            {
                list($alias, $sort_column) = explode('|', $sort_column);
                list($peerName, $column) = explode('::', $sort_column);
                $peer = $peerName. 'Peer';
                
                $peer_column = call_user_func(array($peer,'translateFieldName'), $column, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
                $sort_column = call_user_func(array($peer,'alias'), $alias, $peer_column);
                
            } else {
                list($peerName, $column) = explode('::', $sort_column);
                $peer = $peerName. 'Peer';
    
                $sort_column = call_user_func(array($peer,'translateFieldName'), $column, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME);
            }
            
            if ($this->getUser()->getAttribute('type', null, $this->sort_namespace) == 'asc')
            {
                $c->addAscendingOrderByColumn($sort_column);
            } else
            {
                $c->addDescendingOrderByColumn($sort_column);
            }
        }
    }

    protected function processFilters()
    {
        if ($this->getRequest()->hasParameter('filter'))
        {
            $filters = $this->getRequestParameter('filters');
            if(isset($filters['country'])) $filters['country'] = array_filter($filters['country']);
            if(isset($filters['adm1']))  $filters['adm1'] = array_filter($filters['adm1']);
            if(isset($filters['adm2']))  $filters['adm2'] = array_filter($filters['adm2']);
            if(isset($filters['dsg'])) $filters['dsg'] = array_filter($filters['dsg']);
            $this->getUser()->getAttributeHolder()->removeNamespace('backend/geo/filters');
            $this->getUser()->getAttributeHolder()->add($filters, 'backend/geo/filters');
        }

        $filters = $this->getUser()->getAttributeHolder()->getAll('backend/geo/filters');
            
        //setting default values
        if( !isset($filters['country']) ) $filters['country'] = array('US');
        if( !isset($filters['adm1']) ) $filters['adm1'] = array();
        if( !isset($filters['adm2']) ) $filters['adm2'] = array();
        if( !isset($filters['dsg']) ) $filters['dsg'] = array();
        if( !isset($filters['name']) ) $filters['name'] = null;

        $this->filters = $filters;
    }

    protected function addFiltersCriteria($c)
    {
        if( count($this->filters['country']) > 0 && !in_array('GEO_ALL', $this->filters['country']) )
        {
            if( in_array('GEO_UNASSIGNED', $this->filters['country']) )
            {
                $crit = $c->getNewCriterion(GeoPeer::COUNTRY, null, Criteria::ISNULL);
                $crit->addOr($c->getNewCriterion(GeoPeer::COUNTRY, ''));
                $c->add($crit);
            } else {
                $c->add(GeoPeer::COUNTRY, $this->filters['country'], Criteria::IN);
            }
            
        }
        
        if( count($this->filters['adm1']) > 0 && !in_array('GEO_ALL', $this->filters['adm1']) )
        {
            if( in_array('GEO_UNASSIGNED', $this->filters['adm1']) )
            {
                $crit = $c->getNewCriterion(GeoPeer::ADM1_ID, null, Criteria::ISNULL);
                $crit->addOr($c->getNewCriterion(GeoPeer::ADM1_ID, ''));
                $c->add($crit);
            } else {
                $c->add(GeoPeer::ADM1_ID, $this->filters['adm1'], Criteria::IN);
            }
            
        }        

        if( count($this->filters['adm2']) > 0 && !in_array('GEO_ALL', $this->filters['adm2']) )
        {
            if( in_array('GEO_UNASSIGNED', $this->filters['adm2']) )
            {
                $crit = $c->getNewCriterion(GeoPeer::ADM2_ID, null, Criteria::ISNULL);
                $crit->addOr($c->getNewCriterion(GeoPeer::ADM2_ID, ''));
                $c->add($crit);
            } else {
                $c->add(GeoPeer::ADM2_ID, $this->filters['adm2'], Criteria::IN);
            }
            
        }   
        
        if( count($this->filters['dsg']) > 0 && !in_array('GEO_ALL', $this->filters['dsg']) )
        {
            if( in_array('GEO_UNASSIGNED', $this->filters['dsg']) )
            {
                $crit = $c->getNewCriterion(GeoPeer::DSG, null, Criteria::ISNULL);
                $crit->addOr($c->getNewCriterion(GeoPeer::DSG, ''));
                $c->add($crit);
            } else {
                $c->add(GeoPeer::DSG, $this->filters['dsg'], Criteria::IN);
            }
            
        }  

        if( $this->filters['name'] )
        {
            $name = str_replace('*', '%', $this->filters['name']);
            $name = str_replace('%%', '%', $name);
            $c->add(GeoPeer::NAME, $name, Criteria::LIKE);
        }         
    }  
}
