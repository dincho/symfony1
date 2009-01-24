<?php echo form_tag('photos/upload', array('multipart' => true)) ?>
    <fieldset>
        <div class="legend">Upload Photos</div>
        <?php echo input_file_tag('new_photo') ?>
        <?php echo submit_tag('Upload') ?><br />
    </fieldset>
</form>

<br />
<?php if( isset($photo) ): ?>
    <?php echo image_tag($photo->getImageUrlPath('file', '350x350'), 'id=thePhoto') ?><br />
    
    <?php echo form_tag('photos/upload', array('class' => 'form')) ?>
    <?php echo input_hidden_tag('photo_id', $photo->getId()) ?>
    <fieldset class="form_fields">
        <?php echo radiobutton_tag('continue', 1) ?><label style="text-align: left;">Home Page</label><br />
        <?php echo radiobutton_tag('continue', 2) ?><label style="text-align: left;">Member Stories</label><br />
        <?php echo radiobutton_tag('continue', 3, true) ?><label style="text-align: left;">Stock Photos</label><br />
    </fieldset>
    <fieldset class="actions">
        <?php echo button_to('Cancel', 'photos/upload') ?>
        <?php echo submit_tag('Continue') ?>
    </fieldset>    
<?php endif; ?>

