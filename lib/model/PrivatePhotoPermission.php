<?php

/**
 * Subclass for representing a row from the 'private_photo_permission' table.
 *
 * 
 *
 * @package lib.model
 */ 
class PrivatePhotoPermission extends BasePrivatePhotoPermission
{
    public function save($con = null)
    {
        $ret = parent::save($con);
        
        //notification hook
        $grantee = $this->getMemberRelatedByProfileId();
        if( $grantee->getEmailNotifications() === 0 ) Events::triggerAccountActivityPrivatePhotosGranted($grantee, $this->getMemberRelatedByMemberId());
        
        return $ret;
    }
}
