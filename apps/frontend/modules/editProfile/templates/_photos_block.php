<?php use_helper('Javascript'); ?>

<div class="photos" id="<?php echo $id; ?>">
    <?php if( $id == 'public_photos' ): ?>
        <label id="main_photo"><?php echo __('Main Photo'); ?></label>
    <?php endif; ?>
    
    <?php for($i=0; $i<$num_containers; $i++): ?>
        <?php $container_id = $id . '_container_' . $i; ?>
        <div class="photo_container" id="<?php echo $container_id; ?>"
             style="background-image: url('<?php echo $container_bg_image; ?>')">
            <?php if( isset($photos[$i]) ): ?>
                <?php include_partial('editProfile/photo_slot', array('photo' => $photos[$i])); ?>
            <?php endif; ?>
            
        </div>
        <?php echo drop_receiving_element($container_id, array(
                'accept' => 'photo',
                'hoverclass' => 'drop_hover',
                'script' => true,
                'onDrop' => 'moveElement'
            )); ?>
    <?php endfor; ?>
</div>

<br class="clear" />

<div class="upload_photos">
    <a class="fileinput-button button"><?php echo $upload_button_title; ?>
        <input id="btn_upload_<?php echo $id; ?>" type="file" name="Filedata" data-url="<?php echo $upload_url; ?>" multiple/>
    </a>
</div>

<script type="text/javascript">
    initFileUploads('<?php echo $id; ?>', {
        generalErrorMsg: '<?php echo __('The file upload was attempted but the server failed to handle it'); ?>',
        maxSizeErrorMsg: '<?php echo __('Max image size is 3MB'); ?>',
        typeErrorMsg: '<?php echo __('Please select correct file type'); ?>',
        maxNumberOfFilesMsg: "<?php echo __($upload_limit_error); ?>"
    });
</script>
