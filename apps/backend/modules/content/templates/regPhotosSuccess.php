<?php use_helper('dtForm', 'I18N') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('content/regPhotos', 'class=form') ?>
    <?php echo input_hidden_tag('cat_id', $catalog->getCatId(), array('class' => 'hidden', )) ?>
    <div class="legend">Edit Essay</div>
    <fieldset class="form_fields">
        <label for="catalog">Catalog</label>
        <var><?php echo $catalog; ?></var><br />

        <label for="trans_55">Headline</label>
        <?php echo textarea_tag('trans[55]', (isset($trans[55])) ? $trans[55]->getTarget() : null, array('cols' => 40, 'rows' => 3)) ?><br />

        <label for="trans_56">Instruction</label>
        <?php echo textarea_tag('trans[56]', (isset($trans[56])) ? $trans[56]->getTarget() : null, array('cols' => 40, 'rows' => 3)) ?><br />

        <label for="trans_57">Note</label>
        <?php echo textarea_tag('trans[57]', (isset($trans[57])) ? $trans[57]->getTarget() : null, array('cols' => 40, 'rows' => 3)) ?><br />

        <label for="trans_58">Upload Note</label>
        <?php echo textarea_tag('trans[58]', (isset($trans[58])) ? $trans[58]->getTarget() : null, array('cols' => 40, 'rows' => 3)) ?><br />
    </fieldset>

    <fieldset class="form_fields error_msgs_fields">
        <label>Error Messages</label>
        <?php echo input_tag('trans[59]', (isset($trans[59])) ? $trans[59]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[60]', (isset($trans[60])) ? $trans[60]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[61]', (isset($trans[61])) ? $trans[61]->getTarget() : null) ?><br />
    </fieldset>

    <fieldset class="actions">
        <?php echo button_to('Cancel', 'content/regpages?cancel=1')  . submit_tag('Save', 'class=button') ?>
    </fieldset>
    <?php include_component('content', 'bottomMenu', array('url' => 'content/regPhotos', 'multiCatalogs' => true, 'catId' => $catalog->getCatId())); ?>
</form>
