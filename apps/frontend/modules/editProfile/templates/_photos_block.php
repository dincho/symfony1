<div class="photos" id="<?php echo $id; ?>">
    <?php if( $id == 'public_photos' ): ?>
        <label id="main_photo"><?php echo __('Main Photo'); ?></label>
    <?php endif; ?>
    
    <?php for($i=0; $i<$num_containers; $i++): ?>
        <?php $container_id = $id . '_container_' . $i; ?>
        <div class="photo_container" id="<?php echo $container_id; ?>" style="background-image: url('<?php echo $container_bg_image; ?>')">
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
    <script type="text/javascript">
                
            var <?php echo $id; ?>_swfu;
            Event.observe(window, 'load', function() {
                <?php echo $id; ?>_swfu = new SWFUpload({
                    //SWFObject plugin settings
                    minimum_flash_version: "9.0.28",
                    // swfupload_pre_load_handler: swfuploadPreLoad,
                    swfupload_load_failed_handler: swfuploadLoadFailed,
                                        
                    // Backend Settings
                    upload_url: "<?php echo $upload_url; ?>",
                    post_params: {"PDSSID": "<?php echo session_id(); ?>"},
                    file_post_name : "Filedata",
                    
                    // File Upload Settings
                    file_size_limit : "3 MB",
                    file_types : "*.jpg; *.jpeg; *.png; *.gif",
                    file_types_description : "Photos",
                    file_upload_limit : "0",

                    // Event Handler Settings
                    swfupload_loaded_handler : swfUploadLoaded,
                    file_queue_error_handler : fileQueueError,
                    file_dialog_start_handler : fileDialogStart,
                    file_dialog_complete_handler : fileDialogComplete,
                    upload_progress_handler : uploadProgress,
                    upload_error_handler : uploadError,
                    upload_success_handler : uploadSuccess,
                    upload_complete_handler : uploadComplete,

                    // Button Settings
                    button_image_url: "/images/empty_pixel.png",
                    button_placeholder_id : "<?php echo $id; ?>_spanButtonPlaceholder",
                    button_width: 142,
                    button_height: 28,
                    button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
                    button_cursor: SWFUpload.CURSOR.HAND,
                
                    // Flash Settings
                    flash_url : "/flash/swfupload.swf",
                    prevent_swf_caching: <?php echo (SF_ENVIRONMENT == 'dev') ? 'true' : 'false'; ?>,

                    custom_settings : {
                        upload_target : "<?php echo $id; ?>_fileProgressContainer",
                        block : $("<?php echo $id; ?>"),
                        errors: {
                            queued_too_many_files: "<?php echo __('You have attempted to queue too many photos.'); ?>",
                            file_is_too_big: "<?php echo __('Max image size is 3MB'); ?>",
                            file_transfer_error: "<?php echo __('File transfer error'); ?>",
                            load: "<?php echo __('You need Flash plugin installed to upload photos.'); ?>"
                        }
                        
                    },
                
                    // Debug Settings
                    debug: <?php echo (SF_ENVIRONMENT == 'dev') ? 'true' : 'false'; ?>
                    
                });
            });
            
            Event.observe(window, 'unload', function() {
                <?php echo $id; ?>_swfu.destroy();
            });
    </script>
    
    <input type="button" value="<?php echo $upload_button_title; ?>" id="btn_upload_<?php echo $id; ?>" class="button" style="display: none;" />
    <span id="<?php echo $id; ?>_spanButtonPlaceholder"></span>
</div>

