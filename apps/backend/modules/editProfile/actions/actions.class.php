<?php
class editProfileActions extends BaseEditProfileActions
{
    public function preExecute()
    {
        $this->member = MemberPeer::retrieveByPK($this->getRequestParameter('member_id'));
    }

    public function validateUploadPhoto()
    {
            $this->preExecute();
            return parent::validateUploadPhoto();
    }
    
    public function validateDeletePhoto()
    {
        return true; //administrator always can delete photos
    }
    
    public function executeCropPhoto()
    {
        sfLoader::loadHelpers(array('Partial'));
        
        $this->getUser()->checkPerm(array('members_edit'));
        
        if ($this->getRequestParameter('photo_id') && $photo = MemberPhotoPeer::retrieveByPK($this->getRequestParameter('photo_id')))
        {
            $photo->updateCroppedImage($this->getRequestParameter('crop'));
            return $this->renderText( get_partial('editProfile/photo_slot', array('photo' => $photo)) );
        }
        
        return sfView::NONE;
    }

}