<?php use_helper('Object', 'Window') ?>
<div id="photos">

    <?php include_partial('system/pager', array('pager' => $pager, 'route' => 'photos/list')); ?><br />
    
    <?php foreach($pager->getResults() as $member): ?>
        <div class="photos_headline"><b><?php echo $member->getUsername() ?></b>
            <span>
                <?php echo link_to('Edit', 'members/editPhotos?id=' . $member->getId()) ?>&nbsp;|&nbsp;
                <?php echo link_to('View', $member->getFrontendProfileUrl(), array('popup' => true)) ?>
            </span>
            <b>Public Search:</b><?php echo checkbox_tag('public_search[]', $member->getId(), $member->getPublicSearch(), 
                                                        array('class' => 'checkbox', 'disabled' => $member->getPrivateDating(), 
                                                        'onchange' => "new Ajax.Request('". url_for('ajax/UpdatePublicSearch?member_id=' . $member->getId()) ."', {method: 'get'});")) ?>
            <span>Status: <?php echo $member->getMemberStatus(); ?></span>
        </div>
        <fieldset class="form_fields">
        <?php $photos = $member->getPublicMemberPhotos(); $cnt_photos = count($photos); ?>
        <?php $i=1; foreach($photos as $photo): ?>
            <div class="photo_slot" id="<?php echo 'photo_' . $photo->getId(); ?>">
                <div <?php if( $photo->isMain() ) echo 'class="selected_photo"'; ?>>
                    <?php echo link_to(image_tag( ($photo->getImageFilename('cropped')) ? $photo->getImageUrlPath('cropped', '100x100') : $photo->getImageUrlPath('file', '100x100') ), 'members/editPhotos?id=' . $member->getId() . '&photo_id=' . $photo->getId()) ?><br />
                </div>
                
                <?php echo link_to_remote('Delete Photo', array('url' => 'editProfile/confirmDeletePhoto?simple_delete=1&id=' . $photo->getId() . '&member_id=' . $member->getId(),
                                                                         'update'  => 'msg_container',
                                                                        )) ?><br />
                                                                           
                <?php echo link_to_unless($member->getPrivateDating(), 'Add to homepage', 'photos/addMemberPhotoToHomepage?photo_id=' . $photo->getId()); ?>

                <?php include_partial('editProfile/photo_status', array('photo' => $photo)); ?>

                <?php echo ($photo->getPhotoExifInfos())?link_to('EXIF', 'photos/exifInfo?photoId=' . $photo->getId(), 
                        array(  'popup' => array('popupWindow', 'toolbar=no,status=no,scrollbars=yes,location=no,top=200,width=400,height=600'))):"" ?>               
                

            </div>
            <?php if( $i++ % 6 == 0 && $i <= $cnt_photos): ?>
                </fieldset>
                <fieldset class="form_fields">
            <?php endif; ?>             
        <?php endforeach; ?>
        <?php $photos = $member->getPrivateMemberPhotos(); $cnt_photos = count($photos); ?>
        <?php $i=1; foreach($photos as $photo): ?>
            <div class="private_photo_slot" id="<?php echo 'photo_' . $photo->getId(); ?>">
                <div <?php if( $photo->isMain() ) echo 'class="selected_photo"'; ?>>
                    <?php echo link_to(image_tag( ($photo->getImageFilename('cropped')) ? $photo->getImageUrlPath('cropped', '100x100') : $photo->getImageUrlPath('file', '100x100') ), 'members/editPhotos?id=' . $member->getId() . '&photo_id=' . $photo->getId()) ?><br />
                </div>
                
                <?php echo link_to_remote('Delete Photo', array('url' => 'editProfile/confirmDeletePhoto?simple_delete=1&id=' . $photo->getId() . '&member_id=' . $member->getId(),
                                                                         'update'  => 'msg_container',
                                                                        )) ?><br />
                                                                           
                <?php echo link_to_unless($member->getPrivateDating(), 'Add to homepage', 'photos/addMemberPhotoToHomepage?photo_id=' . $photo->getId()); ?>

                <?php include_partial('editProfile/photo_status', array('photo' => $photo)); ?>

            </div>
            <?php if( $i++ % 6 == 0 && $i <= $cnt_photos): ?>
                </fieldset>
                <fieldset class="form_fields">
            <?php endif; ?>             
        <?php endforeach; ?>
        </fieldset><br />
    <?php endforeach; ?>
    <?php include_partial('system/pager', array('pager' => $pager, 'route' => 'photos/list')); ?>
</div>
