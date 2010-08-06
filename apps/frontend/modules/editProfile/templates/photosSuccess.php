<?php use_helper('Javascript'); ?>

<?php echo __('You may change your photos here') ?><br />
<span><?php echo __('Make changes and click Save on the bottom of the page.') ?></span><br /><br />
<?php echo __('You may upload any size of photo - we will shrink it to 700x700 pixels maximum; your high quality will be preserved.') ?><br />
<?php echo __('Use these formats only: jpg, png and gif.') ?><br /><br />
        
<script type="text/javascript" charset="utf-8">
    var photo_handler_url = '<?php echo url_for('editProfile/ajaxPhotoHandler'); ?>';
    var move_photo_error_url = '<?php echo url_for('editProfile/movePhotoError'); ?>';
</script>

    <p class="note float-right"><?php echo __('Note: You can upload up to %MAX_PHOTOS% public photos', array('%MAX_PHOTOS%' => $member->getSubscription()->getPostPhotos())) ?></p>
    <h3><?php echo __('Public Photos'); ?></h3><hr />
    
    <?php include_partial('editProfile/photos_block', array('id' => 'public_photos', 
                                                      'upload_url' => url_for('editProfile/uploadPhoto?block_id=public_photos'),
                                                      'photos' => $public_photos, 
                                                      'num_containers' => $member->getSubscription()->getPostPhotos(),
                                                      'member' => $member,
                                                      'upload_button_title' => __('Upload Public Photos'),
                                                      'file_upload_limit' => ($member->getSubscription()->getPostPhotos() - count($public_photos)), 
                                                      'container_bg_image' => '/images/no_photo/'. $sf_user->getProfile()->getSex() . '/x100x100.jpg', )); ?>
    
    <p class="photo_authenticity float-right">
        <?php echo link_to(($member->hasAuthPhoto()) ? __('Update Your Verification Photo') : __('Verify authenticity'), 'editProfile/photoAuthenticity', array('class' => 'sec_link')); ?>
    </p>
    <br class="clear" />
    
    <?php if( $member->getSubscription()->getCanPostPrivatePhoto() && $member->getSubscription()->getPostPrivatePhotos() > 0 ): ?>
        <p class="note float-right"><?php echo __('Note: You can upload up to %MAX_PHOTOS% private photos', array('%MAX_PHOTOS%' => $member->getSubscription()->getPostPrivatePhotos())) ?></p>
        <h3><?php echo __('Private Photos'); ?></h3><hr />
        <?php include_partial('editProfile/photos_block', array('id' => 'private_photos', 
                                                          'upload_url' => url_for('editProfile/uploadPhoto?block_id=private_photos'),
                                                          'photos' => $private_photos, 
                                                          'num_containers' => $member->getSubscription()->getPostPrivatePhotos(), 
                                                          'member' => $member,
                                                          'upload_button_title' => __('Upload Private Photos'),
                                                          'file_upload_limit' => ($member->getSubscription()->getPostPrivatePhotos() - count($private_photos)), 
                                                          'container_bg_image' => '/images/no_photo/'. $sf_user->getProfile()->getSex() . '/x100x100.jpg', )); ?>
        <br class="clear" />
    <?php endif; ?>
    
    <br /><br /><?php echo link_to(__('Return to dashboard'), 'dashboard/index', array('class' => 'sec_link_small')) ?><br />

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>
