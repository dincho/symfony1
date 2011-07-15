<?php echo form_tag('editProfile/testUploadPhoto', array('multipart' => true)) ?>
        <?php echo input_file_tag('Filedata'); ?><br />
        <?php echo submit_tag(__('Upload')); ?>
</form>
