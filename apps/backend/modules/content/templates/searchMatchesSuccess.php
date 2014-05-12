<?php use_helper('dtForm', 'I18N') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('content/searchMatches', 'class=form') ?>
    <?php echo input_hidden_tag('cat_id', $catalog->getCatId(), array('class' => 'hidden', )) ?>
    <div class="legend">Edit Matches</div>
    <fieldset class="form_fields">
        <label for="catalog">Catalog</label>
        <var><?php echo $catalog; ?></var><br />

        <label for="trans_15">Instructions</label>
        <?php echo textarea_tag('trans[15]', (isset($trans[15])) ? $trans[15]->getTarget() : null, array('cols' => 40, 'rows' => 5)) ?><br />

        <label for="search_rows_matches">Display Rows</label>
        <?php echo input_tag('search_rows_matches', sfSettingPeer::valueForCatalogAndName($catalog, 'search_rows_matches'), array('class' => 'mini')) ?><br />
    </fieldset>

    <fieldset class="actions">
        <?php echo button_to('Cancel', 'content/searchpages?cancel=1')  . submit_tag('Save', 'class=button') ?>
    </fieldset>
    <?php include_component('content', 'bottomMenu', array('url' => 'content/searchMatches', 'multiCatalogs' => true, 'catId' => $catalog->getCatId())); ?>
</form>
