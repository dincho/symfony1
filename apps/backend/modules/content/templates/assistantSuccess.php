<?php use_helper('dtForm', 'I18N') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('content/assistant', 'class=form') ?>
    <?php echo input_hidden_tag('cat_id', $catalog->getCatId(), array('class' => 'hidden')); ?>
    <div class="legend">Edit Online Assistant</div>
<?php if( $photo ): ?>
    <?php echo image_tag( ($photo->getImageUrlPath('cropped', '70x105')) ? $photo->getImageUrlPath('cropped', '70x105') : $photo->getImageUrlPath('file', '70x105'), array('class' => 'float-right')) ?>
<?php endif; ?>    
    <fieldset class="form_fields">
        <label for="catalog">Catalog</label>
        <var><?php echo $catalog; ?></var><br /><br />
        
        <label>Request Title</label><?php echo input_tag('trans[138]', (isset($trans[138])) ? $trans[138]->getTarget() : null) ?><br />
        <label>Request Headline</label><?php echo textarea_tag('trans[139]', (isset($trans[139])) ? $trans[139]->getTarget() : null, array('cols' => 70, 'rows' => 3)) ?><br />
        <label>Request Content</label><?php echo textarea_tag('trans[140]', (isset($trans[140])) ? $trans[140]->getTarget() : null, array('cols' => 70, 'rows' => 3)) ?><br />
        
        <label>Response Title</label><?php echo input_tag('trans[141]', (isset($trans[141])) ? $trans[141]->getTarget() : null) ?><br />
        <label>Response Content</label><?php echo textarea_tag('trans[142]', (isset($trans[142])) ? $trans[142]->getTarget() : null, array('cols' => 70, 'rows' => 3)) ?><br />
        
    </fieldset>
    
    <fieldset class="actions">
        <?php echo button_to('Cancel', 'content/assistant?cancel=1&cat_id=1')  . submit_tag('Save', 'class=button') ?>
    </fieldset>
</form>
<?php include_component('content', 'bottomMenu', array('url' => 'content/assistant')); ?>
