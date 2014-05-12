<?php use_helper('dtForm', 'I18N') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('content/regSearch', 'class=form') ?>
    <?php echo input_hidden_tag('cat_id', $catalog->getCatId(), array('class' => 'hidden', )) ?>
    <div class="legend">Edit Search</div>
    <fieldset class="form_fields">
        <label for="catalog">Catalog</label>
        <var><?php echo $catalog; ?></var><br />

        <label for="trans_62">Headline</label>
        <?php echo textarea_tag('trans[62]', (isset($trans[62])) ? $trans[62]->getTarget() : null, array('cols' => 40, 'rows' => 3)) ?><br />

        <label for="trans_63">Instruction</label>
        <?php echo textarea_tag('trans[63]', (isset($trans[63])) ? $trans[63]->getTarget() : null, array('cols' => 40, 'rows' => 3)) ?><br />

    </fieldset>

    <fieldset class="form_fields error_msgs_fields">
        <label>Error Messages</label>
        <?php echo input_tag('trans[64]', (isset($trans[64])) ? $trans[64]->getTarget() : null) ?><br />
    </fieldset>

    <fieldset class="actions">
        <?php echo button_to('Cancel', 'content/regpages?cancel=1')  . submit_tag('Save', 'class=button') ?>
    </fieldset>
    <?php include_component('content', 'bottomMenu', array('url' => 'content/regSearch', 'multiCatalogs' => true, 'catId' => $catalog->getCatId())); ?>
</form>
