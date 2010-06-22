<?php use_helper('dtForm', 'I18N') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('content/searchReverse', 'class=form') ?>
    <?php echo input_hidden_tag('cat_id', $catalog->getCatId(), array('class' => 'hidden', )) ?>
    <div class="legend">Edit Reverse</div>
    <fieldset class="form_fields">
        <label for="catalog">Catalog</label>
        <var><?php echo $catalog; ?></var><br />
        
        <label for="trans_14">Instructions</label>
        <?php echo textarea_tag('trans[14]', (isset($trans[14])) ? $trans[14]->getTarget() : null, array('cols' => 40, 'rows' => 5)) ?><br />
        
        <label for="search_rows_reverse">Display Rows</label>
        <?php echo input_tag('search_rows_reverse', sfConfig::get('app_settings_search_rows_reverse'), array('class' => 'mini')) ?><br />
    </fieldset>
    
    <fieldset class="actions">
        <?php echo button_to('Cancel', 'content/searchpages?cancel=1')  . submit_tag('Save', 'class=button') ?>
    </fieldset>
</form>
<?php include_component('content', 'bottomMenu', array('url' => 'content/searchReverse')); ?>