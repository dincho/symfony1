<?php use_helper('Javascript'); ?>
<?php include_component('system', 'formErrors') ?>

<script type="text/javascript" charset="utf-8">
    var photo_handler_url = '<?php echo url_for('editProfile/ajaxPhotoHandler?member_id=' . $member->getId()); ?>';
    var move_photo_error_url = '<?php echo url_for('editProfile/movePhotoError?member_id=' . $member->getId()); ?>';
    var photo_crop_url = '<?php echo url_for('editProfile/cropPhoto?member_id=' . $member->getId()); ?>';
</script>

<?php echo button_to('Send Email', 'feedback/compose?mail_to=' . $member->getEmail(), 'class=float-right') ?>
<?php include_partial('members/profile_pager', array('member' => $member)); ?>
<br /><br />


<div class="legend">Photos</div>
<?php include_partial('members/subMenu', array('member_id' => $member->getId(), 'class' => 'top')); ?>



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
                                                          'upload_button_title' => 'Upload getSubscriptionDetails Photos',
                                                          'file_upload_limit' => ($member->getSubscriptionDetails()->getPostPrivatePhotos() - count($private_photos)), 
                                                          'container_bg_image' => '/images/no_photo/'. $member->getSex() . '/x100x100.jpg', )); ?>
                                                          
        <p class="note float-right"><?php echo strtr('Note: You can upload up to %MAX_PHOTOS% private photos', array('%MAX_PHOTOS%' => $member->getSubscriptionDetails()->getPostPrivatePhotos())) ?></p>

        <br class="clear" />
    <?php endif; ?>
</div>

<script type="text/javascript" charset="utf-8">
    var cropper = null;

    function show_crop_area(photo_id, img_src)
    {
        var photo_el = "photo_" + photo_id;
        //remove old cropper if any
        if( cropper ) 
        {
            // console.log("cropper.previewWrap: ", cropper.previewWrap);
            
            $('imgCrop_crop_image').remove();
            cropper.previewWrap.removeClassName( 'imgCrop_previewWrap' );
            cropper.previewWrap.removeAttribute('style');
            cropper.remove();
            cropper = null;
        }
        
        //set the image and show the crop_area
        $('crop_area').down('#crop_image').src = img_src;
        $('crop_area').show();

        //this should be done after the image is loaded
        cropper = new Cropper.ImgWithPreview( 
              'crop_image',
              { 
                minWidth: 100, 
                minHeight: 100,
                ratioDim: { x: 100, y: 100 },
                displayOnInit: true, 
                previewWrap: $(photo_el).down('.img'),
                pd_photo_id: photo_id
              } 
            );
    }
        
    function remove_crop_area()
    {
        cropper.previewWrap.removeClassName( 'imgCrop_previewWrap' );
        cropper.previewWrap.removeAttribute('style');        
        cropper.remove();
        cropper = null;
        
        if($('imgCrop_crop_image')) $('imgCrop_crop_image').remove();
        $('crop_image').src = null;
        $('crop_area').hide();
    }
    
    function crop()
    {
        var params = 'photo_id=' + cropper.options.pd_photo_id + '&crop[x1]=' + cropper.areaCoords.x1 + '&crop[y1]=' + cropper.areaCoords.y1 + '&crop[x2]=' + cropper.areaCoords.x2 + '&crop[y2]=' + cropper.areaCoords.y2;
        params += '&crop[width]=' + cropper.calcW() + '&crop[height]=' + cropper.calcH();
        
        var photo_container = $('photo_' + cropper.options.pd_photo_id).parentNode;
        photo_container.update('<img src="/images/ajax-loader-bg-3D3D3D.gif" />');
        new Ajax.Updater(photo_container, photo_crop_url, {asynchronous:true, evalScripts:true, parameters:params});
        remove_crop_area();
    }
    
    Event.observe(window, 'load', function() {
      new Draggable('crop_area', {});
    });
    
</script>

<div id="crop_area" style="display: none;">
    <img id="crop_image" />
    <?php echo button_to_function('Cancel', 'remove_crop_area()') ?>
    <?php echo button_to_function('Crop', 'crop()') ?>
</div>
