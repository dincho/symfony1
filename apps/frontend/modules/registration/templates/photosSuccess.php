<?php use_helper('Javascript'); ?>

<script type="text/javascript" charset="utf-8">
    var photo_handler_url = '<?php echo url_for('registration/ajaxPhotoHandler'); ?>';
</script>

<?php echo __('Photos instructions') ?>
<?php echo __('Photos note') ?>
<?php $subscription = $member->getSubscriptionDetails(); ?>
<p class="note float-right"><?php echo __(
        'Note: You can upload up to %MAX_PHOTOS% public photos',
        array('%MAX_PHOTOS%' => $subscription->getPostPhotos())
    ) ?></p>

<div class="registration_photos">
    <h3><?php echo __('Public Photos'); ?></h3>
</div>
<hr/>

<?php include_partial('editProfile/photos_block',
                      array(
                            'id' => 'public_photos',
                            'upload_url' => url_for('registration/uploadPhoto?block_id=public_photos'),
                            'photos' => $public_photos,
                            'num_containers' => $subscription->getPostPhotos(),
                            'member' => $member,
                            'upload_button_title' => __('Upload Public Photos'),
                            'file_upload_limit' => ($subscription->getPostPhotos() - count($public_photos)),
                            'container_bg_image' => '/images/no_photo/'. $sf_user->getProfile()->getSex() . '/x100x100.jpg',
                            'upload_limit_error' => sprintf('%s: For the feature that you want to use - post photo - you have reached the limit up to which you can use it with your membership. In order to post photo, please upgrade your membership.', $subscription->getTitle()),
                      )
); ?>

<br class="clear" />

<?php if( $subscription->getCanPostPrivatePhoto() && $subscription->getPostPrivatePhotos() > 0 ): ?>
    <p class="note float-right"><?php echo __('Note: You can upload up to %MAX_PHOTOS% private photos', array('%MAX_PHOTOS%' => $subscription->getPostPrivatePhotos())) ?></p>
    <h3><?php echo __('Private Photos'); ?></h3><hr />
    <?php include_partial('editProfile/photos_block',
                          array(
                                'id' => 'private_photos',
                                'upload_url' => url_for('registration/uploadPhoto?block_id=private_photos'),
                                'photos' => $private_photos,
                                'num_containers' => $subscription->getPostPrivatePhotos(),
                                'member' => $member,
                                'upload_button_title' => __('Upload Private Photos'),
                                'file_upload_limit' => ($subscription->getPostPrivatePhotos() - count($private_photos)),
                                'container_bg_image' => '/images/no_photo/'. $sf_user->getProfile()->getSex() . '/x100x100.jpg',
                                'upload_limit_error' => sprintf('%s: For the feature that you want to use - post private photo - you have reached the limit up to which you can use it with your membership. In order to post private photo, please upgrade your membership.', $subscription->getTitle()),
                          )
    ); ?>
    <br class="clear" />
<?php endif; ?>

<div class="registration_notes">
    <?php echo __('Photos note') ?>
</div>

<div class="registration_finish">
    <?php echo link_to(__('Finish registration'), 'registration/photos?skip=1', array('class' => 'button')) ?>
</div>

<br class="clear" />

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>

<div id="crop_area" style="display: none;">
    <div id="crop_img_wrap">
        <div id="crop_actions">
            <div id="crop_preview"></div>
            <?php echo button_to_function(
                'Crop',
                'crop("' . url_for('registration/cropPhoto?member_id=' . $member->getId()) . '")',
                array('class' => 'button')
            ) ?>
            <?php echo button_to_function(
                'Cancel',
                'remove_crop_area()',
                array('class' => 'button cancel')
            ) ?>
        </div>
    </div>
</div>
