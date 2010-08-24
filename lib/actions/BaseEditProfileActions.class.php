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
        
        $this->setFlash('msg_ok', 'Your photo has been deleted.', false);
        
        return $this->renderText(get_partial('editProfile/delete_photo'));
    }

    public function validateDeletePhoto()
    {
        
        $this->forward404Unless($this->member);
        
        $c = new Criteria();
        $c->add(MemberPhotoPeer::MEMBER_ID, $this->member->getId());
        $c->add(MemberPhotoPeer::ID, $this->getRequestParameter('id'));
        $photo = MemberPhotoPeer::doSelectOne($c);
        $this->forward404Unless($photo);
                
        if (!$photo->getIsPrivate() && $photo->getMember()->countPublicMemberPhotos() == 1)
        {
            $this->getRequest()->setError('photo', 'You must have at least one public photo.');
            return false;
        }
        return true;
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
            
            if( $photo )
            {
                $photo->setSortOrder($i+1);
                $photo->setIsPrivate($is_private);
                $photo->save();
            }
            
            if( $i == 0 && !$is_private ) $photo->setAsMainPhoto(); //main photo is always the first public photo
        }

        return sfView::NONE;
    }
    
    public function executeUploadPhoto()
    {
        $this->forward404Unless($this->member);
        
        sfLoader::loadHelpers(array('Partial'));
        
        sfConfig::set('sf_web_debug', false);
        
        $block_id = $this->getRequestParameter('block_id');
        $is_private = ($block_id == 'private_photos');
                
        $member_photo = new MemberPhoto();
        $member_photo->setMember($this->member);
        $member_photo->updateImageFromRequest('file', 'Filedata', true, true);
        $member_photo->setIsPrivate($is_private);
        $member_photo->setSortOrder(PHP_INT_MAX);
        $member_photo->save();
        
        $this->member->setLastPhotoUploadAt(time());
        $this->member->setReviewedById(null);
        $this->member->setReviewedAt(null);
        $this->member->save();
        

        $this->getResponse()->setHttpHeader('Content-type', 'application/json');
        $return = array('status' => 'success', 'data' => get_partial('editProfile/photo_slot', array('photo' => $member_photo)));
        return $this->renderText(json_encode($return));
    }
    
    public function validateUploadPhoto()
    {
        $this->forward404Unless($this->member);
        
        $subscription = $this->member->getSubscription();
        
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

        $return = array('status' => 'failed', 'messages' => get_partial($this->getContentModule() . '/formErrors'));
        return $this->renderText(json_encode($return));                
    }

}