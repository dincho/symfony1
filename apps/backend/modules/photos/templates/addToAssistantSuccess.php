<?php use_helper('I18N') ?>
<?php echo image_tag( $photo->getImageUrlPath('file', '100x95'), array('class' => 'float-left') ) ?>
<br /><br /><br /><br /><br /><br /><br />

<?php echo form_tag('photos/addToAssistant') ?>
    <?php echo input_hidden_tag('photo_id', $photo->getId()) ?>
    <fieldset class="form_fields">
        <label style="width: auto">Language</label>
        <?php echo select_language_tag('catalog', $catalog, array('languages' => array('en', 'pl'))) ?><br />
    </fieldset>

    <fieldset class="actions">
        <?php echo button_to('Cancel', 'photos/stockPhotos') ?>
        <?php echo submit_tag('Next') ?>
    </fieldset>
</form>