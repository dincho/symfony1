<?php use_helper('dtForm', 'I18N') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('content/searchPublic', 'class=form') ?>
    <?php echo input_hidden_tag('cat_id', $catalog->getCatId(), array('class' => 'hidden', )) ?>
    <div class="legend">Edit Public</div>
    <fieldset class="form_fields float-left">
        <label for="catalog">Catalog</label>
        <var><?php echo $catalog; ?></var><br />
        
        <label for="trans_145">Instructions</label>
        <?php echo textarea_tag('trans[145]', (isset($trans[145])) ? $trans[145]->getTarget() : null, array('cols' => 40, 'rows' => 5)) ?><br />
        
        <label for="search_rows_public">Display Rows</label>
        <?php echo input_tag('search_rows_public', sfSettingPeer::valueForCatalogAndName($catalog, 'search_rows_public'), array('class' => 'mini')) ?><br />
    </fieldset>

    <fieldset class="form_fields float-left">

        <label for="trans_150">Title:</label>
        <?php echo input_tag('trans[150]', (isset($trans[150])) ? $trans[150]->getTarget() : null) ?><br /> 
  
        <label for="trans_151">Keywords:</label>
        <?php echo input_tag('trans[151]', (isset($trans[151])) ? $trans[151]->getTarget() : null) ?><br />

        <label for="trans_152">Description:</label>
        <?php echo textarea_tag('trans[152]', (isset($trans[152])) ? $trans[152]->getTarget() : null, 'cols=26 rows=2 ') ?><br />

    </fieldset>
    <br />
    
    <fieldset class="actions">
        <?php echo button_to('Cancel', 'content/searchpages?cancel=1')  . submit_tag('Save', 'class=button') ?>
    </fieldset>
    <?php include_component('content', 'bottomMenu', array('url' => 'content/searchPublic', 'multiCatalogs' => true, 'catId' => $catalog->getCatId())); ?>
</form>