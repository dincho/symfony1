<?php use_helper('dtForm', 'I18N') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('content/regReg', 'class=form') ?>
    <?php echo input_hidden_tag('cat_id', $catalog->getCatId(), array('class' => 'hidden', )) ?>
    <div class="legend">Edit Registration</div>
    <fieldset class="form_fields">
        <label for="catalog">Catalog</label>
        <var><?php echo $catalog; ?></var><br />
        
        <label for="trans_32">Headline</label>
        <?php echo textarea_tag('trans[32]', (isset($trans[32])) ? $trans[32]->getTarget() : null, array('cols' => 40, 'rows' => 3)) ?><br />
        
        <label for="trans_33">Instruction</label>
        <?php echo textarea_tag('trans[33]', (isset($trans[33])) ? $trans[33]->getTarget() : null, array('cols' => 40, 'rows' => 5)) ?><br />
        
        <label for="trans_35">Note</label>
        <?php echo textarea_tag('trans[35]', (isset($trans[35])) ? $trans[35]->getTarget() : null, array('cols' => 40, 'rows' => 3)) ?><br />
        
        <label for="trans_34">Notice</label>
        <?php echo textarea_tag('trans[34]', (isset($trans[34])) ? $trans[34]->getTarget() : null, array('cols' => 40, 'rows' => 3)) ?><br />
        
    </fieldset>
    
    <fieldset class="form_fields error_msgs_fields">
        <label>Error Messages</label>
        <?php echo input_tag('trans[36]', (isset($trans[36])) ? $trans[36]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[37]', (isset($trans[37])) ? $trans[37]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[38]', (isset($trans[38])) ? $trans[38]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[39]', (isset($trans[39])) ? $trans[39]->getTarget() : null) ?><br />
    </fieldset>
        
    <fieldset class="actions">
        <?php echo button_to('Cancel', 'content/regpages?cancel=1')  . submit_tag('Save', 'class=button') ?>
    </fieldset>
</form>
<?php include_component('content', 'bottomMenu', array('url' => 'content/regReg')); ?>