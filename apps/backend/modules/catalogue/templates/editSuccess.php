<?php use_helper('Object', 'ObjectAdmin') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('catalogue/edit', 'class=form') ?>
    <?php echo input_hidden_tag('id', $catalog->getCatId()); ?>
  <div class="legend">Edit Catalog - <?php echo $catalog; ?></div>
  <p>Members of this catalog could see members of the following catalogs:</p>
  <fieldset class="form_fields">
    <?php echo select_tag('shared_catalogs', 
                            objects_for_select($catalogs, 'getCatId', '__toString', explode(',', $catalog->getSharedCatalogs())), 
                            array('multiple' => true, 'style' => 'width: 300px')
                        ); ?> 
  </fieldset>

  <fieldset class="actions">
    <?php echo button_to('Cancel', 'catalogue/list')  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>

