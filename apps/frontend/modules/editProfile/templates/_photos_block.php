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
                    // Backend Settings
                    upload_url: "<?php echo $upload_url; ?>",
                    post_params: {"PDSSID": "<?php echo session_id(); ?>"},
                    file_post_name : "Filedata",
                    
                    // File Upload Settings
                    file_size_limit : "3 MB",
                    file_types : "*.jpg; *.jpeg; *.png; *.gif",
                    file_types_description : "Photos",
                    file_upload_limit : "0",

                    // Event Handler Settings - these functions as defined in Handlers.js
                    //  The handlers are not part of SWFUpload but are part of this website and control how
                    //  my website reacts to the SWFUpload events.
                    file_queue_error_handler : fileQueueError,
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
                        file_is_too_big: "<?php echo __('File is too big.'); ?>"
                    },
                
                    // Debug Settings
                    debug: <?php echo (SF_ENVIRONMENT == 'dev') ? 'true' : 'false'; ?>
                    
                });
            });
            
            Event.observe(window, 'unload', function() {
                <?php echo $id; ?>_swfu.destroy();
            });
    </script>

    
    <input type="button" value="<?php echo $upload_button_title; ?>" id="btn_upload_<?php echo $id; ?>" class="button" />
    <span id="<?php echo $id; ?>_spanButtonPlaceholder"></span>
</div>

