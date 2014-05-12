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
        if ($this->getType() == 'P' && $this->getStatus() == 'A') { // grant permission
          $grantee = $this->getMemberRelatedByProfileId();
          if( $grantee->getEmailNotifications() === 0 )
            Events::triggerAccountActivityPrivatePhotosGranted($grantee, $this->getMemberRelatedByMemberId());
        } elseif ($this->getType() == 'R') { // requesrt permission
          $request_to = $this->getMemberRelatedByProfileId();
          if ( $request_to->getEmailNotifications() === 0 ) {
            Events::triggerAccountActivityPrivatePhotosRequest($request_to, $this->getMemberRelatedByMemberId());
          }
        }

        return $ret;
    }
}
