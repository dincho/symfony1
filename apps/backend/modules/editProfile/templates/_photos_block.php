<div class="photos" id="<?php echo $id; ?>">
    <?php if( $id == 'public_photos' ): ?>
        <label id="main_photo">Main Photo</label><br />
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
    <span class="fileinput-button button"><?php echo $upload_button_title; ?>
        <input id="btn_upload_<?php echo $id; ?>" type="file" name="Filedata" data-url="<?php echo $upload_url; ?>" multiple/>
    </span>
</div>

<script type="text/javascript">
    (function ($) {
        var block_id = '<?php echo $id; ?>';
        var generalErrorMsg = 'The file upload was attempted but the server failed to handle it';
        var maxSizeErrorMsg = 'Max image size is 3MB';

        initFileUploads(block_id);

        // handle displaying of error messages
        // TODO: proper error display
        $('#btn_upload_' + block_id)
            .on('fileuploadadd', function (e, data) {
                if (data.files[0].size > 3145728) {
                    $('#msg_container').append('<div id="msgs"><p class="msg_error" id="msg_error_Filedata">' + maxSizeErrorMsg + '</p></div>');
                }
            })
            .on('fileuploadfail', function () {
                $('#msg_container').append('<div id="msgs"><p class="msg_error" id="msg_error_Filedata">' + generalErrorMsg + '</p></div>');
            })
            .on('fileuploaddone', function (e, data) {
                if (data.result.status === "failed") {
                    $('#msg_container').append(data.result.messages);
                }
            });
    })(jQuery);
</script>