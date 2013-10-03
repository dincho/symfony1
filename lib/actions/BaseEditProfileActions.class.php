<?php
class BaseEditProfileActions extends prActions
{
    public function getContentModule()
    {
        return ( sfConfig::get('sf_app') == 'frontend' ) ? 'content' : 'system';
    }
    
    public function executePhotos()
    {
        $this->forward404Unless($this->member);
        
        $this->getResponse()->addJavascript('photos', 'last');
        $this->getResponse()->addJavascript('swfupload/swfupload.js', 'last');
        $this->getResponse()->addJavascript('swfupload/swfupload.swfobject.js', 'last');
        $this->getResponse()->addJavascript('swfupload/handlers.js', 'last');
        
        $this->public_photos = $this->member->getPublicMemberPhotos();
        $this->private_photos = $this->member->getPrivateMemberPhotos();
    }

    public function executeMovePhotoError()
    {
        sfLoader::loadHelpers(array('Partial'));
        
        $this->setFlash('msg_error', 'You must have at least one public photo.', false);
        return $this->renderText(get_partial($this->getContentModule() . '/messages'));
    }
    
    public function executeConfirmDeletePhoto()
    {
        $this->forward404Unless($this->member);
        
        sfLoader::loadHelpers(array('Partial'));
        
        return $this->renderText(get_partial('editProfile/confirm_delete_photo', array('member' => $this->member)));
    }
    
    public function executeDeletePhoto()
    {
        $this->forward404Unless($this->member);
        
        sfLoader::loadHelpers(array('Partial'));
        
        $c = new Criteria();
        $c->add(MemberPhotoPeer::MEMBER_ID, $this->member->getId());
        $c->add(MemberPhotoPeer::ID, $this->getRequestParameter('id'));
        $photo = MemberPhotoPeer::doSelectOne($c);
        $this->forward404Unless($photo);
        
        $photo->delete();
        
        $this->member->setLastPhotoUploadAt(time());
        $this->member->save();
        
        $this->setFlash('msg_ok', 'Your photo has been deleted.', false);
        
        return $this->renderText(get_partial('editProfile/delete_photo'));
    }

    public function handleErrorDeletePhoto()
    {
        sfLoader::loadHelpers(array('Partial'));
        
        return $this->renderText(get_partial($this->getContentModule() . '/formErrors'));
    }
    
    public function executeAjaxPhotoHandler()
    {
        $this->forward404Unless($this->member);
        
        $photos = $this->getRequestParameter('photos');
        $block_id = $this->getRequestParameter('block_id');
        $is_private = ($block_id == 'private_photos');
        $cnt = count($photos);

        $c = new Criteria();
        $c->add(MemberPhotoPeer::MEMBER_ID, $this->member->getId());
                
        for($i=0; $i<$cnt; $i++)
        {
            $c->add(MemberPhotoPeer::ID, $photos[$i]);
            $photo = MemberPhotoPeer::doSelectOne($c);
            
            if( !$photo )
            {
                continue;
            }
            
            $photo->setSortOrder($i+1);
            $photo->setIsPrivate($is_private);
            $photo->save();

            if( $is_private )
            {
                if( $photo->isMain() ) //main photo moved to private photos
                {
                    $this->member->setMainPhotoId(null);
                }
            } elseif( $i == 0 ) //main photo is always the first public photo
            {
                $photo->setAsMainPhoto();
            }

        }
        
        $this->member->setLastPhotoUploadAt(time());
        $this->member->save();
        
        return sfView::NONE;
    }
    
    public function executeUploadPhoto()
    {
        $this->forward404Unless($this->member);
        
        sfLoader::loadHelpers(array('Partial'));
        
        sfConfig::set('sf_web_debug', false);
        
        $block_id = $this->getRequestParameter('block_id');
        $is_private = ($block_id == 'private_photos');

        $domain = $this->member->getCatalogue()->getDomain();
        $catalog_domains = sfConfig::get('app_catalog_domains');
        if( isset($catalog_domains[$domain]) ) $domain = $catalog_domains[$domain];
        
        $member_photo = new MemberPhoto();
        $member_photo->setMember($this->member);
        $exif_info = $member_photo->updateImageFromRequest('file', 'Filedata', true, $brandName = $domain);
        $member_photo->setIsPrivate($is_private);
        $member_photo->setSortOrder(PHP_INT_MAX);
        $member_photo->save();

        if( !($exif_info === false) )
        {
          $photo_exif_info = new PhotoExifInfo();
          $photo_exif_info->setPhotoId($member_photo->getId());
          $photo_exif_info->setExifInfo($exif_info);
          $photo_exif_info->save();
        }
        sfContext::getInstance()->getLogger()->info('executeUploadPhoto - $photo_exif_info - '.$exif_info);
        
        $this->member->setLastPhotoUploadAt(time());
        $this->member->setReviewedById(null);
        $this->member->setReviewedAt(null);
        // try to set the photo as main
        if(is_null($this->member->getMainPhotoId()) && !$is_private)
        {
            $this->member->setMainPhotoId($member_photo->getId());
        }
        $this->member->save();
        

        $this->getResponse()->setContentType('application/json');
        $return = array('status' => 'success', 'data' => get_partial('editProfile/photo_slot', array('photo' => $member_photo)));
        return $this->renderText(json_encode($return));
    }
    
    public function validateUploadPhoto()
    {
        $this->forward404Unless($this->member);
        
        $subscription = $this->member->getSubscriptionDetails();
        
        $file_arr = $this->getRequest()->getFile('Filedata');
        if( !$file_arr['name'] )
        {
            $this->getRequest()->setError('Filedata', 'Please select photo');
            return false;
        }
        
        if( $file_arr['tmp_name'] )
        {
            $image_info = getimagesize($file_arr['tmp_name']);
            
            if( empty($image_info) )
            {
                $this->getRequest()->setError('Filedata', 'Please select correct file type');
                return false;
            }
            
            if( $image_info[0] < 200 )
            {
                $this->getRequest()->setError('Filedata', 'The photo should be at least 200px wide');
                return false;
            }
        }
        
        if( $this->getRequestParameter('block_id') == 'public_photos' )
        {
            $cnt_photos = $this->member->countPublicMemberPhotos();
            
            if (! $subscription->getCanPostPhoto())
            {
              $this->getRequest()->setError('subscription', sprintf('%s: In order to post photo you need to upgrade your membership.', $subscription->getTitle()));
              return false;
            }
        
            if ($cnt_photos >= $subscription->getPostPhotos())
            {
              $this->getRequest()->setError('subscription', 
                                  sprintf('%s: For the feature that you want to use - post photo - you have reached the limit up to which you can use it with your membership. In order to post photo, please upgrade your membership.',
                                  $subscription->getTitle()));
              return false;
            }            
        } elseif( $this->getRequestParameter('block_id') == 'private_photos' )
        {
            if ($this->member->countPublicMemberPhotos() == 0)
            {
                $this->getRequest()->setError('photo', 'You must have at least one public photo in order to upload private photos.');
                return false;
            }

            $cnt_photos = $this->member->countPrivateMemberPhotos();
            
            if (! $subscription->getCanPostPrivatePhoto())
            {
              $this->getRequest()->setError('subscription', sprintf('%s: In order to post private photo you need to upgrade your membership.', $subscription->getTitle()));
              return false;
            }
        
            if ($cnt_photos >= $subscription->getPostPrivatePhotos())
            {
              $this->getRequest()->setError('subscription', 
                sprintf('%s: For the feature that you want to use - post private photo - you have reached the limit up to which you can use it with your membership. In order to post private photo, please upgrade your membership.',
                $subscription->getTitle()));
              return false;
            }              
        }
        
        return true;
    }
    
    public function handleErrorUploadPhoto()
    {
        sfLoader::loadHelpers(array('Partial'));
        sfConfig::set('sf_web_debug', false);
        
        $this->getResponse()->setContentType('application/json');
        $return = array('status' => 'failed', 'messages' => get_partial($this->getContentModule() . '/formErrors', array('show_message_bar' => true)));
        return $this->renderText(json_encode($return));                
    }

}