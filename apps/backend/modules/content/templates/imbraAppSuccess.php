<?php use_helper('dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('content/imbraApp', 'class=form') ?>
    <?php echo input_hidden_tag('cat_id', $catalog->getCatId(), array('class' => 'hidden')); ?>
    <div class="legend">Edit IMBRA Application Template</div>
    <fieldset class="form_fields">
        <label for="trans_65">Headline</label>
        <?php echo textarea_tag('trans[65]', (isset($trans[65])) ? $trans[65]->getTarget() : null, array('cols' => 40, 'rows' => 3)) ?><br />
        
        <label for="trans_66">Instructions</label>
        <?php echo textarea_tag('trans[66]', (isset($trans[66])) ? $trans[66]->getTarget() : null, array('cols' => 50, 'rows' => 5)) ?><br />
        
        <label for="trans_67">Instructions (edit)</label>
        <?php echo textarea_tag('trans[67]', (isset($trans[67])) ? $trans[67]->getTarget() : null, array('cols' => 50, 'rows' => 5)) ?><br />
        
        <label for="trans_68">Notice</label>
        <?php echo textarea_tag('trans[68]', (isset($trans[68])) ? $trans[68]->getTarget() : null, array('cols' => 50, 'rows' => 5)) ?><br />
        
        <label for="trans_69">Note</label>
        <?php echo textarea_tag('trans[69]', (isset($trans[69])) ? $trans[69]->getTarget() : null, array('cols' => 50, 'rows' => 5)) ?><br />
        
    </fieldset>
    
    <fieldset class="form_fields error_msgs_fields">
        <label>Error Messages</label>
        <?php echo input_tag('trans[70]', (isset($trans[70])) ? $trans[70]->getTarget() : null) ?><br />
    </fieldset>
        
    <fieldset class="actions">
        <?php echo button_to('Cancel', 'content/imbrapages?cancel=1&cat_id=1')  . submit_tag('Save', 'class=button') ?>
    </fieldset>
</form>
<?php include_component('content', 'bottomMenu', array('url' => 'content/imbraApp')); ?>
