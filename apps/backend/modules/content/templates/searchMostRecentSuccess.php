<?php use_helper('dtForm', 'I18N') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('content/searchMostRecent', 'class=form') ?>
    <?php echo input_hidden_tag('cat_id', $catalog->getCatId(), array('class' => 'hidden', )) ?>
    <div class="legend">Edit Most Recent</div>
    <fieldset class="form_fields">
        <label for="catalog">Catalog</label>
        <var><?php echo $catalog; ?></var><br />
        
        <label for="trans_12">Instructions</label>
        <?php echo textarea_tag('trans[12]', (isset($trans[12])) ? $trans[12]->getTarget() : null, array('cols' => 40, 'rows' => 5)) ?><br />
        
        <label for="search_rows_most_recent">Display Rows</label>
        <?php echo input_tag('search_rows_most_recent', sfSettingPeer::valueForCatalogAndName($catalog, 'search_rows_most_recent'), array('class' => 'mini')) ?><br />
    </fieldset>
    
    <fieldset class="actions">
        <?php echo button_to('Cancel', 'content/searchpages?cancel=1')  . submit_tag('Save', 'class=button') ?>
    </fieldset>
    <?php include_component('content', 'bottomMenu', array('url' => 'content/searchMostRecent', 'multiCatalogs' => true, 'catId' => $catalog->getCatId()))?>
</form>