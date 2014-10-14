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

    public function executeDeletePhoto()
    {
        parent::executeDeletePhoto();

        // notification hook
        Events::triggerMemberPhotoDeleted($this->member);

        // add a note to profile
        $note = new MemberNote();
        $note->setMember($this->member);
        $note->setUserId($this->getUser()->getId());
        $note->setText('photo deleted');
        $note->save();

        $this->setFlash(
            'msg_ok',
            'Your photo has been deleted. The user will be notified within seconds.',
            false
        );

        return $this->renderText(get_partial('editProfile/delete_photo'));
    }

    public function validateDeletePhoto()
    {
        return true; //administrator always can delete photos
    }

    public function executeCropPhoto()
    {
        sfLoader::loadHelpers(array('Partial'));

        $this->getUser()->checkPerm(array('members_edit'));

        if ($this->getRequestParameter('photo_id') && $photo = MemberPhotoPeer::retrieveByPK($this->getRequestParameter('photo_id'))) {
            $photo->updateCroppedImage($this->getRequestParameter('crop'));

            return $this->renderText( get_partial('editProfile/photo_slot', array('photo' => $photo)) );
        }

        return sfView::NONE;
    }

    public function executeRotatePhoto()
    {
        sfLoader::loadHelpers(array('Partial'));

        if ($this->getRequestParameter('photo_id') && $photo = MemberPhotoPeer::retrieveByPK($this->getRequestParameter('photo_id'))) {
            $photo->updateRotatedImage($this->getRequestParameter('deg'));

            return $this->renderText( get_partial('editProfile/photo_slot', array('photo' => $photo)) );
        }

        return sfView::NONE;
    }

}
