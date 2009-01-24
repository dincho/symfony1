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
        $this->left_menu_selected = 10;
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
        $photo = StockPhotoPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($photo);
        $photo->delete();
        $this->setFlash('msg_ok', 'Photo have been deleted.');
        $this->redirect($this->getUser()->getRefererUrl());        
    }
    
    public function executeAddToHomepage()
    {
        $this->getUser()->getBC()->add(array('name' => 'Home Page'));
        
        $photo = StockPhotoPeer::retrieveByPK($this->getRequestParameter('photo_id'));
        $this->forward404Unless($photo);
        $user = $this->getUser();
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $user->setAttribute('catalogs', array_values($this->getRequestParameter('catalogs')), 'backend/photos/catalogs');
            $this->redirect('photos/crop?type=1&photo_id=' . $photo->getId());
        }
        
        $this->photo = $photo;
        $this->homepages = ( $user->hasAttribute('catalogs', 'backend/photos/catalogs') ) ? $user->getAttribute('catalogs', array(), 'backend/photos/catalogs') : $photo->getHomepagesArray();
        $this->catalogs = CataloguePeer::doSelect(new Criteria());
    }
    
    public function executeAddToMemberStories()
    {
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
    
    public function executeCrop()
    {
        $photo = StockPhotoPeer::retrieveByPK($this->getRequestParameter('photo_id'));
        $this->forward404Unless($photo && $this->getRequestParameter('type'));
        
        if( $this->getRequest()->getMethod() == sfRequest::POST )
        {
            $photo->setGender($this->getRequestParameter('gender'));
            
            if( $this->getRequestParameter('type') == 1) //homepage
            {
                $photo->setHomepagesArray($this->getUser()->getAttribute('catalogs', array(), 'backend/photos/catalogs'));
                $this->getUser()->setAttribute('catalogs', null, 'backend/photos/catalogs');
            }
            
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
                	    $this->redirect('photos/memberStories?photo_id=' . $this->getRequestParameter('photo_id'));
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
            	   $bc->add(array('name' => 'Most Recent'));
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
