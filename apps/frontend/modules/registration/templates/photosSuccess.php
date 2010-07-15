<?php use_helper('Javascript'); ?>

<script type="text/javascript" charset="utf-8">
    var photo_handler_url = '<?php echo url_for('registration/ajaxPhotoHandler'); ?>';
    var move_photo_error_url = '<?php echo url_for('registration/movePhotoError'); ?>';
</script>

<?php echo __('Photos instructions') ?>
<?php echo __('Photos note') ?>
        
<p class="note float-right"><?php echo __('Note: You can upload up to %MAX_PHOTOS% public photos', array('%MAX_PHOTOS%' => $member->getSubscription()->getPostPhotos())) ?></p>
<h3>Public Photos</h3><hr />

<?php include_partial('editProfile/photos_block', array('id' => 'public_photos', 
                                                  'upload_url' => url_for('registration/uploadPhoto?block_id=public_photos'),
                                                  'photos' => $public_photos, 
                                                  'num_containers' => $member->getSubscription()->getPostPhotos(),
                                                  'member' => $member,
                                                  'upload_button_title' => __('Upload Public Photos'),
                                                  'file_upload_limit' => ($member->getSubscription()->getPostPhotos() - count($public_photos)), 
                                                  'container_bg_image' => '/images/no_photo/'. $sf_user->getProfile()->getSex() . '/x100x100.jpg', )); ?>

<br class="clear" />

<?php if( $member->getSubscription()->getCanPostPrivatePhoto() && $member->getSubscription()->getPostPrivatePhotos() > 0 ): ?>
    <p class="note float-right"><?php echo __('Note: You can upload up to %MAX_PHOTOS% private photos', array('%MAX_PHOTOS%' => $member->getSubscription()->getPostPrivatePhotos())) ?></p>
    <h3>Private Photos</h3><hr />
    <?php include_partial('editProfile/photos_block', array('id' => 'private_photos', 
                                                      'upload_url' => url_for('registration/uploadPhoto?block_id=private_photos'),
                                                      'photos' => $private_photos, 
                                                      'num_containers' => $member->getSubscription()->getPostPrivatePhotos(), 
                                                      'member' => $member,
                                                      'upload_button_title' => __('Upload Private Photos'),
                                                      'file_upload_limit' => ($member->getSubscription()->getPostPrivatePhotos() - count($private_photos)), 
                                                      'container_bg_image' => '/images/no_photo/'. $sf_user->getProfile()->getSex() . '/x100x100.jpg', )); ?>
    <br class="clear" />
<?php endif; ?>

<?php echo __('Photos note') ?>

<br /><br /><?php echo link_to(__('Finish registration'), 'registration/photos?skip=1', array('class' => 'sec_link_small')) ?><br />


<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>