<?php

/**
 * photos actions.
 *
 * @package    PolishRomance
 * @subpackage photos
 * @author     Dincho Todorov <dincho at xbuv.com>
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class photosActions extends sfActions
{

    public function preExecute()
    {
        $this->top_menu_selected = 'content';
        $this->left_menu_selected = 12;
        $this->getUser()->getBC()->clear()->add(array('name' => 'content', 'uri' => 'content/list'))
        ->add(array('name' => 'Stock Photos', 'uri' => 'photos/stockPhotos'));
    }

    public function executeIndex()
    {
        $this->forward('photos', 'list');
    }

    public function executeList()
    {
        $this->getUser()->getBC()->replaceLast(array('name' => 'Photos', 'uri' => 'photos/list'));
        $this->processFilters();
        $this->filters = $this->getUser()->getAttributeHolder()->getAll('backend/photos/filters');
        $this->processSort();
        
        $c = new Criteria();
        $c->addGroupByColumn(MemberPeer::ID);
        $c->addHaving($c->getNewCriterion(MemberPhotoPeer::COUNT, 'COUNT( '.MemberPhotoPeer::ID.') > 0 ',Criteria::CUSTOM));
        $c->addJoin(MemberPeer::MEMBER_COUNTER_ID, MemberCounterPeer::ID);
        $this->addFiltersCriteria($c);
        $this->addSortCriteria($c);
        
        $per_page = $this->getRequestParameter('per_page', sfConfig::get('app_pager_default_per_page'));
        $pager = new sfPropelPager('Member', $per_page);
        $pager->setCriteria($c);
        
        $pager->setPage($this->getRequestParameter('page', 1));
        $pager->setPeerMethod('doSelectJoinMemberPhoto');
        $pager->setPeerCountMethod('doCountJoinMemberPhoto');
        $pager->init();
        $this->pager = $pager;
    }
    
    public function executeSelectCountryFilter()
    {
        $this->processFilters();
        $this->filters = $this->getUser()->getAttributeHolder()->getAll('backend/photos/filters');
    }
    
    public function executeStockPhotos()
    {
        $this->sort_namespace = 'backend/photos/sort';
        $c = new Criteria();
        
        if( $this->getRequestParameter('only') == 1 ) //member stories
        {
            $c->addJoin(StockPhotoPeer::ID, MemberStoryPeer::STOCK_PHOTO_ID);
            $c->addGroupByColumn(StockPhotoPeer::ID);
            $c->addHaving($c->getNewCriterion(MemberStoryPeer::COUNT, 'COUNT( '.MemberStoryPeer::ID.') > 0 ',Criteria::CUSTOM));
            $this->getUser()->getBC()->add(array('name' => 'Member Stories'));
            
        } elseif( $this->getRequestParameter('only') == 2 ) //homepage
        {
            $c->add(StockPhotoPeer::HOMEPAGES, null, Criteria::ISNOTNULL);
            $this->getUser()->getBC()->add(array('name' => 'Home Page'));
        }
        
        $per_page = $this->getRequestParameter('per_page', 24);
        $pager = new sfPropelPager('StockPhoto', $per_page);
        $pager->setCriteria($c);
        $pager->setPage($this->getRequestParameter('page', 1));
        $pager->init();
        $this->pager = $pager;        
    }
    
    public function executeDeleteStockPhoto()
    {
        $this->getUser()->checkPerm(array('content_edit'));
        $photo = StockPhotoPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($photo);
        $photo->delete();
        $this->setFlash('msg_ok', 'Photo have been deleted.');
        $this->redirect($this->getUser()->getRefererUrl());        
    }
    
    public function executeAddToHomepage()
    {
        $this->getUser()->checkPerm(array('content_edit'));
        $this->getUser()->getBC()->add(array('name' => 'Home Page'));
        $namespace = 'backend/photos/addtohomepage';
        
        $photo = StockPhotoPeer::retrieveByPK($this->getRequestParameter('photo_id'));
        $this->forward404Unless($photo);
        $user = $this->getUser();
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $user->setAttribute('catalogs', array_values($this->getRequestParameter('catalogs', array())), $namespace);
            $user->setAttribute('homepages_set', $this->getRequestParameter('homepages_set', null), $namespace);
            $user->setAttribute('homepages_pos', $this->getRequestParameter('homepages_pos', null), $namespace);
            $this->redirect('photos/crop?type=1&photo_id=' . $photo->getId());
        }
        
        $this->photo = $photo;
        $this->homepages = ( $user->hasAttribute('catalogs', $namespace) ) ? $user->getAttribute('catalogs', array(), $namespace) : $photo->getHomepagesArray();
        $this->homepages_set = ( $user->hasAttribute('homepages_set', $namespace) ) ? $user->getAttribute('homepages_set', array(), $namespace) : $photo->getHomepagesSet();
        $this->homepages_pos = ( $user->hasAttribute('homepages_pos', $namespace) ) ? $user->getAttribute('homepages_pos', array(), $namespace) : $photo->getHomepagesPos();
        $this->catalogs = CataloguePeer::doSelect(new Criteria());
    }
    
    public function executeAddToMemberStories()
    {
        $this->getUser()->checkPerm(array('content_edit'));
        
        $this->getUser()->getBC()->add(array('name' => 'Member Stories'));
        
        $this->culture = ($this->getRequestParameter('culture', 'en'));
        $photo = StockPhotoPeer::retrieveByPK($this->getRequestParameter('photo_id'));
        $this->forward404Unless($photo);
                    
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $replace = $this->getRequestParameter('replace', array());
            foreach ($this->getRequestParameter('marked', array()) as $story_id)
            {
                $story = MemberStoryPeer::retrieveByPK($story_id);
                if( $story )
                {
                    if( $story->getStockPhotoId() )
                    {
                        if( in_array($story_id, $replace))
                        {
                            $story->setStockPhotoId($photo->getId());
                            $story->save();
                        }
                    } else {
                        $story->setStockPhotoId($photo->getId());
                        $story->save();
                    }
                }
            }
            
            $this->redirect('photos/crop?type=2&photo_id=' . $photo->getId());
        }
        
        $c = new Criteria();
        $c->addAscendingOrderByColumn(MemberStoryPeer::SORT_ORDER);
        $c->add(MemberStoryPeer::CULTURE, $this->culture); 
        $this->stories = MemberStoryPeer::doSelect($c);
        $this->photo = $photo;
    }
    
    
    public function executeAddToAssistant()
    {
        $this->getUser()->checkPerm(array('content_edit'));
        $this->getUser()->getBC()->add(array('name' => 'Assistant'));
        $namespace = 'backend/photos/addtoassistant';
        
        $photo = StockPhotoPeer::retrieveByPK($this->getRequestParameter('photo_id'));
        $this->forward404Unless($photo);
        $user = $this->getUser();
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $user->setAttribute('catalog', $this->getRequestParameter('catalog'), $namespace);
            $this->redirect('photos/crop?type=3&photo_id=' . $photo->getId());
        }
        
        $this->photo = $photo;
        $this->catalog = ( $user->hasAttribute('catalog', $namespace) ) ? $user->getAttribute('catalog', array(), $namespace) : $photo->getAssistants();
    }    
    
    public function executeCrop()
    {
        $this->getUser()->checkPerm(array('content_edit'));
        
        $photo = StockPhotoPeer::retrieveByPK($this->getRequestParameter('photo_id'));
        $this->forward404Unless($photo && $this->getRequestParameter('type'));
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $user = $this->getUser();
            
            if( $this->hasRequestParameter('crop') )
            {
                $crop_area['x1'] = $this->getRequestParameter('crop_x1');
                $crop_area['y1'] = $this->getRequestParameter('crop_y1');
                $crop_area['x2'] = $this->getRequestParameter('crop_x2');
                $crop_area['y2'] = $this->getRequestParameter('crop_y2');
                $crop_area['width'] = $this->getRequestParameter('crop_width');
                $crop_area['height'] = $this->getRequestParameter('crop_height');
                $photo->updateCroppedImage($crop_area);
            }
                        
            if( $this->getRequestParameter('type') == 1) //homepage
            {
                $photo->setGender($this->getRequestParameter('gender'));
                $photo->addEffects('file', '100x95');
                
                
                $namespace = 'backend/photos/addtohomepage';
                $photo->setHomepagesArray($user->getAttribute('catalogs', array(), $namespace));
                $user->setAttribute('catalogs', null, $namespace);
                $photo->setHomepagesSet(($user->getAttribute('homepages_set', null, $namespace)) ?$user->getAttribute('homepages_set', null, $namespace) : null);
                $user->setAttribute('homepages_set', null, $namespace);
                $photo->setHomepagesPos(($user->getAttribute('homepages_pos', null, $namespace)) ? $user->getAttribute('homepages_pos', null, $namespace) : null);
                $user->setAttribute('homepages_pos', null, $namespace);
            } elseif($this->getRequestParameter('type') == 2) //member stories
            {
                $photo->setGender($this->getRequestParameter('gender'));
            } elseif( $this->getRequestParameter('type') == 3) //assistant
            {
                $namespace = 'backend/photos/addtoassistant';
                $catalog = $user->getAttribute('catalog', null, $namespace);
                
                $select = new Criteria();
                $select->add(StockPhotoPeer::ASSISTANTS, $catalog);
                $update = new Criteria();
                $update->add(StockPhotoPeer::ASSISTANTS, null);
                BasePeer::doUpdate($select, $update, Propel::getConnection());
                                
                $photo->setAssistants($catalog);
                $user->setAttribute('catalog', null, $namespace);
            }
            
            $photo->save();
            $this->setFlash('msg_ok', 'Your changes has been saved.');
            $this->redirect('photos/stockPhotos');
        }
        
        if( $this->getRequestParameter('type') == 1) //homepage
        {
            $dims['w'] = 100;
            $dims['h'] = 95;
            $this->getUser()->getBC()->add(array('name' => 'Home Page', 'uri' => 'photos/addToHomepage?photo_id=' . $photo->getId()))
            ->add(array('name' => 'Crop'));
        } elseif( $this->getRequestParameter('type') == 2) //member stories
        {
            $this->getUser()->getBC()->add(array('name' => 'Member Stories', 'uri' => 'photos/addToMemberStories?photo_id=' . $photo->getId()))
            ->add(array('name' => 'Crop'));            
            $dims['w'] = 220;
            $dims['h'] = 225;
        } elseif ($this->getRequestParameter('type') == 3) //assistant
        {
            $dims['w'] = 70;
            $dims['h'] = 105;            
        }
        
        $this->getResponse()->addJavascript('/cropper/lib/prototype.js');
        $this->getResponse()->addJavascript('/cropper/lib/scriptaculous.js?load=builder,dragdrop');
        $this->getResponse()->addJavascript('/cropper/cropper.js');
        $this->getResponse()->addStyleSheet('/cropper/cropper.css', 'last');        
        $this->photo = $photo;
        $this->dims = $dims;
                
    }
    
    public function executeUpload()
    {
        $this->getUser()->checkPerm(array('content_edit'));
        $this->left_menu_selected = 'Upload Photos';
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            if( $this->getRequestParameter('continue') )
            {
                switch ($this->getRequestParameter('continue')) {
                	case 1:
                	    $this->redirect('photos/addToHomepage?photo_id=' . $this->getRequestParameter('photo_id'));
                	break;
                	
                	case 2:
                	    $this->redirect('photos/addToMemberStories?photo_id=' . $this->getRequestParameter('photo_id'));
                	break;
                	
                	default:
                	    $this->redirect('photos/stockPhotos');
                	break;
                }
                
            } elseif($this->getRequest()->getFileSize('new_photo'))
            {
                
                $photo = new StockPhoto();
                $photo->updateImageFromRequest('file', 'new_photo');
                $photo->save();
                
                $this->photo = $photo;
            }
        }
    }
    
    protected function processSort()
    {
        $this->sort_namespace = 'backend/photos/sort';
        
        if ($this->getRequestParameter('sort'))
        {
            if( $this->getRequestParameter('sort') != 'no')
            {
                $this->getUser()->setAttribute('sort', $this->getRequestParameter('sort'), $this->sort_namespace);
                $this->getUser()->setAttribute('type', $this->getRequestParameter('type', 'asc'), $this->sort_namespace);
            } else {
                $this->getUser()->setAttribute('sort', null, $this->sort_namespace);
                $this->getUser()->setAttribute('type', null, $this->sort_namespace);
            }
        }
        
    }

    protected function addSortCriteria($c)
    {
        $sort_column = $this->getUser()->getAttribute('sort', null, $this->sort_namespace);
        if ($sort_column && $sort_column != 'no')
        {
            $bc = $this->getUser()->getBc();
            switch ($sort_column) {
            	case 'Member::created_at':
            	   $bc->add(array('name' => 'Most Recent', 'uri' => 'photos/list'));
            	break;
            	
            	case 'MemberCounter::profile_views':
            	   $bc->add(array('name' => 'Popularity'));
            	break;
            	
            	default:
            	break;
            }
            
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
    }

    protected function processFilters()
    {
        if ($this->getRequest()->hasParameter('filter'))
        {
            $filters = $this->getRequestParameter('filters');
            $this->getUser()->getAttributeHolder()->removeNamespace('backend/photos/filters');
            $this->getUser()->getAttributeHolder()->add($filters, 'backend/photos/filters');
        }
    }

    protected function addFiltersCriteria($c)
    {
        $bc = $this->getUser()->getBc();
        
        if (isset($this->filters['sex']))
        {
            $c->add(MemberPeer::SEX, $this->filters['sex']);
            $bc->add(array('name' => ($this->filters['sex'] == 'M') ? 'Male' : 'Female'));
        }
                    
        if (isset($this->filters['public_search']) && $this->filters['public_search'] == 1)
        {
            $c->add(MemberPeer::PUBLIC_SEARCH, true);
            $bc->add(array('name' => 'Public Search'));
        }
        
        if (isset($this->filters['by_country']) && $this->filters['by_country'] == 1)
        {
            if( !isset($this->filters['country']) ) $this->forward('photos', 'selectCountryFilter');
            $c->add(MemberPeer::COUNTRY, $this->filters['country']);
            $bc->add(array('name' => 'Country - ' . $this->filters['country']));
        }            
    }
}
