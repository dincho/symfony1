<?php echo __('You may change your photos here') ?><br />
<span><?php echo __('Make changes and click Save on the bottom of the page.') ?></span><br />
<?php echo __('You may upload any size of photo - we will shrink it to 700x700 pixels maximum; your high quality will be preserved.') ?>
<?php echo __('Use these formats only: jpg, png and gif.') ?><br />
        
<script type="text/javascript" charset="utf-8">
    var photo_handler_url = '<?php echo url_for('editProfile/ajaxPhotoHandler'); ?>';
</script>

<?php $subscription = $member->getSubscriptionDetails(); ?>

<p class="note float-right"><?php echo __('Note: You can upload up to %MAX_PHOTOS% public photos', array('%MAX_PHOTOS%' => $subscription->getPostPhotos())) ?></p>
<h3><?php echo __('Public Photos'); ?></h3><hr />

<?php include_partial('editProfile/photos_block',
                      array(
                            'id' => 'public_photos', 
                            'upload_url' => url_for('editProfile/uploadPhoto?block_id=public_photos'),
                            'photos' => $public_photos, 
                            'num_containers' => $subscription->getPostPhotos(),
                            'member' => $member,
                            'upload_button_title' => __('Upload Public Photos'),
                            'file_upload_limit' => ($subscription->getPostPhotos() - count($public_photos)), 
                            'container_bg_image' => '/images/no_photo/'. $sf_user->getProfile()->getSex() . '/x100x100.jpg'
                      )
); ?>

<p class="photo_authenticity float-right">
    <?php echo link_to(($member->hasAuthPhoto()) ? __('Update Your Verification Photo') : __('Verify authenticity'), '@verify_photo', array('class' => 'sec_link')); ?>
</p>
<br class="clear" />

<?php if( $subscription->getCanPostPrivatePhoto() && $subscription->getPostPrivatePhotos() > 0 ): ?>
    <p class="note float-right"><?php echo __('Note: You can upload up to %MAX_PHOTOS% private photos', array('%MAX_PHOTOS%' => $subscription->getPostPrivatePhotos())) ?></p>
    <h3><?php echo __('Private Photos'); ?></h3><hr />
    <?php include_partial('editProfile/photos_block', 
                          array(
                                'id' => 'private_photos', 
                                'upload_url' => url_for('editProfile/uploadPhoto?block_id=private_photos'),
                                'photos' => $private_photos, 
                                'num_containers' => $subscription->getPostPrivatePhotos(), 
                                'member' => $member,
                                'upload_button_title' => __('Upload Private Photos'),
                                'file_upload_limit' => ($subscription->getPostPrivatePhotos() - count($private_photos)), 
                                'container_bg_image' => '/images/no_photo/'. $sf_user->getProfile()->getSex() . '/x100x100.jpg',
                          )
    ); ?>
    <br class="clear" />
<?php endif; ?>

<br /><br /><?php echo link_to(__('Return to dashboard'), 'dashboard/index', array('class' => 'sec_link_small')) ?><br />

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>

<script type="text/javascript" charset="utf-8">
    var photo_rotate_url = '<?php echo url_for('editProfile/rotatePhoto?member_id=' . $member->getId()); ?>';
    function rotate(photo_id, deg)
    {
        var params = 'deg=' + deg + '&photo_id=' + photo_id;
        var photo_container = $('photo_' + photo_id).parentNode;
        photo_container.update('<img src="/images/ajax-loader-bg-3D3D3D.gif" />');
        new Ajax.Updater(photo_container, photo_rotate_url, {asynchronous:true, evalScripts:true, parameters:params});
    }
</script>
