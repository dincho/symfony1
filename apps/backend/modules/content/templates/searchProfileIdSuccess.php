<?php use_helper('dtForm', 'I18N') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('content/searchProfileId', 'class=form') ?>
    <?php echo input_hidden_tag('cat_id', $catalog->getCatId(), array('class' => 'hidden', )) ?>
    <div class="legend">Edit Profile ID</div>
    <fieldset class="form_fields">
        <label for="catalog">Catalog</label>
        <var><?php echo $catalog; ?></var><br />
        
        <label for="trans_17">Instructions</label>
        <?php echo textarea_tag('trans[17]', (isset($trans[17])) ? $trans[17]->getTarget() : null, array('cols' => 40, 'rows' => 5)) ?><br />
    </fieldset>
    
    <fieldset class="form_fields error_msgs_fields">
        <label>Error Messages</label>
        <?php echo input_tag('trans[18]', (isset($trans[18])) ? $trans[18]->getTarget() : null) ?><br />
    </fieldset>
        
    <fieldset class="actions">
        <?php echo button_to('Cancel', 'content/searchpages?cancel=1')  . submit_tag('Save', 'class=button') ?>
    </fieldset>
</form>
<?php include_component('content', 'bottomMenu', array('url' => 'content/searchProfileId')); ?>