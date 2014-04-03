<?php use_helper('dtForm', 'I18N') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('content/regEssay', 'class=form') ?>
    <?php echo input_hidden_tag('cat_id', $catalog->getCatId(), array('class' => 'hidden', )) ?>
    <div class="legend">Edit Essay</div>
    <fieldset class="form_fields">
        <label for="catalog">Catalog</label>
        <var><?php echo $catalog; ?></var><br />
        
        <label for="trans_45">Headline</label>
        <?php echo textarea_tag('trans[45]', (isset($trans[45])) ? $trans[45]->getTarget() : null, array('cols' => 40, 'rows' => 3)) ?><br />
        
        <label for="trans_46">Instruction</label>
        <?php echo textarea_tag('trans[46]', (isset($trans[46])) ? $trans[46]->getTarget() : null, array('cols' => 40, 'rows' => 3)) ?><br />
        
        <label for="trans_47">Content</label>
        <?php echo textarea_tag('trans[47]', (isset($trans[47])) ? $trans[47]->getTarget() : null, array('cols' => 40, 'rows' => 5)) ?><br />
        
        <label for="trans_48">Note</label>
        <?php echo textarea_tag('trans[48]', (isset($trans[48])) ? $trans[48]->getTarget() : null, array('cols' => 40, 'rows' => 3)) ?><br />        
    </fieldset>
    
    <fieldset class="form_fields error_msgs_fields">
        <label>Error Messages</label>
        <?php echo input_tag('trans[49]', (isset($trans[49])) ? $trans[49]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[50]', (isset($trans[50])) ? $trans[50]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[51]', (isset($trans[51])) ? $trans[51]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[52]', (isset($trans[52])) ? $trans[52]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[53]', (isset($trans[53])) ? $trans[53]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[54]', (isset($trans[54])) ? $trans[54]->getTarget() : null) ?><br />
    </fieldset>
        
    <fieldset class="actions">
        <?php echo button_to('Cancel', 'content/regpages?cancel=1')  . submit_tag('Save', 'class=button') ?>
    </fieldset>
    <?php include_component('content', 'bottomMenu', array('url' => 'content/regEssay', 'multiCatalogs' => true, 'catId' => $catalog->getCatId())); ?>
</form>