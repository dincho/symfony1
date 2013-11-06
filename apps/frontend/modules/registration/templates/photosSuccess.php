<?php use_helper('Javascript'); ?>

<script type="text/javascript" charset="utf-8">
    var photo_handler_url = '<?php echo url_for('registration/ajaxPhotoHandler'); ?>';
</script>

<?php echo __('Photos instructions') ?>
<?php echo __('Photos note') ?>

<?php $subscription = $member->getSubscriptionDetails(); ?>

<p class="note float-right"><?php echo __('Note: You can upload up to %MAX_PHOTOS% public photos', array('%MAX_PHOTOS%' => $subscription->getPostPhotos())) ?></p>
<h3><?php echo __('Public Photos'); ?></h3><hr />

<?php include_partial('editProfile/photos_block', array('id' => 'public_photos', 
                                                  'upload_url' => url_for('registration/uploadPhoto?block_id=public_photos'),
                                                  'photos' => $public_photos, 
                                                  'num_containers' => $subscription->getPostPhotos(),
                                                  'member' => $member,
                                                  'upload_button_title' => __('Upload Public Photos'),
                                                  'file_upload_limit' => ($subscription->getPostPhotos() - count($public_photos)), 
                                                  'container_bg_image' => '/images/no_photo/'. $sf_user->getProfile()->getSex() . '/x100x100.jpg', )); ?>

<br class="clear" />

<?php if( $subscription->getCanPostPrivatePhoto() && $subscription->getPostPrivatePhotos() > 0 ): ?>
    <p class="note float-right"><?php echo __('Note: You can upload up to %MAX_PHOTOS% private photos', array('%MAX_PHOTOS%' => $subscription->getPostPrivatePhotos())) ?></p>
    <h3><?php echo __('Private Photos'); ?></h3><hr />
    <?php include_partial('editProfile/photos_block', array('id' => 'private_photos', 
                                                      'upload_url' => url_for('registration/uploadPhoto?block_id=private_photos'),
                                                      'photos' => $private_photos, 
                                                      'num_containers' => $subscription->getPostPrivatePhotos(), 
                                                      'member' => $member,
                                                      'upload_button_title' => __('Upload Private Photos'),
                                                      'file_upload_limit' => ($subscription->getPostPrivatePhotos() - count($private_photos)), 
                                                      'container_bg_image' => '/images/no_photo/'. $sf_user->getProfile()->getSex() . '/x100x100.jpg', )); ?>
    <br class="clear" />
<?php endif; ?>

<?php echo __('Photos note') ?>

<br /><br /><?php echo link_to(__('Finish registration'), 'registration/photos?skip=1', array('class' => 'sec_link_small')) ?><br />


<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>

<script type="text/javascript" charset="utf-8">
    var photo_rotate_url = '<?php echo url_for('registration/rotatePhoto?member_id=' . $member->getId()); ?>';
    function rotate(photo_id, deg)
    {
        var params = 'deg=' + deg + '&photo_id=' + photo_id;
        var photo_container = $('photo_' + photo_id).parentNode;
        photo_container.update('<img src="/images/ajax-loader-bg-3D3D3D.gif" />');
        new Ajax.Updater(photo_container, photo_rotate_url, {asynchronous:true, evalScripts:true, parameters:params});
    }
</script>

