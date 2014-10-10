<?php use_helper('Javascript'); ?>
<?php include_component('system', 'formErrors') ?>
<?php include_component('members', 'profilePager', array('member' => $member)); ?>

<script type="text/javascript" charset="utf-8">
    var photo_handler_url = '<?php echo url_for('editProfile/ajaxPhotoHandler?member_id=' . $member->getId()); ?>';
</script>

<div class="legend">Photos</div>
<?php include_partial('members/subMenu', array('member' => $member, 'class' => 'top')); ?>

<br />
<div>

    <h3>Public Photos</h3><hr />

    <?php include_partial('editProfile/photos_block', array('id' => 'public_photos',
                                                      'upload_url' => url_for('editProfile/uploadPhoto?block_id=public_photos&member_id=' . $member->getId()),
                                                      'photos' => $public_photos,
                                                      'num_containers' => $member->getSubscriptionDetails()->getPostPhotos(),
                                                      'member' => $member,
                                                      'upload_button_title' => 'Upload Public Photos',
                                                      'file_upload_limit' => ($member->getSubscriptionDetails()->getPostPhotos() - count($public_photos)),
                                                      'container_bg_image' => '/images/no_photo/'. $member->getSex() . '/x100x100.jpg', )); ?>

    <p class="note float-right"><?php echo strtr('Note: You can upload up to %MAX_PHOTOS% public photos', array('%MAX_PHOTOS%' => $member->getSubscriptionDetails()->getPostPhotos())) ?></p>

    <br class="clear" />

    <?php if( $member->getSubscriptionDetails()->getCanPostPrivatePhoto() && $member->getSubscriptionDetails()->getPostPrivatePhotos() > 0 ): ?>

        <h3>Private Photos</h3><hr />
        <?php include_partial('editProfile/photos_block', array('id' => 'private_photos',
                                                          'upload_url' => url_for('editProfile/uploadPhoto?block_id=private_photos&member_id=' . $member->getId()),
                                                          'photos' => $private_photos,
                                                          'num_containers' => $member->getSubscriptionDetails()->getPostPrivatePhotos(),
                                                          'member' => $member,
                                                          'upload_button_title' => 'Upload Photos',
                                                          'file_upload_limit' => ($member->getSubscriptionDetails()->getPostPrivatePhotos() - count($private_photos)),
                                                          'container_bg_image' => '/images/no_photo/'. $member->getSex() . '/x100x100.jpg', )); ?>

        <p class="note float-right"><?php echo strtr('Note: You can upload up to %MAX_PHOTOS% private photos', array('%MAX_PHOTOS%' => $member->getSubscriptionDetails()->getPostPrivatePhotos())) ?></p>

        <br class="clear" />
    <?php endif; ?>
</div>

<div id="crop_area" style="display: none;">
    <div id="crop_img_wrap">
        <div id="crop_actions">
            <div id="crop_preview"></div>
            <?php echo button_to_function(
                'Crop',
                'crop("' . url_for('editProfile/cropPhoto?member_id=' . $member->getId()) . '")'
            ) ?>
            <?php echo button_to_function('Cancel', 'remove_crop_area()') ?>
        </div>
    </div>
</div>
